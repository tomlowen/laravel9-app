<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();

        // foreach ($users as $user) {
            $categories = Category::where('user_id', $user->id);

            $recipes = Recipe::factory(10)
            ->hasRecipeIngredients(5)
            ->hasImages(1)
            ->create();

            foreach ($recipes as $recipe) {
                $category = $categories->inRandomOrder()->first();
                $recipe->categories()->attach($category);
            }
        // }
    }
}
