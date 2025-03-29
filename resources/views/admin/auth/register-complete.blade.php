<x-header2 />
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 w-full">
        <ul class="progressbar">
            <li class="complete">ご入力</li>
            <li class="complete">ご確認</li>
            <li class="active">完了</li>
        </ul>
    </div>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-20 mb-20">
        <p class="text-3xl font-extrabold text-yellow-900">お客様情報登録完了</p>
        <p class="mt-10 text-center text-yellow-900 ">ご登録いただきありがとうございます。<br>
            ご登録いただいたメールアドレスに登録完了メールをお送りいたしましたのでご確認ください。
        </p>
    </div>

    <div class="flex items-center justify-center mt-10 mb-20">
        <a href="{{ route('admin.top') }}">
            <x-primary-button class="ms-4">
                {{ __('トップページへ') }}
            </x-primary-button>
        </a>
    </div>
</x-guest-layout>
<x-footer2 />
