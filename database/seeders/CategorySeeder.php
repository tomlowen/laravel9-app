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
        'Meat & Fish',
        'Fruit',
        'Vegetables',
        'Herbs & Spices',
        'Food Cupboard'
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
