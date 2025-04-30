@extends('layouts.admin')
@section('content')

    <h2 class="text-2xl font-bold mb-4">材料登録</h2>

    @if (session('success'))
        <div class="p-4 mb-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.ingredients.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label>材料名</label>
            <input type="text" name="name" class="w-full border p-2" required>
        </div>

        <div>
            <label>季節（該当月を選択）</label><br>
            @for ($i = 1; $i <= 12; $i++)
                <label class="mr-2"><input type="checkbox" name="seasonality[]" value="{{ $i }}"> {{ $i }}月</label>
            @endfor
        </div>

        <div>
            <label>価格</label>
            <input type="number" name="price" step="0.01" class="w-full border p-2">
        </div>

        <div>
            <label>単位</label>
            <input type="text" name="unit" class="w-full border p-2">
        </div>

        <div>
            <label>カテゴリー</label>
            <select name="i_category_uuid" class="w-full border p-2" required>
                <option value="">選択してください</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->uuid }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>画像</label>
            <input type="file" name="image" class="w-full border p-2">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">登録</button>
    </form>

@endsection
