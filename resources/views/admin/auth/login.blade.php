
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
        <p class="text-2xl font-bold text-rose-950">管理者ログイン</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}" novalidate>
        @csrf

        <!-- Admin ID -->
        <div>
            <x-input-label for="admin_id" :value="__('管理者ID')" />
            <x-text-input id="admin_id" class="block mt-1 w-full {{ $errors->has('admin_id') ? 'border-red-500 bg-red-100' : '' }} "
                type="text" name="admin_id" :value="old('admin_id')" required autofocus autocomplete="admin_id" />
            <x-input-error :messages="$errors->get('admin_id')" class="mt-2" id="name-error" />
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
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const adminIdInput = document.getElementById('admin_id');
        const adminIdErrorElement = document.getElementById('admin_id-error');
        const passwordInput = document.getElementById('password');
        const passwordErrorElement = document.getElementById('password-error');

        adminIdInput.addEventListener('input', function () {
            if (adminIdInput.value.trim() !== '') {
                adminIdErrorElement.style.display = 'none';
                adminIdInput.classList.remove('border-red-500', 'bg-red-100');
            } else {
                adminIdErrorElement.style.display = 'block';
                adminIdInput.classList.add('border-red-500', 'bg-red-100');
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
