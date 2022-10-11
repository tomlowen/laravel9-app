<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            Ingredient::MORPH_KEY => Ingredient::class,
            Recipe::MORPH_KEY => Recipe::class,
            Category::MORPH_KEY => Category::class,
            Image::MORPH_KEY => Image::class,
        ]);
    }
}
