<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Imageable models
     */
    const IMAGEABLES = [
        Category::MORPH_KEY,
        Ingredient::MORPH_KEY,
        Recipe::MORPH_KEY,
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->word(),
            'type' => fake()->fileExtension(),
            'filename' => fake()->uuid() . 'png',
            'order' => fake()->numberBetween(1, 10),
            'imageable_id' => fake()->numberBetween(1, 10),
            'imageable_type' => fake()->randomElement(self::IMAGEABLES),
        ];
    }
}
