@extends('layouts.app')

@section('content')
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full">
            <!-- モーダル風コンテンツ -->
            <div class="bg-white rounded-lg shadow-xl p-8 text-center">
                <!-- アイコン -->
                <img src="{{ Storage::disk('s3')->url('premium.png') }}" alt="" class="w-20 h-auto mx-auto mb-6">

                <!-- タイトル -->
                <h2 class="text-3xl font-bold text-yellow-600 mb-6">プレミアム会員限定</h2>

                <p class="text-gray-600 mb-8">ブックマーク機能をご利用いただくには、会員登録が必要です。</p>

                <!-- 比較表 -->
                <div class="overflow-x-auto mb-8">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr>
                                <th class="text-left p-3 border-b-2 border-gray-200">　</th>
                                <th class="p-3 border-b-2 border-gray-200">無料</th>
                                <th class="p-3 border-b-2 border-gray-200 bg-yellow-50">シルバー</th>
                                <th class="p-3 border-b-2 border-gray-200 bg-yellow-50">ゴールド</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-gray-100">
                                <td class="text-left p-3">すべてのレシピ閲覧</td>
                                <td class="p-3"><i class="fa-solid fa-check text-gray-400"></i></td>
                                <td class="p-3 bg-yellow-50"><i class="fa-solid fa-check text-yellow-600"></i></td>
                                <td class="p-3 bg-yellow-50"><i class="fa-solid fa-check text-yellow-600"></i></td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="text-left p-3">広告なし</td>
                                <td class="p-3"><i class="fa-solid fa-xmark text-gray-400"></i></td>
                                <td class="p-3 bg-yellow-50"><i class="fa-solid fa-check text-yellow-600"></i></td>
                                <td class="p-3 bg-yellow-50"><i class="fa-solid fa-check text-yellow-600"></i></td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="text-left p-3">人気ランキング</td>
                                <td class="p-3"><i class="fa-solid fa-xmark text-gray-400"></i></td>
                                <td class="p-3 bg-yellow-50"><i class="fa-solid fa-check text-yellow-600"></i></td>
                                <td class="p-3 bg-yellow-50"><i class="fa-solid fa-check text-yellow-600"></i></td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="text-left p-3">ブックマーク保存数</td>
                                <td class="p-3 text-gray-500">10件</td>
                                <td class="p-3 bg-yellow-50 text-gray-600">50件</td>
                                <td class="p-3 bg-yellow-50 text-yellow-600">100件</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="text-left p-3">ポイント還元率</td>
                                <td class="p-3 text-gray-500">1%</td>
                                <td class="p-3 bg-yellow-50 text-gray-600">3%</td>
                                <td class="p-3 bg-yellow-50 text-yellow-600">5%</td>
                            </tr>
                            <tr class="border-b border-gray-100">
                                <td class="text-left p-3">レシピ登録</td>
                                <td class="p-3"><i class="fa-solid fa-xmark text-gray-400"></i></td>
                                <td class="p-3 bg-yellow-50"><i class="fa-solid fa-xmark text-gray-400"></i></td>
                                <td class="p-3 bg-yellow-50"><i class="fa-solid fa-check text-yellow-600"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- ボタン -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}"
                       class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white font-bold py-3 px-8 rounded-lg transition">
                        まずは会員登録から
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-block bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-8 rounded-lg transition">
                        ログイン
                    </a>
                </div>

                <!-- 戻るリンク -->
                <div class="mt-8">
                    <a href="{{ route('top') }}" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-arrow-left mr-2"></i>トップページに戻る
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
@endsection
