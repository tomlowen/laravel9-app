<?php

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('recipes')->name('recipes')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [RecipeController::class, 'index'])->name('index');
    Route::get('/create', [RecipeController::class, 'create'])->name('create');
    Route::get('/edit', [RecipeController::class, 'edit'])->name('edit');
    Route::post('/store', [RecipeController::class, 'store'])->name('store');
    Route::post('/import', [RecipeController::class, 'import'])->name('import');
    Route::get('/import', [RecipeController::class, 'create'])->name('create');
});

require __DIR__.'/auth.php';
