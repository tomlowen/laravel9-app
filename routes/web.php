<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RecipeController;
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

require __DIR__.'/auth.php';
