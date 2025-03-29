<x-header2 />
{{ Breadcrumbs::render('forgot-password','パスワードの再発行') }}
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mb-10">
        <p class="text-3xl font-extrabold text-yellow-900">パスワードの再発行</p>
    </div>
    <div class="mb-10 text-center text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}<br>
        ※新しくパスワードを発行いたしますので、お忘れになったパスワードはご利用できなくなります。
    </div>
    <form method="POST" action="{{ route('admin.password.email') }}" novalidate class="custom-form">
        @csrf

        <div class="rq-box">
            <div class="rq2-box">
                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full {{ $errors->has('email') ? 'border-red-500 bg-red-100' : '' }} "
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-center mt-20">
                    <x-primary-button>
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
<x-footer2 />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const emailInput = document.getElementById('email');

        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                errorElement.style.display = 'none';
                checkboxInput.classList.remove('border-red-500', 'bg-red-100');
            } else {
                errorElement.style.display = 'block';
                checkboxInput.classList.add('border-red-500', 'bg-red-100');
            }
        });

        emailInput.addEventListener('input', function () {
            if (emailInput.value.trim() !== '') {
                emailErrorElement.style.display = 'none';
                emailInput.classList.remove('border-red-500', 'bg-red-100');
            } else {
                emailErrorElement.style.display = 'block';
                emailInput.classList.add('border-red-500', 'bg-red-100');
            }
        });
    });
</script>
