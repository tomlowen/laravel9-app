<?php

namespace Database\Seeders;

use App\Models\RecipeIngredient;
use App\Models\IngredientAmount;
use Illuminate\Database\Seeder;

class RecipeIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecipeIngredient::factory(50)->create();
    }
}
