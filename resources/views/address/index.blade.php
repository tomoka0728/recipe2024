@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('address.index') }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-2 sm:pt-0 mt-4 mb-6">
        <p class="text-3xl font-extrabold text-gray-900">お届け先の管理</p>
    </div>

    <div class="custom-form-wide">
        <div class="rq-box" style="max-width: 1800px; margin: 0 auto; padding: 0 40px;">
            <!-- 成功メッセージ -->
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <p class="text-green-800">{{ session('status') }}</p>
                </div>
            @endif

            <!-- 新規追加ボタン -->
            <div class="mb-6 text-center">
                <a href="{{ route('address.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    新しいお届け先を追加
                </a>
            </div>

            <!-- 2カラムレイアウト -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- 左: デフォルトの配送先 -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-blue-500">
                        <i class="fas fa-star text-yellow-500 mr-2"></i>デフォルトの配送先
                    </h2>
                    @if($defaultAddress)
                        <div class="bg-blue-50 shadow-lg rounded-lg p-6 border-2 border-blue-300 min-h-[320px] flex flex-col">
                            <div class="flex justify-between items-start flex-1">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">{{ $defaultAddress->name }}</h3>
                                    <div class="text-gray-600 space-y-2">
                                        <p>〒{{ substr($defaultAddress->zipcode, 0, 3) }}-{{ substr($defaultAddress->zipcode, 3, 4) }}</p>
                                        <p>{{ $defaultAddress->prefectures }}{{ $defaultAddress->city }}</p>
                                        <p>{{ $defaultAddress->address }}</p>
                                        @if($defaultAddress->room)
                                            <p>{{ $defaultAddress->room }}</p>
                                        @endif
                                        <p class="pt-2">TEL: {{ $defaultAddress->phone }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col space-y-2 ml-4">
                                    <a href="{{ route('address.edit', $defaultAddress->uuid) }}"
                                       class="border-2 border-blue-600 hover:border-blue-700 text-blue-600 hover:text-blue-700 font-bold py-2 px-4 rounded text-sm text-center">
                                        編集
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-8 text-center border-2 border-dashed border-gray-300 min-h-[320px] flex flex-col justify-center">
                            <i class="fas fa-home text-gray-400 text-4xl mb-3"></i>
                            <p class="text-gray-500 mb-4">デフォルトの配送先が設定されていません</p>
                            <p class="text-sm text-gray-400">右のリストから住所を選んでデフォルトに設定するか、新しい住所を追加してください</p>
                        </div>
                    @endif
                </div>

                <!-- 右: その他の登録済み住所 -->
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-4 pb-2 border-b-2 border-gray-400">
                        <i class="fas fa-list mr-2"></i>その他の登録済み住所
                    </h2>
                    @if($otherAddresses->count() > 0)
                        <div class="space-y-4 max-h-[700px] overflow-y-auto">
                            @foreach($otherAddresses as $address)
                                <div class="bg-white shadow rounded-lg p-5 border border-gray-200 hover:shadow-md transition min-h-[200px]">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-base font-semibold text-gray-900 mb-2">{{ $address->name }}</h3>
                                            <div class="text-sm text-gray-600 space-y-1.5">
                                                <p>〒{{ substr($address->zipcode, 0, 3) }}-{{ substr($address->zipcode, 3, 4) }}</p>
                                                <p>{{ $address->prefectures }}{{ $address->city }}</p>
                                                <p>{{ $address->address }}</p>
                                                @if($address->room)
                                                    <p>{{ $address->room }}</p>
                                                @endif
                                                <p class="pt-1">TEL: {{ $address->phone }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col space-y-2 ml-3">
                                            <form method="POST" action="{{ route('address.setDefault', $address->uuid) }}">
                                                @csrf
                                                <button type="submit"
                                                        class="border-2 border-gray-700 hover:border-gray-800 text-gray-700 hover:text-gray-800 font-bold py-2 px-3 rounded text-xs whitespace-nowrap">
                                                    デフォルトに設定
                                                </button>
                                            </form>
                                            <a href="{{ route('address.edit', $address->uuid) }}"
                                               class="border-2 border-blue-600 hover:border-blue-700 text-blue-600 hover:text-blue-700 font-bold py-2 px-3 rounded text-xs text-center">
                                                編集
                                            </a>
                                            <form method="POST" action="{{ route('address.destroy', $address->uuid) }}"
                                                  onsubmit="return confirm('このお届け先を削除しますか？')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="border-2 border-red-500 hover:border-red-600 text-red-500 hover:text-red-600 font-bold py-2 px-3 rounded text-xs w-full">
                                                    削除
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-8 text-center border border-gray-200 min-h-[320px] flex flex-col justify-center">
                            <p class="text-gray-500 text-sm">その他の住所はありません</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- マイページに戻るボタン -->
            <div class="flex items-center justify-center mt-8 mb-10">
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
