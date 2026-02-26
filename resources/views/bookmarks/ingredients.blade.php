@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('bookmarks.index') }}
<x-guest-layout>
    <div class="min-h-screen">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold text-center text-yellow-900 mb-8">食材のブックマーク</h1>

            <div class="mx-auto">
                <!-- ナビゲーションボタン -->
                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('mypage') }}"
                       class="inline-flex items-center text-gray-600 hover:text-gray-800 font-medium">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        マイページに戻る
                    </a>
                    <a href="{{ route('bookmarks.recipes') }}"
                       class="inline-flex items-center text-yellow-700 hover:text-yellow-900 font-medium">
                        <i class="fas fa-utensils mr-2"></i>
                        レシピのブックマーク
                    </a>
                </div>

                <!-- 件数表示 -->
                <div class="mb-6">
                    <p class="text-gray-600 text-lg">
                        <i class="fas fa-carrot mr-2"></i>
                        全 <span class="font-bold text-yellow-900">{{ $savedIngredients->total() }}</span> 件
                    </p>
                </div>

                <!-- 食材のブックマーク -->
                @if($savedIngredients->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6 mb-8">
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

                    <!-- ページネーション -->
                    <div class="mt-8">
                        {{ $savedIngredients->links() }}
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-8 text-center text-gray-600">
                        <i class="fas fa-bookmark text-4xl mb-3 text-gray-400"></i>
                        <p>ブックマークした食材はまだありません</p>
                        <a href="{{ route('ingredients.index') }}" class="mt-4 inline-block text-yellow-700 hover:text-yellow-900 font-medium">
                            食材を探す
                        </a>
                    </div>
                @endif
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
                    // ページをリロードして件数を更新
                    setTimeout(function() {
                        location.reload();
                    }, 300);
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
