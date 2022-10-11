<?php

namespace Database\Factories;

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

        if ($recipeCount === 0) {
            throw new Exception('There are no recipes to add the ingredients to');

            return;
        }

        return [
            'name' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 800),
            'unit' => substr(fake()->word(), 0, 2),
            'recipe_id' => fake()->numberBetween(1, $recipeCount),
            'notes' => fake()->optional()->sentence(),
            'optional' => fake()->boolean(),
        ];
    }
}
