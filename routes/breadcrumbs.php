<?php
// ホームのパンくずリスト
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('top'));
});

// パスワード再設定
Breadcrumbs::for('forgot-password', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page, route('password.request'));
});

// マイページ
Breadcrumbs::for('mypage', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page, route('mypage'));
});

// カート
Breadcrumbs::for('cart', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page, route('cart.show'));
});

// // レシピ一覧のパンくずリスト
// Breadcrumbs::for('recipes.index', function ($trail) {
//     $trail->parent('home');
//     $trail->push('レシピ一覧', route('recipes.index'));
// });

// // レシピ詳細ページのパンくずリスト
// Breadcrumbs::for('recipes.show', function ($trail, $recipe) {
//     $trail->parent('recipes.index');
//     $trail->push($recipe->title, route('recipes.show', ['uuid' => $recipe->uuid]));
// });
