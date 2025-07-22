@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('profile.edit.email') }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-yellow-900">メールアドレスの編集</p>
        <p class="mt-5 text-yellow-900">メールアドレスを変更できます。</p>
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
                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')

                    <div>
                        <x-input-label for="email" :value="__('メールアドレス')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Your email address is unverified.') }}

                                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>

                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-center gap-4">
                        <x-primary-button>{{ __('保存') }}</x-primary-button>
                    </div>
                </form>
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
