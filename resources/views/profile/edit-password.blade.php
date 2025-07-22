@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('profile.edit.password') }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-yellow-900">パスワードの変更</p>
        <p class="mt-5 text-yellow-900">新しいパスワードを設定できます。</p>
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
        <div class="rq2-box">
            <div class="bg-white shadow rounded-lg p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- ボタン -->
        <div class="flex items-center justify-center mt-10 mb-20 space-x-4">
            <a href="{{ route('profile.edit') }}"
               class="no-underline text-sm text-gray-500 hover:text-gray-900 rounded-md">
                キャンセル
            </a>
        </div>
    </div>
</x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/style.css'])
@endpush
