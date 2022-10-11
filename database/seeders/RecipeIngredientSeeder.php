<?php

namespace Database\Seeders;

use App\Models\RecipeIngredient;
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
