@extends('layouts.admin')
@section('content')

<div class="mx-auto max-w-4xl bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-6">材料登録</h2>

    <x-validation-errors />

    <form action="{{ route('admin.ingredients.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- 左カラム：材料情報 --}}
            <div class="space-y-4">
                <div>
                    <label>材料名</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2">
                </div>

                <div>
                    <label>季節（該当月を選択）</label>
                    <div class="flex flex-wrap gap-x-2 mt-2">
                        @for ($i = 1; $i <= 12; $i++)
                            <label class="flex items-center mr-2">
                                <input type="checkbox" name="seasonality[]" value="{{ $i }}"
                                    {{ is_array(old('seasonality')) && in_array($i, old('seasonality')) ? 'checked' : '' }} class="mr-1">
                                {{ $i }}月
                            </label>
                        @endfor
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-1">
                        <label>価格</label>
                        <input type="number" name="price" step="0.01" value="{{ old('price') }}" class="w-full border p-2" min="1">
                    </div>
                    <div class="flex-1">
                        <label>単位</label>
                        <input type="text" name="unit" value="{{ old('unit') }}" class="w-full border p-2">
                    </div>
                </div>

                <div>
                    <label>カテゴリー</label>
                    <select name="i_category_uuid" class="w-full border p-2">
                        <option value="">選択してください</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->uuid }}" {{ old('i_category_uuid') == $category->uuid ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>画像</label>
                    <input type="file" name="image" class="w-full border p-2">
                </div>
            </div>

            {{-- 右カラム：セール情報 --}}
            <div class="space-y-4 bg-gray-50 rounded p-4 border">
                <h3 class="text-lg font-semibold mb-2">セール情報</h3>
                <div>
                    <label>セール割引率（%）</label>
                    <input type="number" name="discount_percent" min="1" max="100"
                        value="{{ old('discount_percent') }}" class="w-full border p-2">
                </div>
                <div>
                    <label>セール開始日時</label>
                    <input type="datetime-local" name="start_at"
                        value="{{ old('start_at') }}" class="w-full border p-2">
                </div>
                <div>
                    <label>セール終了日時</label>
                    <input type="datetime-local" name="end_at"
                        value="{{ old('end_at') }}" class="w-full border p-2">
                </div>
            </div>
        </div>

        <div class="flex gap-4 mt-8">
            <a href="{{ route('admin.ingredients.index') }}"
               class="bg-gray-300 text-gray-700 px-4 py-2 rounded w-full text-center hover:bg-gray-400 transition">
                キャンセル
            </a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">登録</button>
        </div>
    </form>
</div>

@endsection
