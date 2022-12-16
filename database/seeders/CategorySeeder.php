<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Services\CategoryService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    const INGREDIENT_CATEGORIES = [
        'Bakery',
        'Baking',
        'Cans & Jars',
        'Cereal',
        'Condiments',
        'Confectionary',
        'Dairy',
        'Drinks',
        'Ethnic Foods',
        'Fridge',
        'Frozen',
        'Gluten Free',
        'Gourmet',
        'Health Foods',
        'Meat & Fish',
        'Miscellaneous',
        'Pasta & Rice',
        'Produce',
        'Snacks',
        'Spices',
        'Spreads',
        'Tea & Coffee',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();

        foreach ($users as $user) {
            app(CategoryService::class)->createDefaultCategories($user);
        }

        foreach (self::INGREDIENT_CATEGORIES as $category) {
            Category::create([
                'user_id' => null,
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
