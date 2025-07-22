@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('profile.edit') }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-yellow-900">アカウント情報の確認・変更</p>
        <p class="mt-5 text-yellow-900">登録情報を確認・変更できます。</p>
    </div>

    <!-- フラッシュメッセージ -->
    @if (session('success'))
        <div class="rq2-box">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 flash-message"
                role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="rq2-box">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6 flash-message"
                role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="custom-form">
        <!-- アカウント情報の表示 -->
        <div class="rq3-box">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">アカウント情報</h3>
                </div>

                <!-- アカウント情報一覧 -->
                <div class="space-y-6">
                    <!-- お名前 -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                        <div class="flex-1">
                            <label class="text-sm font-medium text-gray-700">お名前</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <a href="{{ route('profile.edit.name') }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            編集
                        </a>
                    </div>

                    <!-- ニックネーム -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                        <div class="flex-1">
                            <label class="text-sm font-medium text-gray-700">ニックネーム</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->nickname }}</p>
                        </div>
                        <a href="{{ route('profile.edit.nickname') }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            編集
                        </a>
                    </div>

                    <!-- 生年月日 -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                        <div class="flex-1">
                            <label class="text-sm font-medium text-gray-700">生年月日</label>
                            <p class="mt-1 text-sm text-gray-900">
                                {{ $user->birth ? \Carbon\Carbon::parse($user->birth)->format('Y年m月d日') : '未設定' }}
                            </p>
                        </div>
                        <a href="{{ route('profile.edit.birthday') }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            編集
                        </a>
                    </div>

                    <!-- メールアドレス -->
                    <div class="flex items-center justify-between py-3 border-b border-gray-200">
                        <div class="flex-1">
                            <label class="text-sm font-medium text-gray-700">メールアドレス</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit.email') }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            編集
                        </a>
                    </div>

                    <!-- パスワード -->
                    <div class="flex items-center justify-between py-3">
                        <div class="flex-1">
                            <label class="text-sm font-medium text-gray-700">パスワード</label>
                            <p class="mt-1 text-sm text-gray-900">********</p>
                        </div>
                        <a href="{{ route('profile.edit.password') }}"
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            変更
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- マイページに戻るボタン -->
        <div class="flex items-center justify-center mt-10 mb-20">
            <a href="{{ route('mypage') }}"
               class="no-underline text-sm text-gray-500 hover:text-gray-900 rounded-md mr-4">
                マイページに戻る
            </a>
        </div>
    </div>
</x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/style.css'])
@endpush
