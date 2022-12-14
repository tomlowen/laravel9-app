<?php

namespace Database\Seeders;

use App\Models\ShoppingListIngredient;
use Illuminate\Database\Seeder;

class ShoppingListIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShoppingListIngredient::factory(50)->create();
    }
}
