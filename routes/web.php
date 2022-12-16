<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ShoppingListIngredientController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Dashboard', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('recipes')->name('recipes.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [RecipeController::class, 'index'])->name('index');
    Route::get('/create', [RecipeController::class, 'create'])->name('create');
    Route::get('/import', [RecipeController::class, 'create'])->name('create');
    Route::get('/{recipe}/edit', [RecipeController::class, 'edit'])->name('edit');
    Route::get('/{recipe}', [RecipeController::class, 'show'])->name('show');
    Route::post('/store', [RecipeController::class, 'store'])->name('store');
    Route::post('/import', [RecipeController::class, 'import'])->name('import');
    Route::put('/{recipe}/update', [RecipeController::class, 'update'])->name('update');
    Route::delete('/{recipe}', [RecipeController::class, 'destroy'])->name('destroy');
});

Route::prefix('categories')->name('categories.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::put('/{category}/update', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
});


Route::prefix('shopping-list')->name('shopping-list.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [ShoppingListIngredientController::class, 'index'])->name('index');
    Route::put('/{shoppingListIngredient}/update', [ShoppingListIngredientController::class, 'update'])->name('update');
    Route::post('/add-ingredients', [ShoppingListIngredientController::class, 'convertRecipeIngredients'])->name('add-ingredients');
    Route::delete('/{shoppingListIngredient}', [ShoppingListIngredientController::class, 'destroy'])->name('destroy');
});

Route::prefix('lists')->name('lists.')->middleware(['auth', 'verified'])->group(function () {
    Route::delete('/', [ShoppingListIngredientController::class, 'deleteAll'])->name('delete-all');
});

Route::prefix('settings')->name('settings.')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('index');
});

require __DIR__.'/auth.php';
