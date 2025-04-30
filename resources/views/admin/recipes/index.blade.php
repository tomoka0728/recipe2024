@extends('layouts.admin')
@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">レシピ管理</h2>
            <a href="{{ route('admin.recipes.create') }}"
               class="bg-blue-500 hover:bg-blue-600 hover:text-white text-white font-semibold py-2 px-4 rounded">
                <i class="fas fa-plus mr-2"></i> レシピを登録
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($recipes as $recipe)
                <div class="bg-white border rounded-lg p-4 flex flex-col">
                    @if ($recipe->image_path)
                        <img src="{{ Storage::disk('s3')->url($recipe->image_path) }}" alt="{{ $recipe->title }}"
                             class="w-full h-40 object-cover rounded-md mb-4">
                    @else
                        <div class="w-full h-40 bg-gray-200 flex items-center justify-center rounded-md mb-4 text-gray-500">
                            No Image
                        </div>
                    @endif
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $recipe->title }}</h3>
                    <p class="text-sm text-gray-500">作成日: {{ $recipe->created_at->format('Y年m月d日') }}</p>
                    <p class="text-sm text-gray-500 mb-4">更新日: {{ $recipe->updated_at ? $recipe->updated_at->format('Y年m月d日') : '未更新' }}</p>
                    <div class="flex justify-end space-x-4 mt-4">
                        <!-- 編集ボタン -->
                        <a href="{{ route('admin.recipes.edit', $recipe->uuid) }}" class="text-blue-600 hover:underline flex items-center">
                            <i class="fas fa-edit mr-1"></i> 編集
                        </a>

                        <!-- 削除ボタン -->
                        <form action="{{ route('admin.recipes.destroy', $recipe->uuid) }}" method="POST" onsubmit="return confirm('本当に削除してもよろしいですか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline hover:bg-transparent focus:outline-none bg-transparent border-none">
                                <i class="fas fa-trash-alt mr-1"></i> 削除
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
