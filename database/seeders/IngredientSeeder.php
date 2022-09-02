<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\IngredientAmount;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredients = Ingredient::factory(10)->hasCategories(1)->create();

        foreach ($ingredients as $ingredient) {
            IngredientAmount::factory()->for($ingredient)->create();
        }
    }
}
