<?php

namespace App\Services;

use App\Models\Recipe;
use DOMDocument;
use DOMXPath;
use Exception;
use Illuminate\Support\Facades\DB;

class ImportRecipeService
{
    /**
     * Import a recipe from a URL
     *
     * @param string $url
     * @return Exception|Recipe
     */
    public function import(string $url)
    {
        $recipe = self::getJsonLdScriptFromHtml($url);

        try {
            DB::beginTransaction();

            $dbRecipe = Recipe::create([
                'name' => $recipe->name,
                'author' => $recipe->author->name,
                'source' => $url,
                'description' => $recipe->description,
                'steps' => serialize($recipe->recipeInstructions),
                'yield' => $recipe->recipeYield ? filter_var($recipe->recipeYield, FILTER_SANITIZE_NUMBER_INT) : 0,
                'preparation_time' => $recipe->prepTime ?? null,
                'cooking_time' => $recipe->cookTime ?? null,
                'rating' => isset($recipe->aggregateRating) ? $recipe->aggregateRating->ratingValue : null,
                'calories' => isset($recipe->nutrition) ? filter_var($recipe->nutrition->calories, FILTER_SANITIZE_NUMBER_INT) : null,
            ]);

            app(ImportIngredientService::class)->importIngredients($recipe->recipeIngredient, $dbRecipe);

            DB::commit();

            return $dbRecipe;
        } catch (Exception $e) {
            DB::rollback();

            return $e;
        }
    }

    /**
     * Parse the html for the json+ld schema
     *
     * @param string $url
     * @return object
     */
    public function getJsonLdScriptFromHtml(string $url)
    {
        $recipePage = file_get_contents($url);

        // retrieve the JSON data
        $d = new DOMDocument();
        @$d->loadHTML($recipePage);

        // parse the HTML to retrieve the "ld+json" only
        $xp = new DOMXPath($d);
        $jsonScripts = $xp->query('//script[@type="application/ld+json"]');
        $json = trim($jsonScripts->item(0)->nodeValue); // get the first script only (it should be unique anyway)

        return json_decode($json);
    }
}
