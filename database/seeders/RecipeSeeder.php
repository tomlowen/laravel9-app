<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Recipe;
use App\Models\Ingredient;
use App\Models\IngredientAmount;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Recipe::factory(10)->hasCategories(1)->hasIngredients(5)->create();

        $ingredients = Ingredient::whereHas('recipes');

        foreach ($ingredients as $ingredient) {
            IngredientAmount::factory()->for($ingredient)->create();
        }
    }
}
