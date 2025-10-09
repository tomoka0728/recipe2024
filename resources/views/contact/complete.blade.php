@extends('layouts.app')

@section('content')
<x-header2 />
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10 w-full !pt-20">
        <ul class="progressbar">
            <li class="complete">ご入力</li>
            <li class="complete">ご確認</li>
            <li class="active">完了</li>
        </ul>
    </div>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-yellow-900">お問い合わせ完了</p>
    </div>
    <div class="rq-box">
        <div class="rq2-box text-center">
            <div class="mb-6">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-yellow-900 mb-4">お問い合わせありがとうございます</h2>
            </div>

            <div class="text-gray-700 space-y-4 mb-8 leading-relaxed">
                <p>お問い合わせを承りました。</p>
                <p>ご登録いただいたメールアドレスに確認メールをお送りしましたので、ご確認ください。</p>
                <p>お問い合わせの内容を確認次第、担当者よりご連絡させていただきます。</p>
                <p class="text-sm">※返信まで2〜3営業日程度お時間をいただく場合がございます。</p>
            </div>

            <div class="flex items-center justify-center mt-10 mb-20 space-x-4">
                <a href="{{ route('top') }}" class="no-underline">
                    <x-primary-button>
                        トップページへ戻る
                    </x-primary-button>
                </a>

                @auth
                    <a href="{{ route('contact.history') }}" class="no-underline">
                        <button class="inline-flex items-center px-2 py-2 bg-gray-500 border border-transparent rounded-md text-white uppercase tracking-widest hover:bg-gray-600 focus:bg-gray-600 active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            お問い合わせ履歴を見る
                        </button>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-guest-layout>
<x-footer2 />
@endsection

@push('styles')
    @vite(['resources/css/contact-form.css'])
@endpush
