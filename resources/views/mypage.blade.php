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
                        <div class="myname">{{ Auth::user()->nickname }}様</div>
                    </div>
                    <div class="point">
                        <div class="pt"><h1><p class="num">{{ Auth::user()->points }}</p> pt</h1></div>
                        <div class="pt_s">ポイント明細</div>
                    </div>
                </div>

                <div class="menu">
                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">購入履歴</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><a href="#">配送状況の確認</a></p>
                                    <li><p class="subject"><a href="#">過去の購入履歴</a></p>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">お気に入りレシピ</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><a href="#">お気に入りレシピ閲覧・削除</a></p>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">登録情報</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><a href="#">アカウント情報の変更</a></p>
                                    <li><p class="subject"><a href="#">お届け先の追加・変更</a></p>
                                    <li><p class="subject"><a href="#">SNS連携</a></p>
                                    <li><p class="subject"><a href="{{ url('/del_acc_check') }}">退会手続き</a></p>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">お支払い方法</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><a href="#">クレジットカード</a></p>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="item">
                        <div class="item_s">
                            <h3 id="title">お問い合わせ</h3>
                            <div class="menu-s">
                                <ul>
                                    <li><p class="subject"><a href="#">よくある質問</a></p>
                                    <li><p class="subject"><a href="{{ url('/form') }}">お問い合わせフォーム</a></p>
                                    <li><p class="subject"><a href="{{ url('/form') }}">お問い合わせ履歴</a></p>
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
