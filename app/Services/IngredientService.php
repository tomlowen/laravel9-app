<?php

namespace App\Services;

use App\Http\Resources\ShoppingListIngredientResource;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\ShoppingListIngredient;
use Exception;

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

    /**
     * Handle the conversion of recipe ingredients to shopping list ingredients
     *
     * @param mixed $ingredients
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function convertIngredients(mixed $ingredients)
    {
        $shoppingListIngredients = [];

        foreach ($ingredients as $ingredient) {
            $i = RecipeIngredient::find($ingredient['id']);

            $shoppingListIngredients[] = ShoppingListIngredient::create([
                'name' => $i->name,
                'unit' => $i->unit,
                'quantity' => $i->quantity,
                'bought' => false,
                'user_id' => $i->recipe->user_id,
                'category_id' => $i->category_id,
                'notes' => $i->notes,
            ]);
        };

        return ShoppingListIngredientResource::collection($shoppingListIngredients);
    }
}
