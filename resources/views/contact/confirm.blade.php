@extends('layouts.app')

@section('content')
<x-header2 />
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10 w-full !pt-20">
        <ul class="progressbar">
            <li class="complete">ご入力</li>
            <li class="active">ご確認</li>
            <li>完了</li>
        </ul>
    </div>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-yellow-900">お問い合わせ内容確認</p>
    </div>
    <div class="rq-box">
        <div class="rq2-box">
            <p class="text-gray-600 mb-6">以下の内容でお問い合わせを送信します。よろしければ「送信する」ボタンをクリックしてください。</p>

            <div class="space-y-4 mb-8">
                <div class="border-b pb-4">
                    <label class="block text-sm font-medium text-gray-700">お名前</label>
                    <p class="mt-1 text-gray-900">{{ $data['name'] }}</p>
                </div>

                <div class="border-b pb-4">
                    <label class="block text-sm font-medium text-gray-700">メールアドレス</label>
                    <p class="mt-1 text-gray-900">{{ $data['email'] }}</p>
                </div>

                <div class="border-b pb-4">
                    <label class="block text-sm font-medium text-gray-700">お問い合わせ種別</label>
                    <p class="mt-1 text-gray-900">{{ $typeName }}</p>
                </div>

                <div class="border-b pb-4">
                    <label class="block text-sm font-medium text-gray-700">件名</label>
                    <p class="mt-1 text-gray-900">{{ $data['subject'] }}</p>
                </div>

                <div class="pb-4">
                    <label class="block text-sm font-medium text-gray-700">お問い合わせ内容</label>
                    <p class="mt-1 text-gray-900 whitespace-pre-line">{{ $data['message'] }}</p>
                </div>
            </div>

            <div class="flex items-center justify-center mt-10 mb-20">
                <form method="POST" action="{{ route('contact.edit') }}" class="inline" id="editForm">
                    @csrf
                    <input type="hidden" name="name" value="{{ $data['name'] }}">
                    <input type="hidden" name="email" value="{{ $data['email'] }}">
                    <input type="hidden" name="type" value="{{ $data['type'] }}">
                    <input type="hidden" name="subject" value="{{ $data['subject'] }}">
                    <input type="hidden" name="message" value="{{ $data['message'] }}">
                </form>

                <x-secondary-button class="ms-4" onclick="document.getElementById('editForm').submit()">
                    修正する
                </x-secondary-button>

                <form method="POST" action="{{ route('contact.store') }}" class="inline">
                    @csrf
                    <input type="hidden" name="name" value="{{ $data['name'] }}">
                    <input type="hidden" name="email" value="{{ $data['email'] }}">
                    <input type="hidden" name="type" value="{{ $data['type'] }}">
                    <input type="hidden" name="subject" value="{{ $data['subject'] }}">
                    <input type="hidden" name="message" value="{{ $data['message'] }}">

                    <x-primary-button class="ms-4">
                        送信する
                    </x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
<x-footer2 />
@endsection

@push('styles')
    @vite(['resources/css/contact-form.css'])
@endpush
