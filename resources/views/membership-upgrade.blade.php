@extends('layouts.app')
@section('content')
{{ Breadcrumbs::render('membership.edit', '会員グレード変更') }}
<x-guest-layout>
    <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10 w-full !pt-20">
        <p class="text-3xl font-extrabold text-yellow-900">会員グレード変更</p>
    </div>
    @if (session('status'))
        <div class="alert alert-success bg-green-500 text-white font-bold text-lg p-4 mb-6">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('membership.update') }}" class="w-full mx-auto" id="membership-form">
        @csrf
        <div class="rq3-box mb-10">
            <div>
                <div class="mb-8">
                    <p class="text-lg mb-8 font-bold text-rose-950 text-center">ご希望の会員グレードを選択してください</p>
                    <fieldset class="radio-3 mt-4 flex justify-center gap-8 flex-wrap">
                        <label class="flex items-center space-x-2 cursor-pointer w-full sm:w-1/3 lg:w-1/4" data-status-value="{{ \App\Enums\MembershipStatus::General->value }}">
                            <input type="radio" name="status" value="{{ \App\Enums\MembershipStatus::General->value }}"
                                {{ $currentStatus === \App\Enums\MembershipStatus::General ? 'checked' : '' }}>
                            <span class="font-semibold text-center">一般会員（無料）</span>
                        </label>

                        <label class="flex items-center space-x-2 cursor-pointer w-full sm:w-1/3 lg:w-1/4">
                            <input type="radio" name="status" value="{{ \App\Enums\MembershipStatus::Silver->value }}"
                                {{ $currentStatus === \App\Enums\MembershipStatus::Silver ? 'checked' : '' }}>
                            <span class="font-semibold text-center">シルバー会員（月額300円）</span>
                        </label>

                        <label class="flex items-center space-x-2 cursor-pointer w-full sm:w-1/3 lg:w-1/4">
                            <input type="radio" name="status" value="{{ \App\Enums\MembershipStatus::Gold->value }}"
                                {{ $currentStatus === \App\Enums\MembershipStatus::Gold ? 'checked' : '' }}>
                            <span class="font-semibold text-center">ゴールド会員（月額600円）</span>
                        </label>
                    </fieldset>
                    @error('status')
                        <div class="text-red-500 text-sm text-center mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="bg-yellow-50 p-4 text-sm text-yellow-900 rounded shadow-sm text-center">
                    <p>※ 有料プランは毎月自動更新されます。</p>
                    <p>※ いつでも無料会員に戻すことが可能です。</p>
                </div>
            </div>

            <div class="flex items-center justify-center mt-10 mb-20">
                <a class="no-underline text-sm text-gray-500 hover:text-gray-900 rounded-md" href="{{ route('mypage') }}">
                    マイページに戻る
                </a>
                <x-primary-button class="ms-4">
                    変更を確定する
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>
@endsection
@push('styles')
    @vite(['resources/css/mypage.css'])
@endpush

@push('scripts')
    <script>
        // PHPの値をJavaScriptに渡す
        var generalStatusValue = {!! json_encode(\App\Enums\MembershipStatus::General->value) !!};
        console.log('PHPから渡された値: ', generalStatusValue);
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    @vite(['resources/js/membership.js'])
@endpush
