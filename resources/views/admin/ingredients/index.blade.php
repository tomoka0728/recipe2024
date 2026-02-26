@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">商品管理</h2>
        <div class="flex gap-2">
            <button id="bulk-sale-btn" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">
                <i class="fas fa-tag mr-2"></i> 選択した商品をセールにする
            </button>
            <a href="{{ route('admin.ingredients.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white hover:text-white font-semibold py-2 px-4 rounded">
            <i class="fas fa-plus mr-2"></i> 商品を登録
            </a>
        </div>
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

        <select name="seasonality" class="border rounded px-3 py-2">
            <option value="">旬で絞り込み</option>
            <option value="current" {{ request('seasonality') == 'current' ? 'selected' : '' }}>今が旬</option>
            <option value="out_of_season" {{ request('seasonality') == 'out_of_season' ? 'selected' : '' }}>旬が過ぎた</option>
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('seasonality') == $i ? 'selected' : '' }}>{{ $i }}月が旬</option>
            @endfor
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
                <th class="py-3 px-6">
                    <input type="checkbox" id="select-all" class="rounded">
                </th>
                <th class="py-3 px-6">商品名</th>
                <th class="py-3 px-6">価格</th>
                <th class="py-3 px-6">カテゴリ</th>
                <th class="py-3 px-6">セール</th>
                <th class="py-3 px-6 text-center">　</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @forelse ($ingredients as $ingredient)
                <tr class="border-b border-gray-200 hover:bg-gray-50">
                    <td class="py-3 px-6">
                        <input type="checkbox" class="ingredient-checkbox rounded" value="{{ $ingredient->uuid }}">
                    </td>
                    <td class="py-3 px-6">{{ $ingredient->name }}</td>
                    <td class="py-3 px-6">
                        @php
                            $currentSale = $ingredient->sale;
                        @endphp
                        @if($currentSale)
                            <div>
                                <span class="line-through text-gray-400">{{ number_format($ingredient->price) }}円</span>
                                <span class="text-red-600 font-bold ml-2">{{ number_format($ingredient->sale_price) }}円</span>
                            </div>
                        @else
                            {{ number_format($ingredient->price) }} 円
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        @if($ingredient->categories->isNotEmpty())
                            {{ $ingredient->categories->pluck('name')->implode(', ') }}
                        @else
                            未設定
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        @php
                            $currentSale = $ingredient->sale;
                        @endphp
                        @if($currentSale)
                            <div class="flex flex-col gap-1">
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">
                                    {{ $currentSale->discount_percent }}% OFF
                                </span>
                                @php
                                    $endDate = \Carbon\Carbon::parse($currentSale->end_at);
                                    $daysRemaining = now()->diffInDays($endDate, false);
                                @endphp
                                @if($daysRemaining >= 0)
                                    <span class="text-xs text-gray-600">
                                        残り{{ ceil($daysRemaining) }}日
                                    </span>
                                @else
                                    <span class="text-xs text-red-600">
                                        期限切れ
                                    </span>
                                @endif
                            </div>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-right">
                        <div class="flex justify-end space-x-4">
                            @php
                                $currentSale = $ingredient->sale;
                            @endphp
                            @if($currentSale)
                                {{-- セール解除 --}}
                                <form action="{{ route('admin.ingredients.removeSale', $ingredient->uuid) }}"
                                      method="POST" onsubmit="return confirm('セールを解除してもよろしいですか？');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        style="color: #f97316; background: transparent; border: none; cursor: pointer;"
                                        class="hover:underline focus:outline-none"
                                        onmouseover="this.style.textDecoration='underline'"
                                        onmouseout="this.style.textDecoration='none'">
                                        <i class="fas fa-times-circle mr-1"></i> セール解除
                                    </button>
                                </form>
                            @endif

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
                    <td colspan="6" class="text-center py-4 text-gray-500">該当する商品がありません。</td>
                </tr>
            @endforelse
        </tbody>
    </table>


    <div class="mt-4">
        {{ $ingredients->appends(request()->query())->links() }}
    </div>
</div>

{{-- セール設定モーダル --}}
<div id="sale-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">選択した商品をセールにする</h3>
            <form id="bulk-sale-form" method="POST" action="{{ route('admin.ingredients.bulkSale') }}">
                @csrf
                <div id="selected-ingredients" class="hidden"></div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">セール割引率（%）</label>
                    <input type="number" name="discount_percent" min="1" max="100" required
                        class="w-full border rounded px-3 py-2" placeholder="例: 20">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">セール開始日時</label>
                    <input type="datetime-local" name="start_at" required
                        class="w-full border rounded px-3 py-2">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">セール終了日時</label>
                    <input type="datetime-local" name="end_at" required
                        class="w-full border rounded px-3 py-2">
                </div>

                <div class="flex gap-2 justify-end">
                    <button type="button" id="close-modal"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        キャンセル
                    </button>
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        セールを設定
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.ingredient-checkbox');
    const bulkSaleBtn = document.getElementById('bulk-sale-btn');
    const modal = document.getElementById('sale-modal');
    const closeModal = document.getElementById('close-modal');
    const form = document.getElementById('bulk-sale-form');
    const selectedIngredientsContainer = document.getElementById('selected-ingredients');

    // 全選択/全解除
    selectAll.addEventListener('change', function() {
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // 一括セールボタン
    bulkSaleBtn.addEventListener('click', function() {
        const selected = Array.from(checkboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        if (selected.length === 0) {
            alert('商品を選択してください');
            return;
        }

        // 選択された商品のUUIDを hidden input として追加
        selectedIngredientsContainer.innerHTML = '';
        selected.forEach(uuid => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ingredient_uuids[]';
            input.value = uuid;
            selectedIngredientsContainer.appendChild(input);
        });

        modal.classList.remove('hidden');
    });

    // モーダルを閉じる
    closeModal.addEventListener('click', function() {
        modal.classList.add('hidden');
    });

    // モーダル外クリックで閉じる
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection
