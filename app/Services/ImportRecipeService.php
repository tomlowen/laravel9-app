<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;
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
        $recipe = json_decode($json);

        Log::info($json);

        return [
            'data' => [
                'name' => $recipe->name ?? null,
                'author' => $recipe->author->name ?? null,
                'source' => $url,
                'description' => $recipe->description ?? null,
                'steps' => $recipe->recipeInstructions ? $recipe->recipeInstructions : null,
                'yield' => $recipe->recipeYield ?? null,
                'prepTime' => isset($recipe->prepTime) ? self::formatTime($recipe->prepTime) : null,
                'cookTime' => isset($recipe->cookTime) ? self::formatTime($recipe->cookTime) : null,
                'rating' => isset($recipe->aggregateRating) ? $recipe->aggregateRating->ratingValue : null,
                'calories' => isset($recipe->nutrition) ? $recipe->nutrition->calories : null,
                'ingredients' => $recipe->recipeIngredient ?? null,
                'imageUrl' => self::getImage($recipe),
            ]
        ];
    }

    // /**
    //  * Format the steps
    //  *
    //  * @param  array  $steps
    //  * @return array
    //  */
    // public function formatSteps(array $steps)
    // {
    //     return $steps;
    // }

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
     * Get image
     *
     * @param object $recipe
     * @return string|null
     */
    public function getImage(object $recipe)
    {
        if (isset($recipe->image)) {
            $image = $recipe->image;
        } elseif (isset($recipe->seoMetadata->image->url)) {
            $image = $recipe->seoMetadata->image->url;
        } else {
            return null;
        }

        if (is_string($image)) {
            return $image;
        }

        if (is_object($image)) {
            return $image->url;
        }

        if (is_array($image)) {
            return $image[0];
        }
    }
}
