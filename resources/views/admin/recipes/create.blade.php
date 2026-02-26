@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">レシピ登録</h1>

    @if (session('success'))
        <div class="p-4 mb-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.recipes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <x-validation-errors />

        {{-- タイトル --}}
        <div class="mb-6">
            <label for="title" class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="mt-6 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm">
        </div>

        {{-- 説明 --}}
        <div class="mb-6">
            <label for="description" class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">説明</label>
            <textarea name="description" id="description" rows="10"
                class="mt-6 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm">{{ old('description') }}</textarea>
        </div>

        {{-- カテゴリ --}}
        <div class="mb-6">
            <label for="categories" class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">カテゴリ</label>
            <div class="mt-6 flex flex-wrap gap-4"> <!-- 横並びにするために flex と gap を使用 -->
                @php
                    // old() に値があればそれを、なければ編集時は $recipe のカテゴリーを使用、どちらもなければ空配列
                    $selectedCategories = old('categories', isset($recipe) ? $recipe->categories->pluck('uuid')->toArray() : []);
                @endphp
                {{-- カテゴリのチェックボックスを表示 --}}
                @foreach ($categories as $category)
                    <div>
                        <label>
                            <input type="checkbox" name="categories[]" value="{{ $category->uuid }}"
                                {{ in_array($category->uuid, $selectedCategories) ? 'checked' : '' }}>
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- 選択したカテゴリを表示 --}}
        <div id="category-list"></div>

        {{-- 人数 --}}
        <div class="mt-6 mb-6 flex space-x-4">
            <div class="w-1/2">
                <label for="servings" class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">何人前</label>
                <input type="number" name="servings" id="servings" value="{{ old('servings') }}"
                    class="mt-6 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm" min="1">
            </div>
            {{-- 調理時間 --}}
            <div class="w-1/2">
                <label for="cooking_time" class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">調理時間（分）</label>
                <input type="number" name="cooking_time" id="cooking_time" value="{{ old('cooking_time') }}"
                    class="mt-6 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm" min="1">
            </div>
        </div>

        {{-- 材料の登録 --}}
        <div class="mb-6">
            <label class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100 mb-2">材料</label>

            <div id="ingredient-list">
                <div class="flex items-center justify-around mb-2 ingredient-item">
                    {{-- 材料選択（セレクトボックス） --}}
                    <select name="ingredient_uuids[]"
                        class="ingredient-select mr-2 w-64 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm"
                        required>
                        <option value="">材料を選択</option>
                        @foreach($ingredients as $ingredient)
                            <option value="{{ $ingredient->uuid }}">{{ $ingredient->name }}</option>
                        @endforeach
                    </select>

                    {{-- 分量 --}}
                    <input type="text" name="quantities[]" value="{{ old('quantities.0') }}"
                        class="mr-2 w-32 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm"
                        placeholder="分量" required>

                    {{-- 単位 --}}
                    <input type="text" name="units[]" value="{{ old('units.0') }}"
                        class="mr-2 w-28 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm"
                        placeholder="単位">

                    {{-- 削除ボタン --}}
                    <button type="button"
                        class="remove-ingredient text-red-600 text-sm hover:underline hover:bg-transparent focus:outline-none bg-transparent border-none">
                        削除
                    </button>
                </div>
            </div>

            {{-- 追加ボタン --}}
            <button type="button" id="add-ingredient"
                class="mt-2 text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none rounded-md py-2 px-4">＋ 材料を追加
            </button>
        </div>

            {{-- 手順 --}}
            <div class="mb-6">
                <label class="mt-6 px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">手順</label>

                <div id="steps-container">
                    @if (isset($recipe))
                        @foreach ($recipe->steps as $i => $step)
                            {{-- 編集用のステップ入力 --}}
                        @endforeach
                    @else
                        {{-- 新規登録用の空欄ステップ --}}
                        <div class="step-item mt-6 mb-4 p-4 border border-gray-300 rounded-md relative">
                            <input type="hidden" name="step_uuids[]" value="">
                            <p class="text-sm text-gray-500 mb-2">ステップ 1</p>
                            <textarea name="step_descriptions[]" rows="3" placeholder="説明"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mb-2"></textarea>
                            <input type="file" name="step_images[]" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0 file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            <button type="button"
                                class="remove-step text-red-600 text-sm hover:underline hover:bg-transparent focus:outline-none bg-transparent border-none hover:underline absolute top-2 right-2">削除
                            </button>
                        </div>
                    @endif
                </div>


            {{-- 追加ボタン --}}
            <button type="button" id="add-step"
                class="mt-2 text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none rounded-md py-2 px-4">＋ 手順を追加</button>
        </div>


        {{-- 画像 --}}
        <div class="mb-6">
            <label for="image" class="mb-6 px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">画像</label>

            <input type="file" name="image" id="image"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0 file:text-sm file:font-semibold
                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                accept="image/*">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.recipes.index') }}" class="px-6 py-2 mr-2 bg-gray-300 text-sm font-medium text-gray-700 rounded-md hover:text-white hover:bg-gray-400 transition">
                キャンセル
            </a>
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">登録する
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @vite('resources/js/recipe_form_select.js')
@endpush
