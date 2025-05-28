@extends('layouts.app')

@section('content')
    <x-guest-layout>

        <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10 w-full !pt-20">
            <ul class="progressbar">
                <li class="complete">ご入力</li>
                <li class="complete">入力内容確認</li>
                <li class="active">お支払い</li>
                <li>完了</li>
            </ul>
        </div>

        <div class="max-w-xl mx-auto mt-20 bg-white p-8 rounded-2xl shadow-lg text-center">
            <div class="flex justify-center mb-6">
                <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-gray-800 mb-4">決済がキャンセルされました</h1>
            <p class="text-gray-600 mb-6">
                決済手続きが完了しませんでした。<br>
                再度お試しいただくか、必要に応じてサポートまでご連絡ください。
            </p>
            <a href="{{ route('top') }}" class="inline-block px-6 py-3 bg-gray-500 text-white font-semibold rounded-full hover:bg-gray-600 transition">
                ホームに戻る
            </a>
        </div>
    </x-guest-layout>
@endsection
