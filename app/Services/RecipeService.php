<?php

namespace App\Services;

use App\Http\Requests\StoreRecipeRequest;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class RecipeService
{
    /**
     * Create a recipe
     *
     * @param StoreRecipeRequest $request
     * @return Recipe
     */
    public function create(StoreRecipeRequest $request, User $user)
    {
        $recipe = Recipe::create([
            'name' => $request['name'],
            'user_id' => $user->id,
            'author' => $request['author'],
            'source' => $request['source'],
            'description' => $request['description'],
            'steps' => serialize($request['steps']),
            'yield' => $request['yield'],
            'preparation_time' => $request['prepTime'] ?? 0,
            'cooking_time' => $request['cookTime'] ?? 0,
            'rating' => $request['rating'],
            'calories' => $request['calories'],
        ]);

        app(ImportIngredientService::class)->importIngredients($request['ingredients'], $recipe);

        app(ImageService::class)->storeImage($request['imageUrl'], $recipe, $request['image']);

        return $recipe;
    }

    /**
     * Delete a recipe
     *
     * @param  Recipe  $recipe
     * @return void
     */
    public function delete(Recipe $recipe)
    {
        foreach ($recipe->images as $image) {
            Storage::disk($image->disk)->delete($image->filename);
            $image->delete();
        }

        $recipe->recipeIngredients->each(function($ingredient) {
            $ingredient->delete();
        });

        $recipe->tags->each(function($tag) {
            $tag->delete();
        });

        $recipe->delete();
    }
}
