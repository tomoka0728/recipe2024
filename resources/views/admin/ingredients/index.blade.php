@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">商品管理</h2>
        <a href="{{ route('admin.ingredients.create') }}"
            class="bg-blue-500 hover:bg-blue-600 text-white hover:text-white font-semibold py-2 px-4 rounded">
        <i class="fas fa-plus mr-2"></i> 商品を登録
        </a>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap items-center gap-4">
        <input type="text" name="search" placeholder="商品名検索" value="{{ request('search') }}"
               class="border rounded px-3 py-2 w-48">

        <select name="category" class="border rounded px-3 py-2">
            <option value="">全カテゴリ</option>
            @foreach ($categories as $category)
                <option value="{{ $category->uuid }}" {{ request('category') == $category->uuid ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>

        <select name="sort" class="border rounded px-3 py-2">
            <option value="">並び替え</option>
            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>名前昇順</option>
            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>名前降順</option>
            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>価格昇順</option>
            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>価格降順</option>
            <option value="created_asc" {{ request('sort') == 'created_asc' ? 'selected' : '' }}>作成日昇順</option>
            <option value="created_desc" {{ request('sort') == 'created_desc' ? 'selected' : '' }}>作成日降順</option>
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">検索</button>
        <a href="{{ route('admin.ingredients.index') }}"
        class="bg-gray-300 hover:bg-gray-400 text-gray-800 hover:text-white font-semibold py-2 px-4 rounded">
        リセット
    </a>
    </form>

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6">商品名</th>
                <th class="py-3 px-6">価格</th>
                <th class="py-3 px-6">カテゴリ</th>
                <th class="py-3 px-6 text-center">　</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @forelse ($ingredients as $ingredient)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">{{ $ingredient->name }}</td>
                    <td class="py-3 px-6">{{ number_format($ingredient->price) }} 円</td>
                    <td class="py-3 px-6">
                        @if($ingredient->categories->isNotEmpty())
                            {{ $ingredient->categories->pluck('name')->implode(', ') }}
                        @else
                            未設定
                        @endif
                    </td>
                    <td class="py-3 px-6 text-right">
                        <div class="flex justify-end space-x-4">
                            {{-- 編集 --}}
                            <a href="{{ route('admin.ingredients.edit', $ingredient->uuid) }}"
                                class="text-blue-600 hover:underline flex items-center">
                                <i class="fas fa-edit mr-1"></i> 編集
                            </a>
    
                            {{-- 削除 --}}
                            <form action="{{ route('admin.ingredients.destroy', $ingredient->uuid) }}"
                                  method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-600 hover:underline hover:bg-transparent focus:outline-none bg-transparent border-none">
                                    <i class="fas fa-trash-alt mr-1"></i> 削除
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">該当する商品がありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    

    <div class="mt-4">
        {{ $ingredients->appends(request()->query())->links() }}
    </div>
</div>
@endsection
