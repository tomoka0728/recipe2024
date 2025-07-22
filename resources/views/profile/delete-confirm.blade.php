@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('profile.delete.confirm') }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-red-900">退会手続き</p>
        <p class="mt-5 text-red-700">アカウントを削除いたします。この操作は取り消すことができません。</p>
    </div>

    <div class="custom-form">
        <div class="rq-box" style="max-width: 600px; margin: 0 auto;">
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <h3 class="text-lg font-semibold text-red-800 mb-4">⚠️ 重要なお知らせ</h3>
                    <ul class="text-sm text-red-700 space-y-2">
                        <li>• アカウントを削除すると、すべてのデータが完全に削除されます</li>
                        <li>• 購入履歴、ポイント、お気に入りレシピなどもすべて失われます</li>
                        <li>• 一度削除すると、データの復旧はできません</li>
                        <li>• 同じメールアドレスでの再登録は可能ですが、過去のデータは引き継がれません</li>
                    </ul>
                </div>

                <!-- アカウント削除フォーム -->
                @include('profile.partials.delete-user-form')
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
