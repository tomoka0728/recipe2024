<?php
// ホームのパンくずリスト
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Home', route('dashboard'));
});

// パスワード再設定
Breadcrumbs::for('forgot-password', function ($trail, $page) {
    $trail->parent('home');
    $trail->push($page, route('password.request'));
});
