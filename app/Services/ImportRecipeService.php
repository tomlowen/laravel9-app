<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
use Hamcrest\Type\IsString;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ImportRecipeService
{
    /**
     * Import a recipe from a URL
     *
     * @param  string  $url
     * @return array
     */
    public function getRecipeFromUrl(string $url)
    {
        $recipePage = file_get_contents($url);

        // retrieve the JSON data
        $d = new DOMDocument();
        @$d->loadHTML($recipePage);

        // parse the HTML to retrieve the "ld+json" only
        $xp = new DOMXPath($d);
        $jsonScripts = $xp->query('//script[@type="application/ld+json"]');
        $json = trim($jsonScripts->item(0)->nodeValue); // get the first script only (it should be unique anyway)
        $jsonLdScript = json_decode($json, true);

        if (isset($jsonLdScript['@type']) && $jsonLdScript['@type'] === 'Recipe') {
            $recipe = $jsonLdScript;
        }
        else {
            $sections = Arr::collapse($jsonLdScript);
            $recipe = Arr::first($sections, function ($value) {
                return $value['@type'] === 'Recipe';
            });
        }

        Log::info($recipe);

        return [
            'data' => [
                'name' => $recipe['name'] ?? null,
                'author' => self::getAuthor($recipe),
                'source' => $url,
                'description' => $recipe['description'] ?? null,
                'steps' => self::getSteps($recipe),
                'yield' => self::getYield($recipe),
                'prepTime' => isset($recipe['prepTime']) ? self::formatTime($recipe['prepTime']) : null,
                'cookTime' => isset($recipe['cookTime']) ? self::formatTime($recipe['cookTime']) : null,
                'rating' => self::getRating($recipe),
                'calories' => isset($recipe['nutrition']) ? $recipe['nutrition']['calories'] : null,
                'ingredients' => $recipe['recipeIngredient'] ?? null,
                'imageUrl' => self::getImage($recipe),
            ]
        ];
    }

    /**
     * Format the steps
     *
     * @param  array  $steps
     * @return array
     */
    public function getSteps(array $recipe)
    {
        if (!isset($recipe['recipeInstructions'])) {
            return null;
        }

        if (is_string($recipe['recipeInstructions'][0])) {
            if ($recipe['recipeInstructions'][0] === '<') {
                preg_match_all("'(?<=<li>)(.*?)(?=</li>)'si", $recipe['recipeInstructions'], $matches);
                return $matches[0];
            }

            return $recipe['recipeInstructions'];
        }

        return Arr::map($recipe['recipeInstructions'], function ($value) {
            return $value['text'];
        });
    }

    /**
     * Format a time
     *
     * @param string $time
     * @return int
     */
    public function formatTime(string $time)
    {
        // Convert from e.g. 'PT1H30M' to 90
        if (substr($time, 0, 2) === 'PT') {
            $m = preg_match('/(?<=[A-Za-z])[0-9]+(?=M)/i', $time, $mins);
            $h = preg_match('/(?<=[A-Za-z])[0-9]+(?=H)/i', $time, $hours);
            $time = 0;
            $time += $m ? (int) $mins[0] : 0;
            $time += $h ? ((int) $hours[0]) * 60 : 0;
        }

        return $time;
    }

    /**
     * Get author
     *
     * @param array $recipe
     * @return string|null
     */
    public function getAuthor(array $recipe)
    {
        if (isset($recipe['author']['name'])) {
            return $recipe['author']['name'];
        }

        return $recipe['author'][0]['name'] ?? null;
    }

    /**
     * Get image
     *
     * @param array $recipe
     * @return string|null
     */
    public function getImage(array $recipe)
    {
        if (isset($recipe['image'])) {
            $image = $recipe['image'];
        } elseif (isset($recipe['seoMetadata']['image']['url'])) {
            $image = $recipe['seoMetadata']['image']['url'];
        } else {
            return null;
        }

        if (is_string($image)) {
            return $image;
        }

        if (isset($image['url'])) {
            return $image['url'];
        }

        if (isset($image[0])) {
            return $image[0];
        }

        return null;
    }

    /**
     * Get rating
     *
     * @param array $recipe
     * @return int|null
     */
    public function getRating(array $recipe)
    {
        if (! isset($recipe['aggregateRating'])) {
            return;
        }

        $rating = (int) $recipe['aggregateRating']['ratingValue'];
        return number_format((float)$rating, 1, '.');
    }

    /**
     * Get yield
     *
     * @param array $recipe
     * @return int|null
     */
    public function getYield(array $recipe)
    {
        if (! isset($recipe['recipeYield'])) {
            return;
        }

        return (int) filter_var($recipe['recipeYield'], FILTER_SANITIZE_NUMBER_INT);
    }
}
