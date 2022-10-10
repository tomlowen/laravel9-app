<?php

namespace App\Services;

use DOMDocument;
use DOMXPath;

class ImportRecipeService
{
    /**
     * Import a recipe from a URL
     *
     * @param string $url
     * @return Array
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

        return [
            'name' => $recipe->name ?? null,
            'author' => $recipe->author->name ?? null,
            'source' => $url,
            'description' => $recipe->description ?? null,
            'steps' => $recipe->recipeInstructions ?? null,
            'yield' => $recipe->recipeYield ?? null,
            'preparation_time' => $recipe->prepTime ?? null,
            'cooking_time' => $recipe->cookTime ?? null,
            'rating' => isset($recipe->aggregateRating) ? $recipe->aggregateRating->ratingValue : null,
            'calories' => isset($recipe->nutrition) ? $recipe->nutrition->calories : null,
            'ingredients' => $recipe->recipeIngredient ?? null
        ];
    }
}
