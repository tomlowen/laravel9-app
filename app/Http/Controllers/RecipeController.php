<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRecipeRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\RecipeResource;
use App\Models\Category;
use App\Models\Recipe;
use App\Services\ImportRecipeService;
use App\Services\RecipeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return Redirect::route('login');
        }

        $collection = Recipe::where('user_id', $user->id)->get();
        $categories = Category::where('user_id', $user->id)->get();
        $recipes = [];

        foreach ($collection as $recipe) {
            $recipe->load([
                'categories',
                'images',
            ]);
            $recipes[] = $recipe;
        }

        return Inertia::render('Recipes/RecipesDashboard', [
            'recipes' => RecipeResource::collection($recipes),
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return Redirect::route('login');
        }

        $categories = Category::where('user_id', $user->id)->get();

        return Inertia::render('Recipes/CreateRecipe', [
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecipeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipeRequest $request)
    {
        $user = $request->user();

        if(!$user) {
            abort(404);
        }

        $recipe = app(RecipeService::class)->create($request, $user);

        return Redirect::route('recipes.show', ['recipe' => $recipe->id], 303);
    }

    /**
     * Import a recipe from a URL.
     *
     * @param  \App\Http\Requests\ImportRecipeRequest  $request
     * @return \Inertia\Response
     */
    public function import(ImportRecipeRequest $request)
    {
        $user = $request->user();

        if (!$user) {
            return Redirect::route('login');
        }

        $recipe = app(ImportRecipeService::class)->getRecipeFromUrl($request['recipeUrl']);
        $categories = Category::where('user_id', $user->id)->get();

        return Inertia::render('Recipes/CreateRecipe', [
            'recipe' => $recipe,
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Recipe $recipe)
    {
        $user = $request->user();

        if (!$user) {
            return Redirect::route('login');
        }

        if($user->id != $recipe->user_id) {
            abort(404);
        }

        $recipe->load([
            'categories',
            'images',
            'recipeIngredients',
        ]);

        return Inertia::render('Recipes/Recipe', [
                'recipe' => new RecipeResource($recipe),
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Recipe $recipe)
    {
        $user = $request->user();

        if (!$user) {
            return Redirect::route('login');
        }

        if($user->id != $recipe->user_id) {
            abort(404);
        }

        $recipe->load([
            'recipeIngredients',
            'images',
            'categories'
        ]);

        $categories = Category::where('user_id', $user->id)->get();

        return Inertia::render('Recipes/CreateRecipe', [
            'recipe' => new RecipeResource($recipe),
            'categories' => CategoryResource::collection($categories),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecipeRequest  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRecipeRequest $request, Recipe $recipe)
    {
        $recipe = Recipe::findOrFail($recipe->id);
        $user = $request->user();

        if (!$user) {
            return Redirect::route('login');
        }

        if($user->id != $recipe->user_id) {
            abort(404);
        }

        $recipe = app(RecipeService::class)->update($request, $user);

        return Redirect::route('recipes.show', ['recipe' => $recipe->id], 303);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Recipe $recipe)
    {
        if($request->user()->id != $recipe->user_id) {
            abort(404);
        }

        app(RecipeService::class)->delete($recipe);

        return Redirect::route(
            'recipes.index',
            [],
            303
        );
    }
}
