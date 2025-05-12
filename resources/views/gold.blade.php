@extends('layouts.app')
@section('content')
    {{ Breadcrumbs::render('gold', 'ゴールド会員') }}
    <x-guest-layout>
        <div id="container" class="wrapper">
            <main class="silver-main">
                <h1 class="membership-title">
                    <div class="silver-header">
                        <img src="{{ Storage::disk('s3')->url('GoldMembership.png') }}">
                    </div>
                    <div class="membership-content">
                        <p>ゴールド会員プランでは、シルバープランの特典に加え、レシピ投稿がご利用いただけます。</p>
                        <p>ポイント還元率も5%にアップし、よりお得にご利用いただけます。</p>
                    </div>
            </main>
        </div>

        {{-- シルバー会員特典セクション --}}
        <h2 class="text-2xl font-bold text-center text-gray-700">ー 4つの魅力 ー</h2>
        <section class="silver-section py-12 bg-white">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-8">
                    <div class="gold-card w-full bg-white p-6 rounded-xl shadow-md text-center">
                        <div class="silver-icon text-4xl text-yellow-600 mb-4">
                            <i class="fa-solid fa-coins"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">ポイント還元率5%</h3>
                        <p>購入ごとに5%のポイントを付与。<br>お得にお買い物ができます。</p>
                    </div>

                    <div class="gold-card w-full bg-white p-6 rounded-xl shadow-md text-center">
                        <div class="silver-icon text-4xl text-yellow-600 mb-4">
                            <i class="fa-solid fa-ban"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">広告なし</h3>
                        <p>快適な閲覧環境を提供。<br>広告なしでレシピを楽しめます。</p>
                    </div>

                    <div class="gold-card w-full bg-white p-6 rounded-xl shadow-md text-center">
                        <div class="silver-icon text-4xl text-yellow-600 mb-4">
                            <i class="fa-solid fa-ranking-star"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">人気ランキング閲覧</h3>
                        <p>人気レシピのランキングをチェック可能。<br>トレンドを見逃しません。</p>
                    </div>

                    <div class="gold-card w-full bg-white p-6 rounded-xl shadow-md text-center">
                        <div class="silver-icon text-4xl text-yellow-600 mb-4">
                            <i class="fa-solid fa-file-pen"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">レシピ投稿・編集機能</h3>
                        <p>自分だけのレシピを投稿し、シェアできます。</p>
                    </div>
                </div>
            </div>
        </section>


        {{-- 比較表 --}}
        <h2 class="text-2xl font-bold text-center text-gray-700">ー 料金プラン ー</h2>
        <div
            class="pricing-cards-container gold-page mt-16 mx-auto w-full max-w-4xl grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- 無料プラン -->
            <div class="pricing-card p-6 border rounded-lg shadow-md bg-white">
                <h3 class="text-2xl text-center font-bold mb-1">一般</h3>
                <p class="text-center text-lg text-gray-600 mb-4">¥0 / 月</p>
                <hr class="border-t border-gray-300 mb-4">
                <ul class="list-none mb-6">
                    <li><i class="fa-solid fa-book text-gray-500"></i>すべてのレシピ閲覧</li>
                    <li><i class="fa-solid fa-coins text-gray-500"></i> ポイント還元率: 1%</li>
                </ul>
            </div>

            <!-- シルバープラン -->
            <div class="pricing-card p-6 border rounded-lg shadow-md bg-white">
                <h3 class="text-2xl text-center font-bold mb-1">シルバー</h3>
                <p class="text-center text-lg text-gray-700 mb-4">¥300 / 月</p>
                <hr class="border-t border-gray-400 mb-4">
                <ul class="list-none mb-6">
                    <li><i class="fa-solid fa-book text-gray-500"></i> すべてのレシピ閲覧</li>
                    <li><i class="fa-solid fa-bullhorn text-gray-500"></i> 広告なし</li>
                    <li><i class="fa-solid fa-chart-line text-gray-500"></i> 人気ランキング</li>
                    <li><i class="fa-solid fa-coins text-gray-500"></i> ポイント還元率: 3%</li>
                </ul>
            </div>

            <!-- ゴールドプラン -->
            <div class="pricing-card p-6 border rounded-lg shadow-md">
                <h3 class="text-3xl text-center font-bold mb-1 text-yellow-500">ゴールド</h3>
                <p class="text-center text-lg text-yellow-600 mb-4">¥600 / 月</p>
                <hr class="border-t border-yellow-300 mb-4">
                <ul class="list-none mb-6">
                    <li><i class="fa-solid fa-book text-yellow-500"></i> すべてのレシピ閲覧</li>
                    <li><i class="fa-solid fa-bullhorn text-yellow-500"></i> 広告なし</li>
                    <li><i class="fa-solid fa-chart-line text-yellow-500"></i> 人気ランキング</li>
                    <li><i class="fa-solid fa-coins text-yellow-500"></i> ポイント還元率: 5%</li>
                    <li><i class="fa-solid fa-edit text-yellow-500"></i> レシピ登録</li>
                </ul>
            </div>
        </div>

        </section>

        {{-- CTAセクション --}}
        <div class="gold-section mt-16 text-center">
            <h2 class="text-2xl font-bold mb-4">月額 <span class="text-yellow-600 text-3xl">¥980</span></h2>
            <p class="mb-6 text-gray-600">最上級のレシピ体験を、今すぐはじめよう！</p>

            <a href="{{ route('membership.edit') }}"
                class="inline-block px-8 py-3 bg-yellow-500 text-white font-semibold rounded-full hover:bg-yellow-600 transition duration-300">
                ゴールド会員に登録する
            </a>

            <p class="mt-4 text-sm text-gray-500">いつでもキャンセル可能です。シルバー会員にも変更可能。</p>
        </div>

        <!-- FAQセクション -->
        <div class="faq-section px-20 mt-20 mb-20 w-full mx-auto">
            <h2 class="text-2xl font-bold text-center mb-8 text-gray-700">ー よくある質問 ー</h2>

            @php
                $faqs = [
                    [
                        'q' => 'ゴールド会員の支払い方法は？',
                        'a' => 'クレジットカード決済に対応しています。その他の方法も順次追加予定です。',
                    ],
                    [
                        'q' => 'ゴールド会員はいつでも解約できますか？',
                        'a' => 'はい。マイページから簡単に解約できます。次回更新日まで特典を利用できます。',
                    ],
                    ['q' => 'シルバー会員に戻せますか？', 'a' => 'はい。マイページからプラン変更が可能です。'],
                    [
                        'q' => 'レシピの投稿はどうやって行いますか？',
                        'a' => 'マイページの「レシピ投稿」から行えます。画像・手順も一緒に登録できます。',
                    ],
                ];
            @endphp

            @foreach ($faqs as $index => $faq)
                <div class="faq-section mt-10 w-full max-w-[600px] mx-auto">
                    <button
                        class="w-full text-left flex justify-between items-center text-gray-600 font-medium focus:outline-none faq-btn"
                        data-index="{{ $index }}">
                        <span>{{ $faq['q'] }}</span>
                        <svg class="w-5 h-5 transition-transform duration-300 text-gray-400 arrow-icon" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="mt-2 text-sm text-gray-500 faq-answer hidden" id="faq-answer-{{ $index }}">
                        {{ $faq['a'] }}
                    </div>
                </div>
            @endforeach
        </div>
        </main>
        </div>
    </x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/top.css', 'resources/css/membership.css'])
@endpush
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    @vite('resources/js/membership.js')
@endpush
