<x-header2 />
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10 w-full !pt-20">
        <ul class="progressbar">
            <li class="active">ご入力</li>
            <li>ご確認</li>
            <li>完了</li>
        </ul>
    </div>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-3xl font-extrabold text-yellow-900">新規会員登録</p>
    </div>
    <form method="POST" action="{{ route('register') }}" novalidate class="custom-form">
        @csrf

        {{-- <div class="op-box">
            <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mb-10">
                <p class="text-base font-bold text-rose-950">選択してください</p>
            </div>
            <fieldset class="radio-3">
                <label>
                    <input type="radio" name="radio-3" checked/>
                    radio1
                </label>
                <label>
                    <input type="radio" name="radio-3"/>
                    radio2
                </label>
                <label>
                    <input type="radio" name="radio-3"/>
                    radio3
                </label>
            </fieldset>
        </div> --}}

        <div class="rq-box">
            <div class="rq2-box">
                <!-- Name -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="name" :value="__('Name')" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <x-text-input id="name" class="block mt-1 w-full {{ $errors->has('name') ? 'border-red-500 bg-red-100' : '' }} "
                        type="text" name="name" :value="old('name')" required autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2"  id="name-error" />
                </div>

                <!-- Nickname -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="nickname" :value="__('ニックネーム')" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <x-text-input id="nickname" class="block mt-1 w-full {{ $errors->has('nickname') ? 'border-red-500 bg-red-100' : '' }} "
                        type="text" name="nickname" :value="old('nickname')" required autocomplete="nickname" />
                    <x-input-error :messages="$errors->get('nickname')" class="mt-2"  id="nickname-error" />
                </div>

                <!-- Birth -->
                <div class="mt-4">
                <x-input-label for="birth" value="{{ __('生年月日') }}" />
                <x-text-input id="birth" class="block mt-1 w-full" type="date" name="birth" :value="old('birth')" />
                <x-input-error :messages="$errors->get('birth')" class="mt-2"  id="birth-error" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="email" :value="__('Email')" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <x-text-input id="email" class="block mt-1 w-full {{ $errors->has('email') ? 'border-red-500 bg-red-100' : '' }} "
                        type="email" name="email" :value="old('email')" required autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="password" :value="__('Password')" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <x-text-input id="password" class="block mt-1 w-full {{ $errors->has('password') ? 'border-red-500 bg-red-100' : '' }} "
                        type="password" name="password" required autocomplete="new-password" />
                    <div class="flex items-center text-xs text-brown-500 mt-2">8文字以上で入力してください。</div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="mr-2" />
                        <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                            必須
                        </div>
                    </div>
                    <x-text-input id="password_confirmation" class="block mt-1 w-full {{ $errors->has('password_confirmation') ? 'border-red-500 bg-red-100' : '' }} "
                                    type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" id="password_confirmation-error" />
                </div>

                <!-- Terms of Service -->
                <div class="flex items-center mt-4">
                    <input id="link-checkbox" type="checkbox" name="terms" value="1"
                        class="w-4 h-4 text-blue-600 bg-gray-100 checked:bg-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600
                        {{ $errors->has('terms') ? 'border-red-500 bg-red-100' : '' }}">

                    <label for="link-checkbox" class="ms-2 text-sm text-gray-900 dark:text-gray-300">
                        RecipeApp
                        <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">利用規約</a> 並びに
                        <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">個人情報保護方針</a>に同意します
                    </label>
                </div>
                <x-input-error :messages="$errors->get('terms')" class="mt-2" id="terms-error" />
            </div>

            <div class="flex items-center justify-center mt-10 mb-20">
                <a class="no-underline text-sm text-gray-500 hover:text-gray-900 rounded-md" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Confirm') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
<x-footer2 />

@push('scripts')
    @vite('resources/js/registerValidation.js')
@endpush
