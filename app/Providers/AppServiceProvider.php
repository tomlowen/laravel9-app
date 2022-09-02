<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\Category;

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
        ]);
    }
}
