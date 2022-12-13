<?php

namespace App\Services;

use App\Models\Recipe;
use App\Models\RecipeIngredient;

class IngredientService
{
    /**
     * Handle the update of ingredients from a recipe update
     *
     * @param array $ingredients
     * @param Recipe $recipe
     *
     * @return void
     */
    public function updateIngredients(array $ingredients, Recipe $recipe)
    {
        $newIngredients = [];
        foreach ($ingredients as $ingredient) {
            if (! $ingredient['parse']) {
                continue;
            }

            if (isset($ingredient['id'])) {
                RecipeIngredient::find($ingredient['id'])->delete();
            }

            $newIngredients[] = $ingredient['ingredient'];
        };

        app(ImportIngredientService::class)->importIngredients($newIngredients, $recipe);
    }
}
