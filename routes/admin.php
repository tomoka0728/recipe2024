<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MypageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\RecipeManageController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\IngredientManageController;



Route::prefix('admin')
    ->name('admin.')
    ->middleware('web')
    ->group(function () {
        Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::middleware(['auth:admin'])->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        });
    });

Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    Route::get('/recipes', [RecipeManageController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [RecipeManageController::class, 'create'])->name('recipes.create');
    Route::get('/recipes/{uuid}/edit', [RecipeManageController::class, 'edit'])->name('recipes.edit');
    Route::delete('/recipes/{uuid}', [RecipeManageController::class, 'destroy'])->name('recipes.destroy');
    Route::get('/ingredients/create', [IngredientController::class, 'create'])->name('ingredients.create');
    Route::post('/ingredients/store', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::get('/ingredients', [IngredientManageController::class, 'index'])->name('ingredients.index');
    Route::get('/ingredients/{uuid}/edit', [IngredientManageController::class, 'edit'])->name('ingredients.edit');
    Route::delete('/ingredients/{uuid}', [IngredientManageControllerIngredientManageController::class, 'destroy'])->name('ingredients.destroy');
});




Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/mypage', [MypageController::class, 'show'])->name('mypage');
Route::get('/recipes/{uuid}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/ingredients/{uuid}', [IngredientsController::class, 'show'])->name('ingredients.show');
Route::get('/ranking/{category?}', [RankingController::class, 'show'])->name('ranking.show');

Route::middleware('auth:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/adminAuth.php';

// Language Switcher Route 言語切替用ルートだよ
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
});
