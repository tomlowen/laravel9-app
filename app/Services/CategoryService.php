<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    /**
     * Create the User's default categories
     *
     * @param User $user
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function createDefaultCategories($user)
    {
        $defaultCategories = [
            'Breakfasts',
            'Drinks',
            'Lunches',
            'Main courses',
            'Puddings & desserts',
            'Sauces & condiments',
            'Salads',
            'Vegetarian',
        ];

        foreach ($defaultCategories as $category) {
            Category::create([
                'user_id' => $user->id,
                'name' => $category,
                'slug' => Str::slug($category),
            ]);
        }
    }
}
