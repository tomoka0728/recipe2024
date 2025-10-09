@extends('layouts.app')

@section('content')
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10 w-full !pt-20">
        <ul class="progressbar">
            <li class="active">ご入力</li>
            <li>ご確認</li>
            <li>完了</li>
        </ul>
    </div>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-yellow-900">お問い合わせ</p>
    </div>
    <form method="POST" action="{{ route('contact.confirm') }}" novalidate class="custom-form contact-form">
        @csrf
        <div class="rq-box">
            <div class="rq2-box">
                <!-- Name -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="name" value="お名前" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <x-text-input id="name" class="block mt-1 w-full {{ $errors->has('name') ? 'border-red-500 bg-red-100' : '' }}"
                        type="text" name="name" :value="old('name', $user ? $user->name : '')" autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" id="name-error" />
                </div>

                <!-- Email -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="email" value="メールアドレス" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <x-text-input id="email" class="block mt-1 w-full {{ $errors->has('email') ? 'border-red-500 bg-red-100' : '' }}"
                        type="email" name="email" :value="old('email', $user ? $user->email : '')" autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" />
                </div>

                <!-- Type -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="type" value="お問い合わせ種別" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <select id="type" name="type" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('type') ? 'border-red-500 bg-red-100' : '' }}">
                        <option value="">選択してください</option>
                        @foreach($contactTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('type') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" id="type-error" />
                </div>

                <!-- Subject -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="subject" value="件名" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <x-text-input id="subject" class="block mt-1 w-full {{ $errors->has('subject') ? 'border-red-500 bg-red-100' : '' }}"
                        type="text" name="subject" :value="old('subject')" />
                    <x-input-error :messages="$errors->get('subject')" class="mt-2" id="subject-error" />
                </div>

                <!-- Message -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="message" value="お問い合わせ内容" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <textarea id="message" name="message" rows="8"
                        class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 {{ $errors->has('message') ? 'border-red-500 bg-red-100' : '' }}">{{ old('message') }}</textarea>
                    <div class="flex items-center text-xs text-brown-500 mt-2">2000文字以内で入力してください。</div>
                    <x-input-error :messages="$errors->get('message')" class="mt-2" id="message-error" />
                </div>
            </div>

            <div class="flex items-center justify-center mt-10 mb-20">
                <x-primary-button class="ms-4">
                    確認画面へ
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/contact-form.css'])
@endpush
