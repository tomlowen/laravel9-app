<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Exception;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShoppingListIngredient>
 */
class ShoppingListIngredientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userCount = User::count();
        $categoryCount = Category::count();

        if ($userCount === 0 || $categoryCount === 0) {
            throw new Exception('Check that users and categories have been seeded.');

            return;
        }

        return [
            'name' => fake()->word(),
            'quantity' => fake()->numberBetween(1, 800),
            'unit' => substr(fake()->word(), 0, 2),
            'user_id' => fake()->numberBetween(1, $userCount),
            'category_id' => fake()->numberBetween(1, $categoryCount),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
