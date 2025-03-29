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

// TOP
Route::get('/', [HomeController::class, 'index'])->name('top');
Route::get('/', function () {
    return view('admin.dashboard');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
Route::get('/mypage', [MypageController::class, 'show'])->name('mypage');
Route::get('/recipes/{uuid}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/ingredients/{uuid}', [IngredientsController::class, 'show'])->name('ingredients.show');
Route::get('/ranking/{category?}', [RankingController::class, 'show'])->name('ranking.show');

//カート
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::get('/payment', [PaymentController::class, 'show'])->name('payment.show');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
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
