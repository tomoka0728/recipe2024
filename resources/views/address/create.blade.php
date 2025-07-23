@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('address.create') }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-gray-900">新しいお届け先を追加</p>
        <p class="mt-5 text-gray-600">お届け先の情報を入力してください</p>
    </div>

    <div class="custom-form">
        <div class="rq-box" style="max-width: 600px; margin: 0 auto;">
            <div class="bg-white shadow rounded-lg p-6 mb-6">
                <form method="POST" action="{{ route('address.store') }}">
                    @csrf

                    <!-- 名前 -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('お名前')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- 郵便番号 -->
                    <div class="mb-4">
                        <x-input-label for="zipcode" :value="__('郵便番号（ハイフンなし7桁）')" />
                        <x-text-input id="zipcode" class="block mt-1 w-full" type="text" name="zipcode" :value="old('zipcode')" placeholder="1234567" maxlength="7" />
                        <x-input-error :messages="$errors->get('zipcode')" class="mt-2" />
                    </div>

                    <!-- 都道府県 -->
                    <div class="mb-4">
                        <x-input-label for="prefectures" :value="__('都道府県')" />
                        <select id="prefectures" name="prefectures" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" >
                            <option value="">選択してください</option>
                            <option value="北海道" {{ old('prefectures') == '北海道' ? 'selected' : '' }}>北海道</option>
                            <option value="青森県" {{ old('prefectures') == '青森県' ? 'selected' : '' }}>青森県</option>
                            <option value="岩手県" {{ old('prefectures') == '岩手県' ? 'selected' : '' }}>岩手県</option>
                            <option value="宮城県" {{ old('prefectures') == '宮城県' ? 'selected' : '' }}>宮城県</option>
                            <option value="秋田県" {{ old('prefectures') == '秋田県' ? 'selected' : '' }}>秋田県</option>
                            <option value="山形県" {{ old('prefectures') == '山形県' ? 'selected' : '' }}>山形県</option>
                            <option value="福島県" {{ old('prefectures') == '福島県' ? 'selected' : '' }}>福島県</option>
                            <option value="茨城県" {{ old('prefectures') == '茨城県' ? 'selected' : '' }}>茨城県</option>
                            <option value="栃木県" {{ old('prefectures') == '栃木県' ? 'selected' : '' }}>栃木県</option>
                            <option value="群馬県" {{ old('prefectures') == '群馬県' ? 'selected' : '' }}>群馬県</option>
                            <option value="埼玉県" {{ old('prefectures') == '埼玉県' ? 'selected' : '' }}>埼玉県</option>
                            <option value="千葉県" {{ old('prefectures') == '千葉県' ? 'selected' : '' }}>千葉県</option>
                            <option value="東京都" {{ old('prefectures') == '東京都' ? 'selected' : '' }}>東京都</option>
                            <option value="神奈川県" {{ old('prefectures') == '神奈川県' ? 'selected' : '' }}>神奈川県</option>
                            <option value="新潟県" {{ old('prefectures') == '新潟県' ? 'selected' : '' }}>新潟県</option>
                            <option value="富山県" {{ old('prefectures') == '富山県' ? 'selected' : '' }}>富山県</option>
                            <option value="石川県" {{ old('prefectures') == '石川県' ? 'selected' : '' }}>石川県</option>
                            <option value="福井県" {{ old('prefectures') == '福井県' ? 'selected' : '' }}>福井県</option>
                            <option value="山梨県" {{ old('prefectures') == '山梨県' ? 'selected' : '' }}>山梨県</option>
                            <option value="長野県" {{ old('prefectures') == '長野県' ? 'selected' : '' }}>長野県</option>
                            <option value="岐阜県" {{ old('prefectures') == '岐阜県' ? 'selected' : '' }}>岐阜県</option>
                            <option value="静岡県" {{ old('prefectures') == '静岡県' ? 'selected' : '' }}>静岡県</option>
                            <option value="愛知県" {{ old('prefectures') == '愛知県' ? 'selected' : '' }}>愛知県</option>
                            <option value="三重県" {{ old('prefectures') == '三重県' ? 'selected' : '' }}>三重県</option>
                            <option value="滋賀県" {{ old('prefectures') == '滋賀県' ? 'selected' : '' }}>滋賀県</option>
                            <option value="京都府" {{ old('prefectures') == '京都府' ? 'selected' : '' }}>京都府</option>
                            <option value="大阪府" {{ old('prefectures') == '大阪府' ? 'selected' : '' }}>大阪府</option>
                            <option value="兵庫県" {{ old('prefectures') == '兵庫県' ? 'selected' : '' }}>兵庫県</option>
                            <option value="奈良県" {{ old('prefectures') == '奈良県' ? 'selected' : '' }}>奈良県</option>
                            <option value="和歌山県" {{ old('prefectures') == '和歌山県' ? 'selected' : '' }}>和歌山県</option>
                            <option value="鳥取県" {{ old('prefectures') == '鳥取県' ? 'selected' : '' }}>鳥取県</option>
                            <option value="島根県" {{ old('prefectures') == '島根県' ? 'selected' : '' }}>島根県</option>
                            <option value="岡山県" {{ old('prefectures') == '岡山県' ? 'selected' : '' }}>岡山県</option>
                            <option value="広島県" {{ old('prefectures') == '広島県' ? 'selected' : '' }}>広島県</option>
                            <option value="山口県" {{ old('prefectures') == '山口県' ? 'selected' : '' }}>山口県</option>
                            <option value="徳島県" {{ old('prefectures') == '徳島県' ? 'selected' : '' }}>徳島県</option>
                            <option value="香川県" {{ old('prefectures') == '香川県' ? 'selected' : '' }}>香川県</option>
                            <option value="愛媛県" {{ old('prefectures') == '愛媛県' ? 'selected' : '' }}>愛媛県</option>
                            <option value="高知県" {{ old('prefectures') == '高知県' ? 'selected' : '' }}>高知県</option>
                            <option value="福岡県" {{ old('prefectures') == '福岡県' ? 'selected' : '' }}>福岡県</option>
                            <option value="佐賀県" {{ old('prefectures') == '佐賀県' ? 'selected' : '' }}>佐賀県</option>
                            <option value="長崎県" {{ old('prefectures') == '長崎県' ? 'selected' : '' }}>長崎県</option>
                            <option value="熊本県" {{ old('prefectures') == '熊本県' ? 'selected' : '' }}>熊本県</option>
                            <option value="大分県" {{ old('prefectures') == '大分県' ? 'selected' : '' }}>大分県</option>
                            <option value="宮崎県" {{ old('prefectures') == '宮崎県' ? 'selected' : '' }}>宮崎県</option>
                            <option value="鹿児島県" {{ old('prefectures') == '鹿児島県' ? 'selected' : '' }}>鹿児島県</option>
                            <option value="沖縄県" {{ old('prefectures') == '沖縄県' ? 'selected' : '' }}>沖縄県</option>
                        </select>
                        <x-input-error :messages="$errors->get('prefectures')" class="mt-2" />
                    </div>

                    <!-- 市区町村 -->
                    <div class="mb-4">
                        <x-input-label for="city" :value="__('市区町村')" />
                        <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" />
                        <x-input-error :messages="$errors->get('city')" class="mt-2" />
                    </div>

                    <!-- 番地・建物名 -->
                    <div class="mb-4">
                        <x-input-label for="address" :value="__('番地・建物名')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>

                    <!-- 部屋番号等 -->
                    <div class="mb-4">
                        <x-input-label for="room" :value="__('部屋番号等（任意）')" />
                        <x-text-input id="room" class="block mt-1 w-full" type="text" name="room" :value="old('room')" />
                        <x-input-error :messages="$errors->get('room')" class="mt-2" />
                    </div>

                    <!-- 電話番号 -->
                    <div class="mb-6">
                        <x-input-label for="phone" :value="__('電話番号（ハイフンなし）')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" placeholder="09012345678" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- 保存ボタン -->
                    <div class="flex items-center justify-center">
                        <x-primary-button>
                            {{ __('お届け先を追加') }}
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
