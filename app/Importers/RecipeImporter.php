<?php

namespace App\Importers;

use App\Util\JsonValidator;
use App\Models\Recipe;
use Exception;
use Illuminate\Support\Facades\DB;

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

        try {
            DB::beginTransaction();

            $dbRecipe = Recipe::create([
                'name' => $recipe->name,
                'author' => $recipe->author->name,
                'source' => '',
                'description' => $recipe->description,
                'steps' => serialize($recipe->recipeInstructions),
                'yield' => $recipe->recipeYield ? filter_var($recipe->recipeYield, FILTER_SANITIZE_NUMBER_INT) : 0,
                'preparation_time' => $recipe->prepTime ?? null,
                'cooking_time' => $recipe->cookTime ?? null,
                // 'rating' => $recipe->aggregateRating ? $recipe->aggregateRating->ratingValue : null,
                // 'calories' => $recipe->nutrition ? filter_var($recipe->nutrition->calories, FILTER_SANITIZE_NUMBER_INT) : null,
            ]);

            $importer = new IngredientImporter;
            $importer->importIngredients($recipe->recipeIngredient, $dbRecipe);

            DB::commit();

            return $dbRecipe;
        } catch (Exception $e) {
            DB::rollback();

            return $e;
        }
    }
}
