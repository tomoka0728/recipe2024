@extends('layouts.app')
@section('content')
{{ Breadcrumbs::render('cart','カート') }}
    <x-guest-layout>
        <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10 w-full !pt-20">
            <ul class="progressbar">
                <li class="complete">ご入力</li>
                <li class="active">入力内容確認</li>
                <li>お支払い</li>
                <li>完了</li>
            </ul>
        </div>

        <div id="container2" class="wrapper2 mt-10">
            <div class="title">
                <h1>ご注文内容の確認</h1>
            </div>
        </div>

        <div id="container" class="wrapper">
            <main>
                <section class="cart-content">
                    <div class="item-in-cart">ご注文商品</div>
                    <ul class="cart-items">
                        @foreach ($carts as $ingredientUuid => $item)
                            <li class="cart-item">
                                <div class="item-img2">
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
                                    <p class="item-quantity">数量：{{ $item['quantity'] }}</p>
                                </div>
                            </li>
                            <hr>
                        @endforeach
                    </ul>
                    <div class="item-in-cart">お届け先</div>
                    <ul class="cart-items">
                        <li class="cart-item">
                            <div class="block mt-1 w-full">
                                {{ is_array($address) ? $address['name'] : $address->name }}　様
                            </div>
                        </li>
                        <li class="cart-item">
                            <div class="block mt-1 w-full">
                                〒{{ is_array($address) ? $address['zipcode'] : $address->zipcode }}
                            </div>
                        </li>
                        <li class="cart-item">
                            <div class="block mt-1 w-full">
                                {{ is_array($address) ? $address['prefectures'] : $address->prefectures }}
                                {{ is_array($address) ? $address['city'] : $address->city }}
                                {{ is_array($address) ? $address['address'] : $address->address }}
                                {{ is_array($address) ? $address['room'] : $address->room }}
                            </div>
                        <li class="cart-item">
                            <div class="block mt-1 w-full">
                                電話番号: {{ is_array($address) ? $address['phone'] : $address->phone }}
                            </div>
                        </li>
                    </ul>
                    <div class="item-in-cart">お支払い方法</div>
                    <ul class="cart-items">
                        <li class="cart-item">
                            <div class="block mt-1 w-full">{{ $paymentMethod }}</div>
                        </li>
                    </ul>
                    <div class="item-in-cart">ポイント利用</div>
                    <ul class="cart-items">
                        <li class="cart-item">
                            <div class="block mt-1 w-full">
                                @if ($pointUsage === 'not_use')
                                    利用しない
                                @elseif ($pointUsage === 'use')
                                    {{ number_format($usedPoints) }}ポイント
                                @else
                                    利用ポイント: 未選択
                                @endif
                            </div>
                        </li>
                    </ul>
                </section>
            </main>

            <aside class="sidebar">
                <div class="top">
                    <div class="a">
                        <div class="myname">{{ Auth::check() ? Auth::user()->nickname . '様' : 'ゲスト様' }}</div>
                    </div>
                    <div class="a">
                        <div class="pt">
                            <h1><p class="num">{{ Auth::check() ? Auth::user()->points : 0 }}</p> pt</h1>
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
                            <div class="val">{{ number_format($tax) }}円</div>
                        </li>
                        <li>
                            <div class="key">送料</div>
                            <div class="val" {{ count($carts) > 0 ? 'id=shipping-price data-send-price=' . $sendPrice : '' }}>
                                {{ count($carts) > 0 ? number_format($sendPrice) . '円' : '0円' }}
                            </div>
                        </li>
                        <li>
                            <div class="key">使用ポイント</div>
                            <div class="val">
                                @if ($pointUsage === 'use' && $usedPoints > 0)
                                    -{{ number_format($usedPoints) }}円
                                @else
                                    0円
                                @endif
                            </div>
                        </li>
                        <li class="total-sum">
                            <div class="key">合計</div>
                            <div class="val">{{ number_format($sum + $tax + $sendPrice - $usedPoints) }}円</div>
                        </li>
                        <li class="grant-point">
                            <div class="key">付与予定ポイント</div>
                            <div class="val">{{ number_format($grantPoint) }}pt</div>
                        </li>
                    </ul>
                    <div class="action-buttons">
                        <button onclick="location.href='/payment/checkout'" class="next-button">注文する</button>
                        <button onclick="location.href='/payment'" class="back-button">戻って修正する</button>
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
    @vite(['resources/js/cartUpdate.js','resources/js/cartDelete.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
@endpush