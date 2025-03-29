@extends('layouts.app')
@section('content')
    <x-guest-layout>
        <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10 w-full !pt-20">
            <ul class="progressbar">
                <li class="active">ご入力</li>
                <li>確認</li>
                <li>お支払い</li>
                <li>完了</li>
            </ul>
        </div>

        <div id="container2" class="wrapper2 mt-10">
            <div class="title">
                <h1>お届け先・お支払い方法の選択</h1>
            </div>
        </div>

        <div id="container" class="wrapper">
            <main class="cart">
                <section class="content">
                    <div class="item-in-cart">お届け先</div>
                    <div class="mb-10">
                        <div class="w-2/3">
                            <!-- Name -->
                            <div class="mt-4">
                                <div class="flex items-center">
                                    <x-input-label for="name" :value="__('Name')" class="mr-2" />
                                </div>
                                <div class="block mt-1 w-full">{{ Auth::user()->name }}　様</div>
                            </div>

                            <!-- zipcode -->
                            <div class="mt-4">
                                <div class="flex items-center">
                                    <x-input-label for="zipcode" :value="__('郵便番号')" class="mr-2" />
                                    <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                                        必須
                                    </div>
                                </div>
                                <x-text-input id="zipcode"
                                    class="block mt-1 w-full {{ $errors->has('郵便番号') ? 'border-red-500 bg-red-100' : '' }} "
                                    type="number" placeholder="数字のみ入力してください" name="zipcode" :value="old('zipcode')" required autocomplete="zipcode" />
                                <x-input-error :messages="$errors->get('zipcode')" class="mt-2" id="zipcode-error" />
                            </div>

                            <!-- prefectures -->
                            <div class="mt-4">
                                <div class="flex items-center">
                                    <x-input-label for="prefectures" :value="__('都道府県')" class="mr-2" />
                                    <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                                        必須
                                    </div>
                                </div>
                                <select id="prefectures" name="prefectures"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $errors->has('prefectures') ? 'border-red-500 bg-red-100' : '' }}"
                                    required>
                                    <option value="">選択してください</option>
                                    @foreach (['北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'] as $prefecture)
                                        <option value="{{ $prefecture }}" {{ old('prefectures') == $prefecture ? 'selected' : '' }}>{{ $prefecture }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('prefectures')" class="mt-2" id="prefectures-error" />
                            </div>

                            <!-- city -->
                            <div class="mt-4">
                                <div class="flex items-center">
                                    <x-input-label for="city" :value="__('市区町村')" class="mr-2" />
                                    <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                                        必須
                                    </div>
                                </div>
                                <x-text-input id="city"
                                    class="block mt-1 w-full {{ $errors->has('city') ? 'border-red-500 bg-red-100' : '' }} "
                                    type="text" name="city" :value="old('city')" required autocomplete="city" />
                                <x-input-error :messages="$errors->get('city')" class="mt-2" id="city-error" />
                            </div>

                            <!-- address -->
                            <div class="mt-4">
                                <div class="flex items-center">
                                    <x-input-label for="address" :value="__('番地')" class="mr-2" />
                                    <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                                        必須
                                    </div>
                                </div>
                                <x-text-input id="address"
                                    class="block mt-1 w-full {{ $errors->has('address') ? 'border-red-500 bg-red-100' : '' }} "
                                    type="text" name="address" :value="old('address')" required autocomplete="address" />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" id="address-error" />
                            </div>

                             <!-- room -->
                             <div class="mt-4">
                                <div class="flex items-center">
                                    <x-input-label for="room" :value="__('建物名')" class="mr-2" />
                                </div>
                                <x-text-input id="room"
                                    class="block mt-1 w-full {{ $errors->has('room') ? 'border-red-500 bg-red-100' : '' }} "
                                    type="text" name="room" :value="old('room')" required autocomplete="room" />
                                <x-input-error :messages="$errors->get('room')" class="mt-2" id="room-error" />
                            </div>

                             <!-- phone -->
                             <div class="mt-4">
                                <div class="flex items-center">
                                    <x-input-label for="phone" :value="__('電話番号')" class="mr-2" />
                                    <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                                        必須
                                    </div>
                                </div>
                                <x-text-input id="phone"
                                    class="block mt-1 w-full {{ $errors->has('phone') ? 'border-red-500 bg-red-100' : '' }} "
                                    type="text" placeholder="数字のみ入力してください" name="phone" :value="old('phone')" required autocomplete="phone" />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" id="phone-error" />
                            </div>
                        </div>
                    </div>


                    <div class="item-in-cart">お支払い方法</div>
                    <div class="payment-method">
                        <div class="mt-2 space-y-2 mb-10">
                            <!-- クレジットカード -->
                            <label class="w-2/3 flex items-center space-x-2 p-3 border rounded-md cursor-pointer transition duration-200 hover:bg-red-100 {{ old('method') == 'credit' ? 'bg-red-100 border-red-500' : 'border-gray-300' }}">
                                <input type="radio" name="method" value="credit" class="hidden peer" {{ old('method') == 'credit' ? 'checked' : '' }}>
                                <div class="w-5 h-5 border-2 rounded-full flex items-center justify-center border-gray-400 peer-checked:border-red-500">
                                    <div class="w-3 h-3 bg-transparent rounded-full peer-checked:bg-red-500"></div>
                                </div>
                                <span class="text-gray-700">クレジットカード</span>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('method')" class="mt-2" id="method-error" />
                    </div>


                    <div class="item-in-cart">ポイント利用</div>
                    <div class="payment-method">
                        <div class="mt-2 space-y-2 mb-10">
                        <div class="mt-2 p-3 border rounded-md bg-gray-100">
                            <span class="text-lg font-semibold text-gray-800">現在のポイント：　{{ Auth::user()->points }}pt</span>
                        </div>

                        <div class="mt-4 space-y-2">
                            <!-- ポイントを利用する -->
                            <label class="w-2/3 flex items-center space-x-2 cursor-pointer transition duration-200 peer-checked:border-black peer-checked:text-black">
                                <input type="radio" name="point" value="use" class="hidden peer" id="use-point">
                                <div class="w-5 h-5 border-2 rounded-full flex items-center justify-center border-gray-400 peer-checked:border-red-500">
                                    <div class="w-3 h-3 bg-transparent rounded-full peer-checked:bg-red-500"></div>
                                </div>
                                <span>利用する</span>
                                <input type="number" pattern="^[0-9]+$" min="0" name="use_point" id="point-input" placeholder="使用するポイントを入力"
                                class="w-50 p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-400 peer-checked:disabled:opacity-50"> pt
                            </div>
                            </label>

                            <!-- ポイント入力欄 -->


                            <div class="mt-4">
                                <!-- 利用しない -->
                                <label class="w-2/3 flex items-center space-x-2 cursor-pointer transition duration-200 peer-checked:border-black peer-checked:text-black">
                                    <input type="radio" name="point" value="not_use" class="hidden peer" id="not-use-point">
                                    <div class="w-5 h-5 border-2 rounded-full flex items-center justify-center border-gray-400 peer-checked:border-red-500">
                                        <div class="w-3 h-3 bg-transparent rounded-full peer-checked:bg-red-500"></div>
                                    </div>
                                    <span>利用しない</span>
                                </label>
                            </div>
                        <x-input-error :messages="$errors->get('point')" class="mt-2" id="point-error" />
                    </div>
                </section>
            </main>

            <aside class="sideber">
                <div class="top">
                    <div class="a">
                        @if(Auth::check())
                            <div class="myname">{{ Auth::user()->nickname }}様</div>
                        @else
                            <div class="myname">ゲスト様</div>
                        @endif
                    </div>
                    <div class="a">
                        @if(Auth::check())
                            <div class="pt"><h1><p class="num">{{ Auth::user()->points }}</p> pt</h1></div>
                        @else
                            <div class="pt"><h1><p class="num">0</p> pt</h1></div>
                        @endif
                    </div>
                </div>
                <section class="total-summary">
                    <ul class="summary-list">
                        <li>
                            <div class="key">商品合計</div>
                            <div class="val" id="total-price">{{ number_format($sum) }}円</div>
                        </li>
                        <li>
                            <div class="key">送料</div>
                            <div class="val" id="shipping-price" data-send-price="{{ $sendPrice }}">{{ number_format($sendPrice) }}円</div>
                        </li>
                        <li class="total-sum">
                            <div class="key">合計</div>
                            <div class="val" id="total-sum">{{ number_format($sendPrice + $sum) }}円</div>
                        </li>
                    </ul>

                    <div class="action-buttons">
                        <button onclick="location.href='/order_suc'" class="next-button">確認画面に進む</button>
                        <button type="button" onClick="history.back();" class="back-button">戻る</button>
                    </div>
            </aside>
            </section>
    </x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/cart.css'])
@endpush

@push('scripts')
    @vite('resources/js/pointToggle.js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
@endpush
