@extends('layouts.app')
@section('content')
{{ Breadcrumbs::render('mypage','マイページ') }}
<x-guest-layout>
    <div id="container" class="wrapper">
        <main>
            <article>
                <div class="title">
                    <div class="title">マイページ</div>
                </div>
                <div class="top">
                    <div class="a">
                        <div class="myname">{{ Auth::check() ? Auth::user()->nickname : 'ゲスト' }}様</div>
                    </div>
                    <div class="point">
                        <div class="pt"><h1><p class="num">{{ Auth::check() ? Auth::user()->points : 0 }}</p> pt</h1></div>
                        <div class="pt_s"><a href="{{ route('points.history') }}">ポイント明細</a></div>
                    </div>
                </div>

                <div class="menu">
                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">購入履歴</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><span class="disabled-link">配送状況の確認</span></p>
                                    <li><p class="subject"><a href="{{ route('purchase.history.index') }}">過去の購入履歴</a></p>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">お気に入りレシピ</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><span class="disabled-link">お気に入りレシピ閲覧・削除</span></p>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">登録情報</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><a href="{{ route('profile.edit') }}">アカウント情報の変更</a></p>
                                    <li><p class="subject"><a href="{{ route('address.index') }}">お届け先の追加・変更</a></p>
                                    <li><p class="subject"><span class="disabled-link">SNS連携</span></p>
                                    <li><p class="subject"><a href="{{ route('profile.delete.confirm') }}">退会手続き</a></p>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">お支払い方法</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><span class="disabled-link">クレジットカード</span></p>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">お問い合わせ</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><span class="disabled-link">よくある質問</span></p>
                                    <li><p class="subject"><a href="{{ url('/form') }}">お問い合わせフォーム</a></p>
                                    <li><p class="subject"><span class="disabled-link">お問い合わせ履歴</span></p>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">会員グレード</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><a href="{{ route('membership.edit') }}">会員グレードの確認・変更</a></p>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
            <img src="{{ asset('img/cm3.png') }}" alt="" class="cm">
        </main>
    </div>
</x-guest-layout>

@endsection
@push('styles')
    @vite(['resources/css/mypage.css'])
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="js/recipetop.js"></script>
<script src="js/top.js"></script>
@endpush
