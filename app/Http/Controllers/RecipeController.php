<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRecipeRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Models\Recipe;
use App\Services\ImportIngredientService;
use App\Services\ImportRecipeService;
use Inertia\Inertia;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Recipes/RecipesDashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Recipes/CreateRecipe');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecipeRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipeRequest $request)
    {
        $recipe = Recipe::create([
            'name' => $request['name'],
            'author' => $request['author'],
            'source' => $request['source'],
            'description' => $request['description'],
            'steps' => $request['steps'],
            'yield' => $request['yield'],
            'preparation_time' => $request['preparation_time'],
            'cooking_time' => $request['cooking_time'],
            'rating' => $request['rating'],
            'calories' => $request['calories'],
        ]);

        $importer = new ImportIngredientService;
        $importer->importIngredients($request['ingredients'], $recipe);

        return Inertia::render('Recipes/Recipe', $recipe);
    }

    /**
     * Import a recipe from a URL.
     *
     * @param  \App\Http\Requests\ImportRecipeRequest $request
     * @return \Inertia\Response
     */
    public function import(ImportRecipeRequest $request)
    {
        $recipe = app(ImportRecipeService::class)->getRecipeFromUrl($request['recipeUrl']);

        return Inertia::render('Recipes/CreateRecipe', $recipe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        return Inertia::render('Recipes/CreateRecipe', $recipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecipeRequest  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
}
