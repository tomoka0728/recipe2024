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

// プロフィール編集
Breadcrumbs::for('profile.edit', function ($trail) {
    $trail->parent('mypage', 'マイページ');
    $trail->push('アカウント情報の変更', route('profile.edit'));
});

// 名前編集
Breadcrumbs::for('profile.edit.name', function ($trail) {
    $trail->parent('profile.edit');
    $trail->push('お名前の編集', route('profile.edit.name'));
});

// メールアドレス編集
Breadcrumbs::for('profile.edit.email', function ($trail) {
    $trail->parent('profile.edit');
    $trail->push('メールアドレスの編集', route('profile.edit.email'));
});

// 誕生日編集
Breadcrumbs::for('profile.edit.birthday', function ($trail) {
    $trail->parent('profile.edit');
    $trail->push('誕生日の編集', route('profile.edit.birthday'));
});

// ニックネーム編集
Breadcrumbs::for('profile.edit.nickname', function ($trail) {
    $trail->parent('profile.edit');
    $trail->push('ニックネームの編集', route('profile.edit.nickname'));
});

// パスワード変更
Breadcrumbs::for('profile.edit.password', function ($trail) {
    $trail->parent('profile.edit');
    $trail->push('パスワードの変更', route('profile.edit.password'));
});

// 退会手続き
Breadcrumbs::for('profile.delete.confirm', function ($trail) {
    $trail->parent('mypage', 'マイページ');
    $trail->push('退会手続き', route('profile.delete.confirm'));
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

// お届け先一覧
Breadcrumbs::for('address.index', function ($trail) {
    $trail->parent('mypage', 'マイページ');
    $trail->push('お届け先の管理', route('address.index'));
});

// お届け先追加
Breadcrumbs::for('address.create', function ($trail) {
    $trail->parent('address.index');
    $trail->push('新しいお届け先を追加', route('address.create'));
});

// お届け先編集
Breadcrumbs::for('address.edit', function ($trail, $address) {
    $trail->parent('address.index');
    $trail->push('お届け先を編集', route('address.edit', $address->uuid));
});

// 購入履歴一覧
Breadcrumbs::for('purchase.history.index', function ($trail) {
    $trail->parent('mypage', 'マイページ');
    $trail->push('購入履歴', route('purchase.history.index'));
});

// 購入履歴詳細
Breadcrumbs::for('purchase.history.show', function ($trail, $purchaseHistory) {
    $trail->parent('purchase.history.index');
    $trail->push('注文詳細', route('purchase.history.show', $purchaseHistory->uuid));
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

// お問い合わせ履歴
Breadcrumbs::for('contact.history', function ($trail) {
    $trail->parent('mypage', 'マイページ');
    $trail->push('お問い合わせ履歴', route('contact.history'));
});

// お問い合わせ詳細
Breadcrumbs::for('contact.show', function ($trail, $contact) {
    $trail->parent('contact.history');
    $trail->push('お問い合わせ詳細', route('contact.show', $contact->uuid));
});
