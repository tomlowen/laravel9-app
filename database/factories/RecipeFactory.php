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
            'author' => fake()->name(),
            'source' => fake()->url(),
            'description' => fake()->paragraph(),
            'steps' => serialize(fake()->sentences()),
            'yield' => fake()->numberBetween(2,8),
            'preparation_time' => 'PT' . fake()->optional()->numberBetween(5,45) . 'M',
            'cooking_time' => 'PT' . fake()->optional()->numberBetween(0,150)  . 'M',
            'rating' => fake()->optional()->randomFloat(1,0,5),
            'calories' => fake()->optional()->numberBetween(150,550),
        ];
    }
}
