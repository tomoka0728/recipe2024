@extends('layouts.app')
@section('content')
{{ Breadcrumbs::render('recipes.index') }}
<x-guest-layout>

    <div id="container" class="wrapper">
        <main>
            <article>
                <div class="item_title">
                    <h1>
                        @if(request('search'))
                            「{{ request('search') }}」の検索結果（全{{ count($recipes) }}件）
                        @elseif(isset($selectedCategory))
                            「{{ $selectedCategory->name }}」のレシピ（全{{ count($recipes) }}件）
                        @else
                            すべてのレシピ（全{{ count($recipes) }}件）
                        @endif
                    </h1>
                </div>
                <hr class="cp_hr11" />

                <div class="pagination-info mt-4 mb-4 flex flex-wrap justify-between items-center gap-4">
                    {{-- ページネーション情報 --}}
                    <div class="pagination-summary text-sm text-yellow-900">
                        @if($recipes->count() > 0)
                            <p>{{ $recipes->firstItem() }} - {{ $recipes->lastItem() }} 件表示（{{ $recipes->currentPage() }}ページ目）</p>
                        @else
                            <p>0件</p>
                        @endif
                    </div>

                    {{-- 並び替えと表示件数 --}}
                    <div class="pagination-controls">
                        <form method="get"
                            action="{{ isset($selectedCategory) ? route('recipes.category', ['category' => $selectedCategory->uuid]) : route('recipes.index') }}"
                            class="flex items-center gap-4">
                            {{-- 並び替え --}}
                            <div class="flex items-center text-sm text-yellow-800">
                                <label for="sort" class="mr-2 font-semibold">並び替え:</label>
                                <select name="sort" id="sort" onchange="this.form.submit()"
                                    class="bg-original3 text-yellow-800 rounded-md border border-transparent py-2 px-3 pr-8 text-sm focus:ring focus:ring-original4 focus:ring-1 appearance-none bg-no-repeat bg-[right_0.75rem_center] bg-[url('data:image/svg+xml,%3Csvg fill=\'%237c5400\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath fill-rule=\'evenodd\' d=\'M10 14l-5-5h10l-5 5z\' clip-rule=\'evenodd\' /%3E%3C/svg%3E')]">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>新着順</option>
                                    @if (Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value)
                                        <option value="favorites" {{ request('sort') == 'favorites' ? 'selected' : '' }}>お気に入りが多い順</option>
                                    @endif
                                </select>
                            </div>

                            {{-- 表示件数 --}}
                            <div class="flex items-center text-sm text-yellow-800">
                                <label for="per_page" class="mr-2 font-semibold">表示件数:</label>
                                <select name="per_page" id="per_page" onchange="this.form.submit()"
                                    class="bg-original3 text-yellow-800 rounded-md border border-transparent py-2 px-3 pr-8 text-sm focus:ring focus:ring-original4 focus:ring-1 appearance-none bg-no-repeat bg-[right_0.75rem_center] bg-[url('data:image/svg+xml,%3Csvg fill=\'%237c5400\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath fill-rule=\'evenodd\' d=\'M10 14l-5-5h10l-5 5z\' clip-rule=\'evenodd\' /%3E%3C/svg%3E')]">
                                    <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20件表示</option>
                                    <option value="40" {{ request('per_page') == '40' ? 'selected' : '' }}>40件表示</option>
                                    <option value="60" {{ request('per_page') == '60' ? 'selected' : '' }}>60件表示</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                @if($recipes->count() > 0)
                <div class="recipe-list">
                    @foreach($recipes as $recipe)
                        <div class="recipe-item">
                            <a href="{{ route('recipes.show', $recipe->uuid) }}" class="recipe-img-container">
                                <div class="recipe-img-container">
                                    <img src="{{ Storage::disk('s3')->url($recipe->image_path) }}" alt="{{ $recipe->title }}">
                                    <div class="overlay">
                                        <h3>{{ $recipe->title }}</h3>
                                    </div>
                                    <div class="favorite-badge {{ in_array($recipe->uuid, $bookmarkedRecipeIds) ? 'bookmarked' : '' }}">
                                        <i class="fas fa-bookmark"></i>
                                        <span>{{ $recipe->bookmarksCount() }}</span>
                                    </div>
                                </div>
                                <div class="recipe-details">
                                    <h2>{{ $recipe->title }}</h2>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                @else
                    <p>このカテゴリにはまだレシピがありません。</p>
                @endif
                {{-- ページネーション --}}
                @if($recipes->count() > 0)
                    <div class="pagination">
                        {{ $recipes->appends(request()->input())->links() }}
                    </div>
                @endif
            </article>
        </main>

        <aside id="sidebar">
            <section class="ranking">
                <h3 class="side-title">カテゴリ</h3>
                <ul>
                    @foreach($recipeCategories as $category)
                        <li>
                            <p class="subject">
                                <a href="{{ route('recipes.category', ['category' => $category->uuid]) }}">
                                    {{ $category->name }}
                                </a>
                            </p>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="cm">
                <a href="{{ url('/form') }}"><img src="{{ Storage::disk('s3')->url('toiawase.png') }}" alt=""></a>
            </section>

            @if (!(Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value))
                <section class="cm">
                    <a href="#"><img src="{{ Storage::disk('s3')->url('cm.png') }}" alt=""></a>
                </section>

                <section class="cm">
                <a href="#"><img src="{{ Storage::disk('s3')->url('cm2.png') }}" alt=""></a>
                </section>
            @endif
        </aside>
    </div>
</x-guest-layout>
@endsection

@push('styles')
    @vite(['resources/css/item.css'])
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>

    @vite('resources/js/app.js')

    <!-- slick carouselのスタイルとスクリプト -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css" />
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <style>
    .favorite-badge.bookmarked {
        background-color: #ef4444 !important;
        color: white !important;
    }
    .favorite-badge.bookmarked .heart-icon {
        color: white !important;
    }
    </style>
@endpush
