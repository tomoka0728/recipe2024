<p align="center">
  <img src="https://github.com/user-attachments/assets/b8d3dd7c-8eea-4dff-879a-2ab2d4bbc956" alt="logo" width="100">
</p>

<p align="center">
<img src="https://img.shields.io/badge/-PHP8.2-5ca8e6.svg?logo=php&style=popout-square"> <img src="https://img.shields.io/badge/-Laravel11-ff6666.svg?logo=laravel&style=popout-square"> <img src="https://img.shields.io/badge/-HTML5-ffb3b3.svg?logo=html5&style=popout-square"> <img src="https://img.shields.io/badge/-CSS-1572B6.svg?logo=css&style=popout-square"> <img src="https://img.shields.io/badge/-tailwindcss-ccf7ff.svg?logo=tailwindcss&style=popout-square"> <img src="https://img.shields.io/badge/-Javascript-f7efad.svg?logo=javascript&style=popout-square"> <img src="https://img.shields.io/badge/-Mysql-7aa9cc.svg?logo=mysql&style=popout-square"></p>
<p align="center">
<img src="https://img.shields.io/badge/-Linux-e6e6e6.svg?logo=linux&style=popout-square"> <img src="https://img.shields.io/badge/-Ubuntu-e8a48b.svg?logo=ubuntu&style=popout-square"> <img src="https://img.shields.io/badge/-Docker-1488C6.svg?logo=docker&style=popout-square"> <img src="https://img.shields.io/badge/-Nginx-269539.svg?logo=nginx&style=popout-square"> <img src="https://img.shields.io/badge/-Amazon%20aws-232F3E.svg?logo=amazon-aws&style=popout-square"> <img src="https://img.shields.io/badge/-VScode-007ACC.svg?logo=visualstudiocode&style=popout-square"> <img src="https://img.shields.io/badge/-Canva-ccf7ff.svg?logo=canva&style=popout-square">
</p>

## 📑 目次

- [概要](#概要)
- [システム構成](#システム構成)
- [主要機能](#主要機能)
- [購入フロー](#購入フロー)
- [会員システムの仕組み](#会員システムの仕組み)
- [工夫したポイント](#工夫したポイント)
- [苦労した点・技術課題](#苦労した点技術課題)
- [アーキテクチャ思想](#アーキテクチャ思想)
- [画面イメージ](#画面イメージ)


## ■ 概要

本システムは、**レシピ閲覧から材料購入までをワンストップで提供する**  
レシピ共有型ECサイトです。

従来のレシピサイトとECサイトを分離していた課題を解決し、  
**「作りたい」から「すぐ作れる」へ** をシームレスに実現しています。

### 解決する課題

- レシピと冷蔵庫を何度も確認しながら買い物リストを考える手間
- 珍しい調味料の使い道がわからず購入を躊躇する問題
- 大量のレシピ情報の中から信頼できるものを選ぶ難しさ
- 買い物時間の確保が困難で料理自体が億劫になる状況

### 主要な特徴

- レシピページから材料を**ワンクリックでカートに追加**
- ゴールド会員のみがレシピ投稿可能な**品質保証システム**
- 珍しい材料には**関連レシピを自動表示**し無駄を防止
- Stripe決済による**安全な購入体験**


## ■ システム構成

- バックエンド：Laravel 11
- データベース：MySQL
- フロントエンド：
  - Blade（テンプレートエンジン）
  - Tailwind CSS
  - JavaScript（Vanilla）
- 決済：
  - Stripe API（クレジットカード決済）
- メール：
  - Laravel Mail（購入確認、問い合わせ通知）
- インフラ：
  - Docker（開発環境）
  - Nginx（Webサーバー）
- その他：
  - パンくずリスト（diglactic/laravel-breadcrumbs）
  - ポイントシステム（購入金額の5%還元）


## ■ 主要機能

### ① レシピ閲覧・検索

- カテゴリ別検索（和食・洋食・中華など）
- 人気順ソート（有料会員のみ）
- レシピ詳細表示（材料・手順・調理時間）


### ② EC機能

- カート管理（商品追加・削除・数量変更）
- レシピから材料を直接カート追加
- 配送先住所管理（複数登録可能）
- Stripe決済統合
- ポイント利用・付与


### ③ 会員システム

- 無料会員：レシピ閲覧・購入機能
- ゴールド会員：
  - レシピ投稿権限
  - 人気順検索機能
  - 月額制（自動更新）


### ④ 管理者機能

- レシピ・材料・ユーザー管理
- 問い合わせ対応
- 注文履歴・売上管理
- 操作ログ記録（AdminLog）


## ■ 購入フロー

商品購入は以下の流れで処理されます。

1. カートに商品を追加
2. 配送先住所を選択または新規登録
3. ポイント利用の選択
4. Stripe決済画面で支払い
5. 購入完了メール送信

### 決済処理の工夫

- Stripe Checkout Session方式で安全な決済
- 決済失敗時の自動ロールバック
- ポイント履歴の透明性確保
- 購入履歴の詳細記録


## ■ 会員システムの仕組み

### 有料会員の管理

- Stripeのサブスクリプション連携
- 自動更新・解約処理
- ステータス管理（General / Silver / Gold）
- 権限ベースの機能制限

### ポイントシステム

- 購入金額の3~5%をポイント付与
- 1ポイント = 1円で利用可能
- PointHistoryモデルで履歴管理
- 有効期限なし


## ■ 工夫したポイント

### ① UX最適化

- レシピから材料をワンクリック追加
- 「後で購入」機能で購買の障壁を低減
- 珍しい材料には関連レシピを自動表示
- パンくずリストで現在位置を明確化


### ② 品質保証とコミュニティ

- ゴールド会員のみレシピ投稿可能
- 有料会員という障壁により低品質レシピを防止
- 投稿者の責任感を担保


### ③ 保守性・拡張性

- Enumによる定数管理（CategoryGroup / MembershipStatus）
- Observerパターンでビジネスロジックを分離
- Requestクラスによるバリデーション集約
- 管理者操作ログの自動記録


### ④ セキュリティ

- Stripe決済で機密情報を自社サーバーに保持しない
- 管理者ログイン画面の分離（/admin/login）
- CSRF保護・XSS対策
- パスワードハッシュ化（bcrypt）


## ■ 苦労した点・技術課題

- レシピと材料の多対多リレーションの設計
- Stripe決済とポイントシステムの整合性確保
- 有料会員のサブスクリプション状態管理
- 管理者機能の権限設計と操作ログの粒度調整
- 画像アップロード・保存の最適化


## ■ アーキテクチャ思想

- MVCパターンによる責務分離
- Eloquent ORMによる宣言的なデータ操作
- Stripe APIで決済ロジックを外部委譲
- Enumで状態管理を型安全に実装
- メール送信を非同期処理化（Queue対応可能な設計）

**レシピ発見 → 材料購入 → 調理** を一連の体験として設計し、  
購買におけるあらゆる摩擦を排除した統合型ECプラットフォーム。


---


## ■ 画面イメージ

### TOPページ

<img src="https://github.com/user-attachments/assets/1bc6b37e-b1d8-48b7-af1f-e6fc7ca9eca5" alt="top">

トップページではレシピ一覧と各種検索機能を表示。


### レシピページ

<img src="https://github.com/user-attachments/assets/6206e7fe-9e3c-432c-9406-490360707e86" alt="recipe">

作りたいレシピを一覧から選択。カテゴリ検索や人気順（有料会員のみ）での絞り込みが可能。  
材料名をクリックすると直接カートに追加できます。


### カート・購入フロー

<img src="https://github.com/user-attachments/assets/024b3789-324b-4703-aca5-08c7abf0b07c" alt="cart">

<img src="https://github.com/user-attachments/assets/e107c024-8b76-4896-95b2-9e16e16b6434" alt="checkout">

<img src="https://github.com/user-attachments/assets/a636fb5e-3cf0-4f30-a969-1d9fef94aab3" alt="complete">

カート内容の確認から配送先指定、Stripe決済、購入完了までをスムーズに実行。


### メール通知

<img src="https://github.com/user-attachments/assets/53f782b4-d942-478a-b56a-49ef054c5760" alt="mail">

購入完了時、問い合わせ受付時などに自動メール送信。


### 管理者ページ

<img src="https://github.com/user-attachments/assets/c971e22c-937e-4880-9262-6bfac6cd34c3" alt="admin">

レシピ・材料・ユーザー・注文の一元管理。操作ログも自動記録されます。


