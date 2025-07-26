@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('purchase.history.index') }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-gray-900">購入履歴</p>
        <p class="mt-5 text-gray-600">過去のご注文履歴を確認できます</p>
    </div>

    <div class="custom-form">
        <div class="rq-box" style="max-width: 1000px; margin: 0 auto;">
            <!-- フィルター -->
            @if(isset($availableYears) && $availableYears->count() > 0)
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <form method="GET" action="{{ route('purchase.history.index') }}" class="flex flex-wrap items-center gap-4">
                        <label for="filter" class="text-sm font-medium text-gray-700 whitespace-nowrap">絞り込み:</label>

                        <div class="flex items-center gap-2">
                            <select name="filter" id="filter" class="filter-select" onchange="this.form.submit()">
                                <option value="">すべての期間</option>
                                <option value="recent_3_months" {{ request('filter') == 'recent_3_months' ? 'selected' : '' }}>直近3か月</option>
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ request('filter') == $year ? 'selected' : '' }}>
                                        {{ $year }}年
                                    </option>
                                @endforeach
                            </select>

                            @if(request('filter'))
                                <a href="{{ route('purchase.history.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm whitespace-nowrap">
                                    リセット
                                </a>
                            @endif
                        </div>

                        <noscript>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                                絞り込み
                            </button>
                        </noscript>
                    </form>
                </div>
            @endif

            @if(isset($purchaseHistories) && $purchaseHistories->count() > 0)
                <!-- フィルター結果の表示 -->
                <div class="mb-4 text-center">
                    @if(request('filter') == 'recent_3_months')
                        <p class="text-gray-600">直近3か月の購入履歴を表示中 ({{ $purchaseHistories->total() }}件)</p>
                    @elseif(request('filter') && is_numeric(request('filter')))
                        <p class="text-gray-600">{{ request('filter') }}年の購入履歴を表示中 ({{ $purchaseHistories->total() }}件)</p>
                    @else
                        <p class="text-gray-600">すべての購入履歴を表示中 ({{ $purchaseHistories->total() }}件)</p>
                    @endif
                </div>

                <div class="space-y-6">
                    @foreach($purchaseHistories as $history)
                        <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">
                                        注文日：{{ $history->purchased_at ? \Carbon\Carbon::parse($history->purchased_at)->format('Y年n月j日') : '不明' }}
                                    </h3>
                                    <p class="text-sm text-gray-600">注文番号：{{ $history->uuid }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-900">
                                        合計：{{ number_format($history->total_price) }}円
                                    </p>
                                    <a href="{{ route('purchase.history.show', $history->uuid) }}"
                                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm mt-2 inline-block">
                                        詳細を見る
                                    </a>
                                </div>
                            </div>

                            <!-- 購入商品の概要 -->
                            <div class="border-t pt-4">
                                <h4 class="font-semibold text-gray-700 mb-2">購入商品</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($history->details->take(3) as $detail)
                                        <div class="flex items-center space-x-3">
                                            @if($detail->ingredient && $detail->ingredient->image_path)
                                                <img src="{{ Storage::disk('s3')->url($detail->ingredient->image_path) }}"
                                                     alt="{{ $detail->ingredient->name }}"
                                                     class="w-12 h-12 object-cover rounded">
                                            @else
                                                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">画像なし</span>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="text-sm font-medium">{{ $detail->ingredient->name ?? '商品名不明' }}</p>
                                                <p class="text-xs text-gray-500">
                                                    数量：{{ $detail->quantity }} × {{ number_format($detail->price) }}円
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($history->details->count() > 3)
                                        <div class="flex text-gray-500 text-sm">
                                            他{{ $history->details->count() - 3 }}点
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- ページネーション -->
                <div class="mt-6">
                    {{ $purchaseHistories->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-100">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">
                        @if(request('filter') == 'recent_3_months')
                            直近3か月の購入履歴がありません
                        @elseif(request('filter') && is_numeric(request('filter')))
                            {{ request('filter') }}年の購入履歴がありません
                        @else
                            購入履歴がありません
                        @endif
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if(request('filter') == 'recent_3_months')
                            直近3か月にはご注文がありませんでした。他の期間を選択するか、新しくご注文ください。
                        @elseif(request('filter') && is_numeric(request('filter')))
                            {{ request('filter') }}年にはご注文がありませんでした。他の年を選択するか、新しくご注文ください。
                        @else
                            まだご注文がありません。商品をカートに追加してご注文ください。
                        @endif
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('ingredients.index') }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            商品を見る
                        </a>
                    </div>
                </div>
            @endif

            <!-- マイページに戻るボタン -->
            <div class="flex items-center justify-center mt-10 mb-20">
                <a href="{{ route('mypage') }}"
                   class="no-underline text-sm text-gray-500 hover:text-gray-900 rounded-md mr-4">
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
