<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Recipe;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RecipeIngredient>
 */
class RecipeIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $recipeCount = Recipe::count();
        $categories = Category::whereNull('user_id');

        if ($recipeCount === 0 || !$categories->exists()) {
            throw new Exception('Check that the recipe and category seeders have been run.');

            return;
        }

        return [
            'name' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 800),
            'unit' => substr(fake()->word(), 0, 2),
            'recipe_id' => fake()->numberBetween(1, $recipeCount),
            'category_id' => fake()->randomElement($categories->get()->pluck('id')),
            'notes' => fake()->optional()->sentence(),
            'optional' => fake()->boolean(),
        ];
    }
}
