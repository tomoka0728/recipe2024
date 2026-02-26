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
                        <div class="cart-items">
                            @foreach ($carts as $ingredientUuid => $item)
                                <div class="cart-item" data-ingredient-uuid="{{ $ingredientUuid }}">
                                    <div class="item-img">
                                        <a href="{{ route('ingredients.show', ['uuid' => $ingredientUuid]) }}">
                                            <img src="{{ Storage::disk('s3')->url($item['image_path']) }}" alt="商品画像">
                                        </a>
                                    </div>
                                    <div class="item-details">
                                        <div class="item-info-row">
                                            <span class="item-name">
                                                <a
                                                    href="{{ route('ingredients.show', ['uuid' => Auth::check() ? $item->ingredient->uuid ?? $ingredientUuid : $ingredientUuid]) }}">
                                                    {{ Auth::check() ? $item->ingredient->name ?? $item['name'] : $item['name'] }}
                                                </a>
                                            </span>
                                            <span class="item-price">
                                                @if(Auth::check() && isset($item->ingredient) && $item->ingredient->sale)
                                                    価格：<span style="text-decoration: line-through; color: #999;">{{ number_format($item->ingredient->price) }}円</span>
                                                    <span style="color: #e74c3c; font-weight: bold; margin-left: 8px;">{{ number_format($item->ingredient->sale_price) }}円</span>
                                                @else
                                                    価格：{{ number_format(Auth::check() ? $item->ingredient->sale_price ?? $item['price'] : $item['price']) }}円
                                                @endif
                                            </span>
                                            <span class="item-quantity">
                                                数量
                                                <input type="number" name="quantity[{{ $ingredientUuid }}]"
                                                    value="{{ Auth::check() ? $item->quantity ?? $item['quantity'] : $item['quantity'] ?? 1 }}"
                                                    min="1" class="quantity-input"
                                                    data-price="{{ Auth::check() ? $item->ingredient->sale_price ?? $item['price'] : $item['price'] }}"
                                                    data-ingredient-uuid="{{ $ingredientUuid }}" />
                                            </span>
                                            <div class="item-actions">
                                                <button type="button"
                                                    class="remove-button remove-cart-item"
                                                    data-ingredient-uuid="{{ $ingredientUuid }}">
                                                    削除
                                                </button>
                                                <button type="button"
                                                    class="save-for-later-ajax save-button"
                                                    data-ingredient-uuid="{{ $ingredientUuid }}">
                                                    あとで買う
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (!$loop->last)
                                    <hr>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="cart-empty-message">カートに商品が入っていません。</p>
                    @endif
                    @if (count($saveForLaterItems) > 0)
                        <div class="item-in-later">あとで買う</div>
                        <div class="later-box">
                            @if (count($saveForLaterItems) > 0)
                                @foreach ($saveForLaterItems as $key => $item)
                                    <div class="later-item" data-ingredient-uuid="{{ Auth::check() ? $item->ingredient->uuid : $key }}">
                                        <div class="item-img">
                                            <a
                                                href="{{ route('ingredients.show', ['uuid' => Auth::check() ? $item->ingredient->uuid : $key]) }}">
                                                @if (Auth::check())
                                                    @if ($item->ingredient && $item->ingredient->image_path)
                                                        <img src="{{ Storage::disk('s3')->url($item->ingredient->image_path) }}"
                                                            alt="商品画像">
                                                    @else
                                                        <img src="/images/no-image.png" alt="画像なし">
                                                    @endif
                                                @else
                                                    <img src="{{ Storage::disk('s3')->url($item['image_path']) }}"
                                                        alt="商品画像">
                                                @endif
                                            </a>
                                        </div>
                                        <div class="item-details">
                                            <div class="item-info-row">
                                                <span class="item-name">
                                                    <a
                                                        href="{{ route('ingredients.show', ['uuid' => Auth::check() ? $item->ingredient->uuid : $key]) }}">
                                                        {{ Auth::check() ? $item->ingredient->name ?? $item['name'] : $item['name'] }}
                                                    </a>
                                                </span>
                                                <span class="item-price">
                                                    価格：{{ number_format(Auth::check() ? $item->ingredient->price ?? $item['price'] : $item['price']) }}円
                                                </span>
                                                <span class="item-quantity">
                                                    数量：{{ Auth::check() ? $item->quantity ?? ($item['quantity'] ?? 1) : $item['quantity'] ?? 1 }}
                                                </span>
                                                <div class="item-actions">
                                                    <div class="save-for-later-item">
                                                        <button type="button"
                                                            class="save-for-later-delete"
                                                            data-ingredient-uuid="{{ Auth::check() ? $item->ingredient->uuid : $key }}">
                                                            削除
                                                        </button>
                                                    </div>
                                                    <button type="button"
                                                        class="move-to-cart-ajax move-back-button"
                                                        data-ingredient-uuid="{{ Auth::check() ? $item->ingredient->uuid : $key }}">
                                                        カートに戻す
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
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
                            <div class="key">消費税</div>
                            <div class="val" id="tax-price">
                                {{ count($carts) > 0 ? number_format(floor($sum * 0.1)) . '円' : '0円' }}
                            </div>
                        </li>
                        <li>
                            <div class="key">送料</div>
                            <div class="val" id="shipping-price" data-send-price="{{ $sendPrice ?? 0 }}">
                                {{ number_format($sendPrice ?? 0) }}円
                            </div>
                        </li>
                        <li class="total-sum">
                            <div class="key">合計</div>
                            <div class="val" {{ count($carts) > 0 ? 'id=total-sum' : '' }}>
                                 {{ count($carts) > 0 ? number_format($sum + $sendPrice + floor($sum * 0.1)) . '円' : '0円' }}
                            </div>
                        </li>
                    </ul>
                    <div class="action-buttons">
                        @auth
                            @if ($sum > 0)
                                <button id="checkout-button" onclick="location.href='/payment'" class="next-button">ご注文手続きに進む</button>
                            @else
                                <button id="checkout-button" class="next-button" disabled>ご注文手続きに進む</button>
                            @endif
                        @else
                            @if ($sum > 0)
                                <a id="checkout-button"  href="{{ route('login') }}?redirect_to={{ urlencode(url('/payment')) }}"
                                    class="next-button">ログインしてご注文手続きに進む</a>
                            @else
                                <button  id="checkout-button" class="next-button" disabled>ログインしてご注文手続きに進む</button>
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
    @vite(['resources/js/cartUpdate.js', 'resources/js/cartMove.js', 'resources/js/cartDelete.js', 'resources/js/saveForLaterDelete.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
@endpush
