@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('purchase.history.show', $purchaseHistory) }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-gray-900">注文詳細</p>
        <p class="mt-5 text-gray-600">ご注文内容の詳細情報です</p>
    </div>

    <div class="custom-form">
        <div class="rq-box" style="max-width: 800px; margin: 0 auto;">
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <!-- 注文情報 -->
                <div class="border-b pb-4 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">注文情報</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">注文番号</p>
                            <p class="font-medium">{{ $purchaseHistory->uuid }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">注文日時</p>
                            <p class="font-medium">
                                {{ $purchaseHistory->purchased_at ? \Carbon\Carbon::parse($purchaseHistory->purchased_at)->format('Y年n月j日 H:i') : '不明' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">合計金額</p>
                            <p class="font-bold text-lg text-blue-600">{{ number_format($purchaseHistory->total_price) }}円</p>
                        </div>
                    </div>
                </div>

                <!-- 購入商品一覧 -->
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">購入商品</h2>
                    <div class="space-y-4">
                        @foreach($purchaseHistory->details as $detail)
                            <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                                <div class="flex-shrink-0">
                                    @if($detail->ingredient && $detail->ingredient->image_path)
                                        <img src="{{ Storage::disk('s3')->url($detail->ingredient->image_path) }}"
                                             alt="{{ $detail->ingredient->name }}"
                                             class="w-20 h-20 object-cover rounded">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center">
                                            <span class="text-gray-400 text-sm">画像なし</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $detail->ingredient->name ?? '商品名不明' }}
                                    </h3>
                                    @if($detail->ingredient && $detail->ingredient->description)
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ Str::limit($detail->ingredient->description, 100) }}
                                        </p>
                                    @endif
                                    <div class="mt-2 flex items-center space-x-4">
                                        <span class="text-sm text-gray-600">数量：{{ $detail->quantity }}</span>
                                        <span class="text-sm text-gray-600">
                                            単価：{{ number_format($detail->price) }}円
                                        </span>
                                        <span class="font-medium">
                                            小計：{{ number_format($detail->price * $detail->quantity) }}円
                                        </span>
                                    </div>
                                </div>
                                @if($detail->ingredient)
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('ingredients.show', $detail->ingredient->uuid) }}"
                                           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-2 px-4 rounded text-sm">
                                            商品詳細
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- 合計金額の内訳 -->
                <div class="border-t pt-6 mt-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">金額内訳</h2>
                    <div class="space-y-2">
                        @php
                            $subtotal = $purchaseHistory->details->sum(function($detail) {
                                return $detail->price * $detail->quantity;
                            });
                            $tax = floor($subtotal * 0.1);
                            $shipping = 500; // 仮の送料
                        @endphp
                        <div class="flex justify-between">
                            <span>商品合計</span>
                            <span>{{ number_format($subtotal) }}円</span>
                        </div>
                        <div class="flex justify-between">
                            <span>消費税</span>
                            <span>{{ number_format($tax) }}円</span>
                        </div>
                        <div class="flex justify-between">
                            <span>送料</span>
                            <span>{{ number_format($shipping) }}円</span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between font-bold text-lg">
                                <span>合計</span>
                                <span class="text-blue-600">{{ number_format($purchaseHistory->total_price) }}円</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 戻るボタン -->
            <div class="flex items-center justify-center mt-6 mb-20 space-x-4">
                <a href="{{ route('purchase.history.index') }}"
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    購入履歴一覧に戻る
                </a>
                <a href="{{ route('mypage') }}"
                   class="no-underline text-sm text-gray-500 hover:text-gray-900 rounded-md">
                    マイページに戻る
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/style.css'])
@endpush
