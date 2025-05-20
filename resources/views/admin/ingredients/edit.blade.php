@extends('layouts.admin')
@section('content')

<h2 class="text-2xl font-bold mb-4">材料編集</h2>

@if (session('success'))
    <div class="p-4 mb-4 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('admin.ingredients.update', $ingredient->uuid) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label>材料名</label>
        <input type="text" name="name" value="{{ old('name', $ingredient->name) }}" class="w-full border p-2">
    </div>

    <div>
        <label>季節（該当月を選択）</label><br>
        @php
            $selectedMonths = json_decode($ingredient->seasonality, true) ?? [];
        @endphp
        @for ($i = 1; $i <= 12; $i++)
            <label class="mr-2">
                <input type="checkbox" name="seasonality[]" value="{{ $i }}"
                    {{ in_array($i, $selectedMonths) ? 'checked' : '' }}> {{ $i }}月
            </label>
        @endfor
    </div>

    <div>
        <label>価格</label>
        <input type="number" name="price" step="0.01" value="{{ old('price', $ingredient->price) }}" class="w-full border p-2">
    </div>

    <div>
        <label>単位</label>
        <input type="text" name="unit" value="{{ old('unit', $ingredient->unit) }}" class="w-full border p-2">
    </div>

    <div>
        <label>カテゴリー</label>
        <select name="i_category_uuid" class="w-full border p-2">
            <option value="">選択してください</option>
            @foreach ($categories as $category)
                <option value="{{ $category->uuid }}"
                    {{ (old('i_category_uuid', $ingredientCategory->i_category_uuid ?? '') == $category->uuid) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label>画像（変更が必要な場合のみ選択）</label><br>
        @if ($ingredient->image_path)
            <img src="{{ Storage::disk('s3')->url($ingredient->image_path) }}" alt="現在の画像" class="w-32 mb-2">
        @endif
        <input type="file" name="image" class="w-full border p-2">
    </div>
    @if ($errors->any())
    <div class="p-4 mb-4 bg-red-100 text-red-800 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">更新</button>
</form>

@endsection
