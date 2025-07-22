@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('address.edit', $address) }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-gray-900">お届け先を編集</p>
        <p class="mt-5 text-gray-600">お届け先の情報を変更してください</p>
    </div>

    <div class="custom-form">
        <div class="rq-box" style="max-width: 600px; margin: 0 auto;">
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <form method="POST" action="{{ route('address.update', $address->uuid) }}">
                    @csrf
                    @method('PATCH')

                    <!-- 名前 -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('お名前')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $address->name)" autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- 郵便番号 -->
                    <div class="mb-4">
                        <x-input-label for="zipcode" :value="__('郵便番号（ハイフンなし7桁）')" />
                        <x-text-input id="zipcode" class="block mt-1 w-full" type="text" name="zipcode" :value="old('zipcode', $address->zipcode)" placeholder="1234567" maxlength="7" />
                        <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
                    </div>

                    <!-- 都道府県 -->
                    <div class="mb-4">
                        <x-input-label for="prefectures" :value="__('都道府県')" />
                        <select id="prefectures" name="prefectures" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:rin500 rounded-md shadow-sm" >
                            <option value="">選択してください</option>
                            @php
                                $prefectures = [
                                    '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
                                    '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
                                    '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
                                    '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
                                    '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
                                    '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
                                    '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'
                                ];
                                $selectedPrefecture = old('prefectures', $address->prefectures);
                            @endphp
                            @foreach($prefectures as $prefecture)
                                <option value="{{ $prefecture }}" {{ $selectedPrefecture == $prefecture ? 'selected' : '' }}>
                                    {{ $prefecture }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('prefectures')" class="mt-2" />
                    </div>

                    <!-- 市区町村 -->
                    <div class="mb-4">
                        <x-input-label for="city" :value="__('市区町村')" />
                        <x-text-input id="city" class="block mt-1 w-full" t" name="city" :value="old('city', $address->city)" />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>

                    <!-- 番地・建物名 -->
                    <div class="mb-4">
                        <x-input-label for="address" :value="__('番地・建物名')" />
                        <x-text-input id="address" class="block mt-1 w-full" typname="address" :value="old('address', $address->address)" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <!-- 部屋番号等 -->
                    <div class="mb-4">
                        <x-input-label for="room" :value="__('部屋番号等（任意）')" />
                        <x-text-input id="room" class="block mt-1 w-full" type="text" name="room" :value="old('room', $address->room)" />
                        <x-input-error :messages="$errors->get('room')" class="mt-2" />
                    </div>

                    <!-- 電話番号 -->
                    <div class="mb-6">
                        <x-input-label for="phone" :value="__('電話番号（ハイフンなし）')" />
                        <x-text-input id="phone" class="blw-full" type="text" name="phone" :value="old('phone', $address->phone)" placeholder="09012345678" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- 更新ボタン -->
                    <div class="flex items-center justify-center">
                        <x-primary-button>
                            {{ __('更新') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <!-- キャンセルボタン -->
            <div class="flex items-center justify-center mt-4 mb-20">
                <a href="{{ route('address.index') }}"
                   class="no-underline text-sm text-gray-500 hover:text-gray-900 rounded-md mr-4">
                    キャンセル
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/style.css'])
@endpush
