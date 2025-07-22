<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- 現在のパスワード -->
        <div class="mt-4">
            <div class="flex items-center">
                <x-input-label for="update_password_current_password" :value="__('現在のパスワード')" class="mr-2" />
                <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                    必須
                </div>
            </div>
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="block mt-1 w-full {{ $errors->updatePassword->has('current_password') ? 'border-red-500 bg-red-100' : '' }}"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- 新しいパスワード -->
        <div class="mt-4">
            <div class="flex items-center">
                <x-input-label for="update_password_password" :value="__('新しいパスワード')" class="mr-2" />
                <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                    必須
                </div>
            </div>
            <x-text-input id="update_password_password" name="password" type="password"
                class="block mt-1 w-full {{ $errors->updatePassword->has('password') ? 'border-red-500 bg-red-100' : '' }}"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- パスワード確認 -->
        <div class="mt-4">
            <div class="flex items-center">
                <x-input-label for="update_password_password_confirmation" :value="__('新しいパスワード（確認）')" class="mr-2" />
                <div class="border border-red-500 bg-white text-red-500 px-1 rounded text-xs">
                    必須
                </div>
            </div>
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="block mt-1 w-full {{ $errors->updatePassword->has('password_confirmation') ? 'border-red-500 bg-red-100' : '' }}"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- 更新ボタン -->
        <div class="flex items-center justify-center gap-4 mt-6">
            <x-primary-button>{{ __('パスワードを更新') }}</x-primary-button>
        </div>
    </form>
</section>
