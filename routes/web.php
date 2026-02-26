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
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\SpecialFeatureController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\PointHistoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookmarkController;


// TOP
Route::get('/', [HomeController::class, 'index'])->name('top');
Route::get('/special-feature', [SpecialFeatureController::class, 'index'])->name('special-feature');
Route::get('/column', [ColumnController::class, 'index'])->name('column');
Route::get('/membership/silver', [MembershipPlanController::class, 'silver'])->name('membership.silver');
Route::get('/membership/gold', [MembershipPlanController::class, 'gold'])->name('membership.gold');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

// お問い合わせ
Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact/edit', [ContactController::class, 'edit'])->name('contact.edit');
Route::post('/contact/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/complete', [ContactController::class, 'complete'])->name('contact.complete');

// ログイン必須のお問い合わせ関連ルート
Route::middleware(['auth'])->group(function () {
    Route::get('/contact/history', [ContactController::class, 'history'])->name('contact.history');
    Route::get('/contact/{uuid}', [ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact/{uuid}/reply', [ContactController::class, 'sendReply'])->name('contact.sendReply');
});

Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/category/{category}', [RecipeController::class, 'category'])->name('recipes.category');
Route::get('/recipes/{uuid}', [RecipeController::class, 'show'])->name('recipes.show');
Route::get('/ingredients', [IngredientsController::class, 'index'])->name('ingredients.index');
Route::get('/ingredients/add', [IngredientsController::class, 'add'])->name('ingredients.add');
Route::get('/ingredients/{uuid}', [IngredientsController::class, 'show'])->name('ingredients.show');
Route::get('/ranking/{category?}', [RankingController::class, 'show'])->name('ranking.show');
Route::get('/ranking/{category?}/add', [RankingController::class, 'add'])->name('ranking.add');

Route::get('/ranking/redirect', [RankingController::class, 'redirect'])->name('ranking.redirect');
Route::get('/ranking/more', [RankingController::class, 'more'])->name('recipes.ranking.more');
Route::get('/membership/promotion', function () {
    return view('membership.promotion'); // プレミアム案内ページ
})->name('membership.promotion');
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [MypageController::class, 'show'])->name('mypage');
    Route::get('/membership/upgrade', [MembershipController::class, 'edit'])->name('membership.edit');
    Route::post('/membership/upgrade', [MembershipController::class, 'update'])->name('membership.update');
    Route::get('/points', [PointHistoryController::class, 'index'])->name('points.history');

    // 購入履歴
    Route::get('/purchase-history', [App\Http\Controllers\PurchaseHistoryController::class, 'index'])->name('purchase.history.index');
    Route::get('/purchase-history/{uuid}', [App\Http\Controllers\PurchaseHistoryController::class, 'show'])->name('purchase.history.show');

    // ブックマーク（書き込み系）
    Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
    Route::get('/bookmarks/check', [BookmarkController::class, 'check'])->name('bookmarks.check');
});

// ブックマーク（読み込み系、ログインしていない場合はモーダル表示）
Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
Route::get('/bookmarks/recipes', [BookmarkController::class, 'recipes'])->name('bookmarks.recipes');
Route::get('/bookmarks/ingredients', [BookmarkController::class, 'ingredients'])->name('bookmarks.ingredients');

//カート
Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::get('/payment', [PaymentController::class, 'show'])->name('payment.show');
Route::get('/payment/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
Route::post('/payment/confirm', [PaymentController::class, 'confirm'])->name('payment.confirm');
Route::get('/payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add'); //カートへ追加するAPI
Route::patch('/cart/update', [CartController::class, 'update'])->name('cart.update'); //カートの数量を更新するAPI
Route::delete('/cart/remove/{ingredientUuid}', [CartController::class, 'remove'])->name('cart.remove');

//あとで買う機能
Route::post('/save-for-later/{ingredientUuid}', [CartController::class, 'saveForLater'])->name('save.for.later');
Route::get('/save-for-later', [CartController::class, 'showSaveForLater'])->name('save.for.later.show');
Route::delete('/save-for-later/{ingredientUuid}', [CartController::class, 'removeSaveForLater'])->name('save.for.later.remove');
Route::post('/move-to-cart/{ingredientUuid}', [CartController::class, 'moveToCart'])->name('move.to.cart');


//住所登録
Route::middleware(['web'])->group(function () {
    Route::post('/address/confirm', [AddressController::class, 'confirm'])->name('address.confirm');
    Route::post('/address/complete', [AddressController::class, 'complete'])->name('address.complete');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/edit/basic', [ProfileController::class, 'editBasic'])->name('profile.edit.basic');
    Route::get('/profile/edit/name', [ProfileController::class, 'editName'])->name('profile.edit.name');
    Route::get('/profile/edit/email', [ProfileController::class, 'editEmail'])->name('profile.edit.email');
    Route::get('/profile/edit/birthday', [ProfileController::class, 'editBirthday'])->name('profile.edit.birthday');
    Route::get('/profile/edit/nickname', [ProfileController::class, 'editNickname'])->name('profile.edit.nickname');
    Route::get('/profile/edit/password', [ProfileController::class, 'editPassword'])->name('profile.edit.password');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/del_acc_check', [ProfileController::class, 'deleteConfirm'])->name('profile.delete.confirm');

    // 住所管理
    Route::get('/address', [AddressController::class, 'index'])->name('address.index');
    Route::get('/address/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::get('/address/{uuid}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::patch('/address/{uuid}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/address/{uuid}', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::post('/address/{uuid}/set-default', [AddressController::class, 'setDefault'])->name('address.setDefault');
});

require __DIR__.'/auth.php';

// Language Switcher Route
Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
});
