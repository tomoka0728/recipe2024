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
use App\Http\Controllers\Admin\AdminRecipeController;
use App\Http\Controllers\Admin\ContactController;



// 認証不要
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// 認証必要
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/recipes/search', [AdminRecipeController::class, 'search'])->name('ingredients.search');
    Route::get('/recipes', [RecipeManageController::class, 'index'])->name('recipes.index');
    Route::get('/recipes/create', [AdminRecipeController::class, 'create'])->name('recipes.create');
    Route::post('/recipes', [AdminRecipeController::class, 'store'])->name('recipes.store');
    Route::get('/recipes/{uuid}', [AdminRecipeController::class, 'show'])->name('recipes.show');
    Route::get('/recipes/{uuid}/edit', [AdminRecipeController::class, 'edit'])->name('recipes.edit');
    Route::put('/recipes/{uuid}', [AdminRecipeController::class, 'update'])->name('recipes.update');
    Route::delete('/recipes/{uuid}', [AdminRecipeController::class, 'destroy'])->name('recipes.destroy');

    Route::get('/ingredients/create', [IngredientController::class, 'create'])->name('ingredients.create');
    Route::post('/ingredients/store', [IngredientController::class, 'store'])->name('ingredients.store');
    Route::get('/ingredients', [IngredientManageController::class, 'index'])->name('ingredients.index');
    Route::get('/ingredients/{uuid}/edit', [IngredientController::class, 'edit'])->name('ingredients.edit');
    Route::put('/ingredients/{uuid}', [IngredientController::class, 'update'])->name('ingredients.update');
    Route::delete('/ingredients/{uuid}', [IngredientManageController::class, 'destroy'])->name('ingredients.destroy');
    Route::post('/ingredients/bulk-sale', [IngredientManageController::class, 'bulkSale'])->name('ingredients.bulkSale');
    Route::delete('/ingredients/{uuid}/remove-sale', [IngredientManageController::class, 'removeSale'])->name('ingredients.removeSale');

    // お問い合わせ管理
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{uuid}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{uuid}/reply', [ContactController::class, 'sendReply'])->name('contacts.sendReply');
    Route::patch('/contacts/{uuid}/status', [ContactController::class, 'updateStatus'])->name('contacts.updateStatus');
    Route::delete('/contacts/{uuid}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});


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
