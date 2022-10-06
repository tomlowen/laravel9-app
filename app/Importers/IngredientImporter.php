<?php

namespace App\Importers;

use App\Libraries\Spoonacular\Requests\SpoonacularParseIngredientsRequest;
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
        $spoonacularRequest = new SpoonacularParseIngredientsRequest($ingredientsList);
        $responseBody = $spoonacularRequest->parse();

        foreach($responseBody->body as $ingredient) {
            switch ($ingredientable::class) {
                case \App\Models\Recipe::class:
                    RecipeIngredient::create([
                        'name' => $ingredient->name,
                        'unit' => $ingredient->unit,
                        'quantity' => $ingredient->amount,
                        'recipe_id' => $ingredientable->id,
                        'notes' => implode(',', $ingredient->meta),
                        'optional' => false
                    ]);
            }
        }
    }
}
