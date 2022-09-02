<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IngredientAmount>
 */
class IngredientAmountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'value' => fake()->numberBetween(1,10),
            'measure' => fake()->word(),
            'ingredient_id' => fake()->numberBetween(1,10),
        ];
    }
}
