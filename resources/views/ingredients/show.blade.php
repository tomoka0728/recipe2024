@extends('layouts.app')
@section('content')

<x-guest-layout>

    <div id="container" class="wrapper">
        <main>
            <div class="item">
                <div class="item_img">
                    <img src="{{ Storage::disk('s3')->url($ingredient->image_path) }}" alt="">
                </div>
                <div class="item2">
                    <div class="item_title">
                        <p><h1>{{ $ingredient->name }}</h1></p>
                    </div>
                    <div class="item3">
                        <form class="cart-form" data-uuid="{{ $ingredient->uuid }}">
                            @csrf
                        <div>
                            <label for="quantity">数量:</label>
                            <select name="num" class="quantity-select" data-price="{{ $ingredient->price }}" data-tax-price="{{ $ingredient->price * 1.08 }}">
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" >{{ $i }}</option>
                                @endfor
                            </select>&nbsp;&nbsp;
                        </div>
                        <div class="item_info">
                            <p><h1 class="price">{{ number_format($ingredient->price) }}円</h1></p>
                            <p class="total-price">(税込み <span class="total-price-display">{{  number_format($ingredient->price * 1.08)  }}円</span>)</p>
                        </div>
                        <div class="kart">
                            <div class="cart-push" style="display: none;">
                                カートに追加しました
                            </div>
                            <div class="btn">
                                <button type="button" class="btn btn--pink btn--radius into-cart" data-ingredient-id="{{ $ingredient->uuid }}">カートに入れる</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="recipe">
                <div class="title2">
                    この食材を使用したレシピ
                </div>
                <div class="recipe2">
                    <ul class="stylenone grid">
                        @foreach($recipes as $recipe)
                        <li>
                            <a href="{{ route('recipes.show', $recipe->uuid) }}">
                                <img src="{{ Storage::disk('s3')->url($recipe->image_path) }}" alt="">
                                <p class="title">{{ $recipe->title }}</p>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </main>

        <aside id="sidebar">
            <section class="ranking">
                <h3 class="side-title">ランキングカテゴリ</h3>
                <ul>
                    <li><p class="subject"><a href="{{ route('ranking.show', ['category' => 'sougou']) }}">総合ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 4) }}">野菜ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 5) }}">果物ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 1) }}">お肉ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 2) }}">魚介ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 3) }}">乳製品ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 9) }}">調味料ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 10) }}">飲料ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 6) }}">冷凍ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 11) }}">その他ランキング</a></p></li>
                </ul>
            </section>

            <section class="cm">
                <a href="{{ url('/form') }}"><img src="{{ Storage::disk('s3')->url('toiawase.png') }}" alt=""></a>
            </section>

            <section class="cm">
                <a href="#"><img src="{{ Storage::disk('s3')->url('cm.png') }}" alt=""></a>
            </section>

            <section class="cm">
            <a href="#"><img src="{{ Storage::disk('s3')->url('cm2.png') }}" alt=""></a>
            </section>
        </aside>
    </div>
</x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/item.css'])
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>

    @vite('resources/js/app.js')

    <!-- slick carouselのスタイルとスクリプト -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@endpush
