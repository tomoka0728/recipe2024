<x-header />
<x-guest-layout>

    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-2xl font-bold text-rose-950">会員ログイン</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full {{ $errors->has('email') ? 'border-red-500 bg-red-100' : '' }} "
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" id="email-error" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full {{ $errors->has('password') ? 'border-red-500 bg-red-100' : '' }} "
                            type="password" name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" id="password-error" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>


    <!-- register -->
    <div class="block mt-10">
        <span class="ms-2 text-sm text-gray-600">初めてのご利用ですか？</span>
    </div>
    <div class="block mt-1">
        <x-secondary-button class="ms-3">
            <a href="/" class="text-sm text-gray-600 hover:text-gray-900 rounded-md">
                アカウントを登録する
        </x-secondary-button>
    </div>
</x-guest-layout>
<x-footer />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.getElementById('email');
        const emailErrorElement = document.getElementById('email-error');
        const passwordInput = document.getElementById('password');
        const passwordErrorElement = document.getElementById('password-error');

        emailInput.addEventListener('input', function () {
            if (emailInput.value.trim() !== '') {
                emailErrorElement.style.display = 'none';
                emailInput.classList.remove('border-red-500', 'bg-red-100');
            } else {
                emailErrorElement.style.display = 'block';
                emailInput.classList.add('border-red-500', 'bg-red-100');
            }
        });

        passwordInput.addEventListener('input', function () {
            if (passwordInput.value.trim() !== '') {
                passwordErrorElement.style.display = 'none';
                passwordInput.classList.remove('border-red-500', 'bg-red-100');
            } else {
                passwordErrorElement.style.display = 'block';
                passwordInput.classList.add('border-red-500', 'bg-red-100');
            }
        });
    });
</script>
