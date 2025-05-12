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

// シルバー
Breadcrumbs::for('silver', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page, route('membership.silver'));
});

// ゴールド
Breadcrumbs::for('gold', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page, route('membership.gold'));
});

// 会員グレード変更
Breadcrumbs::for('membership.edit', function ($trail, $page) {
    $trail->parent('mypage', 'マイページ'); // マイページを親として追加
    $trail->push($page, route('membership.edit'));
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
