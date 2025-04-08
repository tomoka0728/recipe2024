@extends('layouts.app')
@section('content')

<x-guest-layout>

    <div id="container" class="wrapper">
        <main>
            <article>
                <div class="item_title"><h1>すべての材料(全{{ count($ingredients) }}件)</h1></div>
                <hr class="cp_hr11" />
    
                <div class="all-products-grid">
                    @foreach($ingredients as $ingredient)
                    <div class="all-products-item">
                        <div class="all-products-item-img">
                            <img src="{{ Storage::disk('s3')->url($ingredient->image_path) }}" alt="{{ $ingredient->name }}">
                        </div>
                        <div class="all-products-title">
                            <h2>{{ $ingredient->name }}</h2>
                        </div>
                        <div class="all-products-info">
                            <h3 class="price">{{ number_format($ingredient->price) }}円</h3>
                            <p class="all-products-total-price">(税込み <span class="total-price-display">{{ number_format($ingredient->price * 1.08) }}円</span>)</p>
                        </div>
                        <div class="cart-push2" style="display: none;">
                            カートに追加しました
                        </div>
                        <div class="all-products-btn">
                        <a class="into-cart btn btn--pink btn--radius" data-ingredient-id="{{ $ingredient->uuid }}"data-quantity="1">カートに入れる</a></div>
                    </div>
                    @endforeach
                </div>
            </article>
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
