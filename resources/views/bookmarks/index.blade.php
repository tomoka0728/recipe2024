@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('bookmarks.index') }}
<x-guest-layout>
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-center text-yellow-900 mb-8">ブックマーク一覧</h1>

            <div class="mx-auto">
                <!-- ナビゲーションボタン -->
                <div class="flex justify-start items-center mb-6">
                    <a href="{{ route('mypage') }}"
                       class="inline-flex items-center text-gray-600 hover:text-gray-800 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        マイページに戻る
                    </a>
                </div>

                <!-- レシピのブックマーク -->
                <div class="mb-12">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-semibold text-yellow-900 flex items-center">
                            <i class="fas fa-utensils mr-2"></i>
                            レシピ（{{ $totalRecipes }}件）
                        </h2>
                        @if($totalRecipes > 4)
                        <a href="{{ route('bookmarks.recipes') }}"
                           class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                            続きを見る
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        @endif
                    </div>

                    @if($savedRecipes->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                            @foreach($savedRecipes as $saved)
                                @if($saved->item)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                                    <a href="{{ route('recipes.show', $saved->item->uuid) }}">
                                        <img src="{{ Storage::disk('s3')->url($saved->item->image_path) }}"
                                             alt="{{ $saved->item->title }}"
                                             class="w-full h-48 object-cover">
                                        <div class="p-4">
                                            <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $saved->item->title }}</h3>
                                            <p class="text-sm text-gray-600">
                                                <i class="far fa-clock mr-1"></i>
                                                {{ $saved->item->cooking_time }}分
                                            </p>
                                            <p class="text-xs text-gray-500 mt-2">
                                                ブックマーク: {{ $saved->created_at->format('Y/m/d') }}
                                            </p>
                                        </div>
                                    </a>
                                    <div class="px-4 pb-4">
                                        <button class="remove-bookmark w-full py-2 text-sm text-red-600 hover:text-red-800 border border-red-300 rounded hover:bg-red-50 transition"
                                                data-item-type="recipe"
                                                data-item-uuid="{{ $saved->item->uuid }}">
                                            <i class="fas fa-trash mr-1"></i>
                                            ブックマークから削除
                                        </button>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-8 text-center text-gray-600">
                            <i class="fas fa-bookmark text-4xl mb-3 text-gray-400"></i>
                            <p>ブックマークしたレシピはまだありません</p>
                        </div>
                    @endif
                </div>

                <!-- 食材のブックマーク -->
                <div class="mb-12">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-2xl font-semibold text-yellow-900 flex items-center">
                            <i class="fas fa-carrot mr-2"></i>
                            食材（{{ $totalIngredients }}件）
                        </h2>
                        @if($totalIngredients > 5)
                        <a href="{{ route('bookmarks.ingredients') }}"
                           class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition">
                            続きを見る
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        @endif
                    </div>

                    @if($savedIngredients->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                            @foreach($savedIngredients as $saved)
                                @if($saved->item)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                                    <a href="{{ route('ingredients.show', $saved->item->uuid) }}">
                                        <img src="{{ Storage::disk('s3')->url($saved->item->image_path) }}"
                                             alt="{{ $saved->item->name }}"
                                             class="w-full h-40 object-cover">
                                        <div class="p-4">
                                            <h3 class="font-semibold text-base text-gray-800 mb-2">{{ $saved->item->name }}</h3>
                                            <p class="text-sm text-yellow-900 font-bold">
                                                {{ number_format($saved->item->price) }}円
                                            </p>
                                            <p class="text-xs text-gray-500 mt-2">
                                                ブックマーク: {{ $saved->created_at->format('Y/m/d') }}
                                            </p>
                                        </div>
                                    </a>
                                    <div class="px-4 pb-4">
                                        <button class="remove-bookmark w-full py-2 text-sm text-red-600 hover:text-red-800 border border-red-300 rounded hover:bg-red-50 transition"
                                                data-item-type="ingredient"
                                                data-item-uuid="{{ $saved->item->uuid }}">
                                            <i class="fas fa-trash mr-1"></i>
                                            削除
                                        </button>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-8 text-center text-gray-600">
                            <i class="fas fa-bookmark text-4xl mb-3 text-gray-400"></i>
                            <p>ブックマークした食材はまだありません</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('.remove-bookmark').click(function(e) {
        e.preventDefault();
        if (!confirm('ブックマークから削除しますか？')) {
            return;
        }

        const btn = $(this);
        const itemType = btn.data('item-type');
        const itemUuid = btn.data('item-uuid');

        $.ajax({
            url: '{{ route("bookmarks.destroy") }}',
            method: 'DELETE',
            data: {
                item_type: itemType,
                item_uuid: itemUuid,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                btn.closest('.bg-white').fadeOut(300, function() {
                    $(this).remove();
                    location.reload();
                });
            },
            error: function(xhr) {
                alert(xhr.responseJSON?.message || 'エラーが発生しました');
            }
        });
    });
});
</script>
@endpush
