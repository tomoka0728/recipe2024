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
        <p class="text-3xl font-extrabold text-yellow-900">内容確認</p>
        <p class="mt-5 text-yellow-900">入力内容をご確認いただき、よろしければ「登録する」ボタンを押してください。</p>
    </div>
    <form method="POST" action="{{ route('register-complete') }}" novalidate class="custom-form">
        <input type="hidden" name="password" value="{{ session('password') }}">
        @csrf

        <div class="rq-box">
            <div class="rq2-box">
                <!-- Name -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <label for="name" class="font-extrabold text-yellow-900 border-b border-gray-300 w-full">お名前</label>
                    </div>
                    <div class="flex items-center text-gray-500 mt-2">{{ $name }}</div>
                </div>

                <!-- Birth -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <label for="birth" class="font-extrabold text-yellow-900 border-b border-gray-300 w-full">生年月日</label>
                    </div>
                    <div class="flex items-center text-gray-500 mt-2">{{ $birth ? $birth : 'ご登録なし' }}</div>
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <label for="email" class="font-extrabold text-yellow-900 border-b border-gray-300 w-full">メールアドレス</label>
                    </div>
                    <div class="flex items-center text-gray-500 mt-2">{{ $email }}</div>
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <label for="password" class="font-extrabold text-yellow-900 border-b border-gray-300 w-full">パスワード</label>
                    </div>
                    <div class="flex items-center text-gray-500 mt-2">ご入力いただいたパスワード</div>
                </div>

                <!-- Terms of Service -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <label for="terms_accepted" class="font-extrabold text-yellow-900 border-b border-gray-300 w-full">利用規約</label>
                    </div>
                    <div class="flex items-center text-gray-500 mt-2">{{ $terms_accepted ? '同意する' : '同意しない' }}</div>
                </div>
            </div>

            <div class="flex items-center justify-center mt-10 mb-20">
                <x-secondary-button class="ms-4" onclick="window.history.back()">
                    {{ __('修正する') }}
                </x-secondary-button>
                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
<x-footer2 />
