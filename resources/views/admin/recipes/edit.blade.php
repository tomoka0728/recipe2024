@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded-2xl shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">レシピ編集</h1>

    @if (session('success'))
        <div class="p-4 mb-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.recipes.update', ['uuid' => $recipe->uuid]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <x-validation-errors />

        {{-- タイトル --}}
        <div class="mb-6">
            <label for="title" class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">タイトル</label>
            <input type="text" name="title" id="title" value="{{ old('title', $recipe->title) }}"
                class="mt-6 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm" >
        </div>

        {{-- 説明 --}}
        <div class="mb-6">
            <label for="description" class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">説明</label>
            <textarea name="description" id="description" rows="10"
                class="mt-6 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm">{{ old('description', $recipe->description) }}</textarea>
        </div>

        {{-- カテゴリ --}}
        <div class="mb-6">
            <label for="categories" class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">カテゴリ</label>
            <div class="mt-6 flex flex-wrap gap-4"> <!-- 横並びにするために flex と gap を使用 -->
                @foreach ($categories as $category)
                    <div class="flex items-center mb-2 w-auto">
                        <input type="checkbox" name="categories[]" value="{{ $category->uuid }}"
                            id="category_{{ $category->uuid }}"
                            {{ in_array($category->uuid, old('categories', $recipe->categories->pluck('uuid')->toArray())) ? 'checked' : '' }}
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="category_{{ $category->uuid }}" class="ml-2 text-sm font-medium text-gray-700">{{ $category->name }}</label>
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
                <input type="number" name="servings" id="servings" value="{{ old('servings', $recipe->servings ?? '') }}"
                    class="mt-6 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm" min="1">
            </div>
            {{-- 調理時間 --}}
            <div class="w-1/2">
                <label for="cooking_time" class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">調理時間（分）</label>
                <input type="number" name="cooking_time" id="cooking_time" value="{{ old('cooking_time', $recipe->cooking_time ?? '') }}"
                    class="mt-6 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm" min="1">
            </div>
        </div>

        {{-- 材料の編集 --}}
        <div class="mb-6">
            <label class="px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100 mb-2">材料</label>

            <div id="ingredient-list">
                @foreach ($recipe->ingredients as $i => $ingredient)
                <div class="flex items-center mb-4 ingredient-item">
                    {{-- 材料uuid --}}
                    <input type="hidden" name="ingredient_uuids[]" value="{{ $ingredient->uuid }}">

                    {{-- 材料名（オートコンプリート） --}}
                    <input type="text" name="ingredient_names[]" value="{{ $ingredient->name }}"
                    class="ingredient-name mr-2 flex-1 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm"
                    placeholder="材料名" >
                    <div class="relative">
                        <ul class="autocomplete-list z-10 bg-white border border-gray-300 rounded-md shadow-md max-h-50 overflow-y-auto hidden"></ul>
                    </div>

                    {{-- 分量 --}}
                    <input type="text" name="quantities[]" value="{{ $ingredient->pivot->quantity }}"
                        class="mr-2 w-32 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm"
                        placeholder="分量" >

                    {{-- 単位 --}}
                    <input type="text" name="units[]" value="{{ $ingredient->pivot->unit }}"
                        class="mr-2 w-28 rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 focus:outline-none sm:text-sm"
                        placeholder="単位">

                    {{-- 削除ボタン --}}
                    <button type="button" class="remove-ingredient text-red-600 text-sm hover:underline hover:bg-transparent focus:outline-none bg-transparent border-none">削除</button>
                </div>
                @endforeach
            </div>

            {{-- 追加ボタン --}}
            <button type="button" id="add-ingredient"
                class="mt-2 text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none rounded-md py-2 px-4">＋ 材料を追加</button>
        </div>

        {{-- 手順 --}}
        <div class="mb-6">
            <label class="mt-6 px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">手順</label>

            <div id="steps-container">
                @foreach ($recipe->steps as $i => $step)
                    <div class="step-item mt-6 mb-4 p-4 border border-gray-300 rounded-md relative">
                        <input type="hidden" name="step_uuids[]" value="{{ $step->uuid }}">

                        {{-- ステップ番号 --}}
                        <p class="text-sm text-gray-500 mb-2">ステップ {{ $step->step_number }}</p>

                        {{-- 説明 --}}
                        <textarea name="step_descriptions[]" rows="3" placeholder="説明"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mb-2"
                            required>{{ old('step_descriptions.' . $i, $step->description) }}</textarea>

                        {{-- 画像表示 --}}
                        @if ($step->image_path)
                            <div class="mb-2">
                                <img src="{{ Storage::disk('s3')->url($step->image_path) }}" alt="ステップ画像" class="h-32 object-cover rounded-md">
                            </div>
                        @endif

                        {{-- 新しい画像アップロード --}}
                        <input type="file" name="step_images[]" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                            file:rounded-md file:border-0 file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">

                        {{-- 削除ボタン --}}
                        <button type="button"
                            class="remove-step text-red-600 text-sm hover:underline hover:bg-transparent focus:outline-none bg-transparent border-none hover:underline absolute top-2 right-2">削除</button>
                    </div>
                @endforeach
            </div>

            {{-- 追加ボタン --}}
            <button type="button" id="add-step"
                class="mt-2 text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none rounded-md py-2 px-4">＋ 手順を追加</button>
        </div>


        {{-- 画像 --}}
        <div class="mb-6">
            <label for="image" class="mb-6 px-4 py-2 block text-sm font-medium text-gray-700 bg-red-100">画像</label>
            @if ($recipe->image_path)
                <div class="mb-2">
                    <img src="{{ Storage::disk('s3')->url($recipe->image_path) }}" alt="レシピ画像" class="h-40 object-cover rounded-lg">
                </div>
            @endif
            <input type="file" name="image" id="image"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                file:rounded-md file:border-0 file:text-sm file:font-semibold
                file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept="image/*">
        </div>

        <div class="flex justify-end">
            <a href="{{ route('admin.recipes.index') }}" class="px-6 py-2 mr-2 bg-gray-300 text-sm font-medium text-gray-700 rounded-md hover:text-white hover:bg-gray-400 transition">
                キャンセル
            </a>
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">更新する
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
    <script>
        const ingredientSearchUrl = "{{ route('admin.ingredients.search') }}";
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    @vite('resources/js/recipe_form.js')
@endpush
