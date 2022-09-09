<?php

namespace App\Importers;

use App\Models\Ingredient;
use App\Models\RecipeIngredient;
use App\Services\IngredientService;
use Exception;

class IngredientImporter
{
    /**
     * Import ingredients list
     *
     * @param string[] $ingredientsList
     * @param mixed $ingredientable The ingredientable (recipe, cupboard) to add the ingredients to
     * @return int
     */
    public function importIngredients($ingredientsList, $ingredientable){
        $ingredientService = new IngredientService;

        foreach($ingredientsList as $ingredient) {
            $parsedIngredient = $ingredientService->parseIngredient($ingredient);

            switch ($ingredientable::class) {
                case \App\Models\Recipe::class:
                    RecipeIngredient::create([
                        'name' => $parsedIngredient['name'],
                        'unit' => $parsedIngredient['unit'],
                        'quantity' => $parsedIngredient['quantity'],
                        'recipe_id' => $ingredientable->id,
                        'notes',
                        'optional'
                    ]);
            }
        }
    }
}
