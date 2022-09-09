<?php

namespace App\Importers;

use App\Util\JsonValidator;
use App\Models\Recipe;
use Exception;

class RecipeImporter
{
    /**
     * Import json recipe
     *
     * @param string $recipe Recipe file as json string
     * @return bool
     */
    public function importRecipe($string) {
        if (!JsonValidator::isJsonValid($string)) {
            throw new Exception("Recipe is not in the correct format");
        }

        $recipe = json_decode($string);

        $dbRecipe = Recipe::create([
            'name' => $recipe->name,
            'author' => $recipe->author->name,
            'source' => '',
            'description' => $recipe->description,
            'steps' => serialize($recipe->recipeInstructions),
            'yield' => filter_var($recipe->recipeYield, FILTER_SANITIZE_NUMBER_INT),
            'preparation_time' => $recipe->prepTime,
            'cooking_time' => $recipe->cookTime,
            'rating' => $recipe->aggregateRating->ratingValue,
            'calories' => filter_var($recipe->nutrition->calories, FILTER_SANITIZE_NUMBER_INT),
        ]);

        $importer = new IngredientImporter;
        $importer->importIngredients($recipe->recipeIngredient, $dbRecipe);
    }
}
