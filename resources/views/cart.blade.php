@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('cart', 'カート') }}
    <x-guest-layout>

        <div id="container2" class="wrapper2 mt-10">
            <div class="title">
                <h1>ショッピングカート</h1>
            </div>
        </div>

        <div id="container" class="wrapper">
            <main>
                <section class="cart-content">
                    <div class="item-in-cart">カートに入っている商品</div>
                    @if (count($carts) > 0)
                        <li class="cart-items">
                            @foreach ($carts as $ingredientUuid => $item)
                                <div class="cart-item">
                                    <div class="item-img">
                                        <a href="{{ route('ingredients.show', ['uuid' => $ingredientUuid]) }}">
                                            <img src="{{ Storage::disk('s3')->url($item['image_path']) }}" alt="商品画像">
                                        </a>
                                    </div>
                                    <div class="item-details">
                                        <p class="item-name">
                                            <a href="{{ route('ingredients.show', ['uuid' => $ingredientUuid]) }}">
                                                {{ $item['name'] }}
                                            </a>
                                        </p>
                                        <p class="item-price">価格：{{ number_format($item['price']) }}円</p>
                                        <p class="item-quantity">
                                            数量
                                            <input type="number" name="quantity[{{ $ingredientUuid }}]"
                                                value="{{ $item['quantity'] }}" min="1" class="quantity-input"
                                                data-price="{{ $item['price'] }}"
                                                data-ingredient-uuid="{{ $ingredientUuid }}" />
                                        </p>
                                        <div class="item-actions">
                                            <form method="POST" class="delete-form"
                                                data-ingredient-uuid="{{ $ingredientUuid }}"
                                                action="{{ route('cart.remove', $ingredientUuid) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="remove-button remove-cart-item"
                                                    data-uuid="{{ $ingredientUuid }}">削除</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </li>
                    @else
                        <p>カートに商品が入っていません。</p>
                    @endif
                </section>
            </main>

            <aside class="sidebar">
                <div class="top">
                    <div class="a">
                        <div class="myname">{{ Auth::check() ? Auth::user()->nickname . '様' : 'ゲスト様' }}</div>
                    </div>
                    <div class="a">
                        <div class="pt">
                            <h1>
                                <p class="num">{{ Auth::check() ? Auth::user()->points : 0 }}</p> pt
                            </h1>
                        </div>
                    </div>
                </div>

                <section class="total-summary">
                    <ul class="summary-list">
                        <li>
                            <div class="key">商品合計</div>
                            <div class="val" id="total-price">{{ number_format($sum) }}円</div>
                        </li>
                        <li>
                            <div class="key">送料</div>
                            <div class="val"
                                {{ count($carts) > 0 ? 'id=shipping-price data-send-price=' . $sendPrice : '' }}>
                                {{ count($carts) > 0 ? number_format($sendPrice) . '円' : '0円' }}
                            </div>
                        </li>
                        <li class="total-sum">
                            <div class="key">合計</div>
                            <div class="val" {{ count($carts) > 0 ? 'id=total-sum' : '' }}>
                                {{ count($carts) > 0 ? number_format($sendPrice + $sum) . '円' : '0円' }}
                            </div>
                        </li>
                    </ul>
                    <div class="action-buttons">
                        @auth
                            @if ($sum > 0)
                                <button onclick="location.href='/payment'" class="next-button">ご注文手続きに進む</button>
                            @else
                                <button class="next-button" disabled>ご注文手続きに進む</button>
                            @endif
                        @else
                            @if ($sum > 0)
                                <a href="{{ route('login') }}?redirect_to={{ urlencode(url('/payment')) }}"
                                    class="next-button">ログインしてご注文手続きに進む</a>
                            @else
                                <button class="next-button" disabled>ログインしてご注文手続きに進む</button>
                            @endif
                        @endauth
                        <button type="button" onClick="history.back();" class="back-button">お買い物を続ける</button>
                    </div>
                </section>
            </aside>
        </div>
    </x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/cart.css'])
@endpush

@push('scripts')
    @vite(['resources/js/cartUpdate.js', 'resources/js/cartDelete.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
@endpush
