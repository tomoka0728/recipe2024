@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('address.index') }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-gray-900">お届け先の管理</p>
        <p class="mt-5 text-gray-600">登録されたお届け先の確認・編集・削除ができます</p>
    </div>

    <div class="custom-form">
        <div class="rq-box" style="max-width: 800px; margin: 0 auto;">
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

            <!-- 住所一覧 -->
            @if($addresses->count() > 0)
                <div class="space-y-4">
                    @foreach($addresses as $address)
                        <div class="bg-white shadow rounded-lg p-6 border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $address->name }}</h3>
                                    <div class="text-gray-600 space-y-1">
                                        <p>〒{{ substr($address->zipcode, 0, 3) }}-{{ substr($address->zipcode, 3, 4) }}</p>
                                        <p>{{ $address->prefectures }}{{ $address->city }}</p>
                                        <p>{{ $address->address }}</p>
                                        @if($address->room)
                                            <p>{{ $address->room }}</p>
                                        @endif
                                        <p>TEL: {{ $address->phone }}</p>
                                    </div>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    <a href="{{ route('address.edit', $address->uuid) }}"
                                       class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">
                                        編集
                                    </a>
                                    <form method="POST" action="{{ route('address.destroy', $address->uuid) }}"
                                          onsubmit="return confirm('このお届け先を削除しますか？')"
                                          style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            削除
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 mb-4">お届け先が登録されていません</p>
                    <a href="{{ route('address.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        最初のお届け先を追加
                    </a>
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
