<?php

namespace App\Importers;

use App\Models\Ingredient;
use App\Services\IngredientService;
use Exception;

class IngredientImporter
{
    /**
     * Import ingredients list
     *
     * @param string[] $ingredientsList
     * @param int $ingredientableId The id of the ingredientable (recipe) to add the ingredients to
     * @return int
     */
    public function importIngredients($ingredientsList, $ingredientableId){
        $ingredientService = new IngredientService;

        foreach($ingredientsList as $ingredient) {
            $parsedIngredient = $ingredientService->parseIngredient($ingredient);
            $dbIngredient = Ingredient::create([
                'name' => $parsedIngredient['name'],
                'default_measure' => $parsedIngredient['unit'],
                'notes',
                'optional'
            ]);
        }
    }
}
