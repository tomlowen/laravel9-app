<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->paragraphs(),
            'steps' => fake()->text(),
            'serves' => fake()->numberBetween(2,8),
            'preparation_time' => fake()->numberBetween(5,45),
            'cooking_time' => fake()->numberBetween(0,150),
            'rating' => fake()->optional()->numberBetween(0,5),
            'calories' => fake()->optional()->numberBetween(150,550),
        ];
    }
}
