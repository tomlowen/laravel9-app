<?php

namespace App\Services;

use App\Libraries\Spoonacular\Requests\SpoonacularParseIngredientsRequest;
use App\Models\Category;
use App\Models\RecipeIngredient;
use Illuminate\Support\Str;

class ImportIngredientService
{
    /**
     * Import ingredients list
     *
     * @param  string[]  $ingredientsList
     * @param  mixed  $ingredientable The ingredientable (recipe, cupboard) to add the ingredients to
     * @return void
     */
    public function importIngredients($ingredientsList, $ingredientable)
    {
        $spoonacularRequest = new SpoonacularParseIngredientsRequest($ingredientsList);
        $responseBody = $spoonacularRequest->parse();

        foreach ($responseBody->body as $ingredient) {
            switch ($ingredientable::class) {
                case \App\Models\Recipe::class:
                    $category = isset($ingredient->aisle) ? explode(';', $ingredient->aisle, 2)[0] : 'Online';

                    RecipeIngredient::create([
                        'name' => $ingredient->name,
                        'unit' => $ingredient->unit ?? '',
                        'quantity' => $ingredient->amount ?? '',
                        'recipe_id' => $ingredientable->id,
                        'category_id' => Category::where('name', Category::INGREDIENT_MAP[$category])->pluck('id')->first(),
                        'notes' => implode(',', $ingredient->meta),
                        'optional' => false,
                    ]);
            }
        }
    }
}
