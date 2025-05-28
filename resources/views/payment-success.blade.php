@extends('layouts.app')

@section('content')
    <x-guest-layout>
        <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10 w-full !pt-20">
            <ul class="progressbar">
                <li class="complete">ご入力</li>
                <li class="complete">入力内容確認</li>
                <li class="complete">お支払い</li>
                <li class="active">完了</li>
            </ul>
        </div>
        <div class="max-w-xl mx-auto bg-white p-8 rounded-2xl shadow-lg text-center">
            <div class="flex justify-center mb-6">
                <svg class="w-16 h-16 text-rose-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">ご注文ありがとうございました</h1>
            <p class="text-gray-600 mb-6">
                ご注文が正常に完了しました。<br>
                ご登録のメールアドレス宛に確認メールをお送りしましたのでご確認ください。
            </p>
            <a href="/" class="inline-block px-6 py-3 bg-rose-300 text-white font-semibold rounded-full hover:rose-600 transition">
                ホームに戻る
            </a>
        </div>
    </x-guest-layout>
@endsection
