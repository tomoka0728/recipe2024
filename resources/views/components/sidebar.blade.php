{{-- sidebar.blade.php --}}
@php
    $currentRoute = Route::currentRouteName();
@endphp

<div class="w-48 bg-gray-800 text-gray-200 h-screen">
    <nav class="mt-4 space-y-4">
        {{-- ダッシュボード --}}
        <a href="{{ route('admin.dashboard') }}"
            class="flex flex-col items-center px-4 py-2 hover:bg-blue-600 hover:text-white {{ str_starts_with($currentRoute, 'admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-200' }}">
            <i class="fas fa-tachometer-alt text-2xl mb-2"></i>
            <span>ダッシュボード</span>
        </a>
        {{-- レシピ管理 --}}
        <a href="{{ route('admin.recipes.index') }}"
            class="flex flex-col items-center px-4 py-2 hover:bg-blue-600 hover:text-white {{ str_starts_with($currentRoute, 'admin.recipes') ? 'bg-blue-600 text-white' : 'text-gray-200' }}">
            <i class="fas fa-folder text-2xl mb-2"></i>
            <span>レシピ管理</span>
        </a>
        {{-- 商品管理 --}}
        <a href="{{ route('admin.ingredients.index') }}"
            class="flex flex-col items-center px-4 py-2 hover:bg-blue-600 hover:text-white {{ str_starts_with($currentRoute, 'admin.ingredients') ? 'bg-blue-600 text-white' : 'text-gray-200' }}">
            <i class="fas fa-shopping-cart text-2xl mb-2"></i>
            <span>商品管理</span>
        </a>
        {{-- お問い合わせ履歴 --}}
        @php
            $pendingCount = \App\Models\Contact::where('status', 'pending')->count();
        @endphp
        <a href="{{ route('admin.contacts.index') }}"
            class="flex flex-col items-center px-4 py-2 hover:bg-blue-600 hover:text-white relative {{ str_starts_with($currentRoute, 'admin.contacts') ? 'bg-blue-600 text-white' : 'text-gray-200' }}">
            <i class="fas fa-comments text-2xl mb-2"></i>
            <span>お問い合わせ</span>
            @if($pendingCount > 0)
                <span class="absolute top-1 right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">{{ $pendingCount }}</span>
            @endif
        </a>
        {{-- 売上 --}}
        <a href="#"
            class="flex flex-col items-center px-4 py-2 hover:bg-blue-600 hover:text-white {{ str_starts_with($currentRoute, 'admin.reports') ? 'bg-blue-600 text-white' : 'text-gray-200' }}">
            <i class="fas fa-chart-bar text-2xl mb-2"></i>
            <span>売上</span>
        </a>
    </nav>
</div>
