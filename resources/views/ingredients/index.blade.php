@extends('layouts.app')
@section('content')

<x-guest-layout>

    <div id="container" class="wrapper">
        <main>
            <article>
                <div class="item_title">
                    <h1>
                        @if(request('search'))
                            「{{ request('search') }}」の検索結果（全{{ $ingredients->total() }}件）
                        @else
                            すべての材料（全{{ $ingredients->total() }}件）
                        @endif
                    </h1>
                </div>
                <hr class="cp_hr11" />

                <div class="pagination-info mt-4 mb-4 flex flex-wrap justify-between items-center gap-4">
                    {{-- ページネーション情報 --}}
                    <div class="pagination-summary text-sm text-yellow-900">
                        <p>{{ $ingredients->firstItem() }} - {{ $ingredients->lastItem() }} 件表示（{{ $ingredients->currentPage() }}ページ目）</p>
                    </div>
                
                    {{-- 並び替えと表示件数 --}}
                    <div class="pagination-controls">
                        <form method="get" action="{{ route('ingredients.index') }}" class="flex items-center gap-4">
                            {{-- 並び替え --}}
                            <div class="flex items-center text-sm text-yellow-800">
                                <label for="sort" class="mr-2 font-semibold">並び替え:</label>
                                <select name="sort" id="sort" onchange="this.form.submit()"
                                    class="bg-original3 text-yellow-800 rounded-md border border-transparent py-2 px-3 pr-8 text-sm focus:ring focus:ring-original4 focus:ring-1 appearance-none bg-no-repeat bg-[right_0.75rem_center] bg-[url('data:image/svg+xml,%3Csvg fill=\'%237c5400\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath fill-rule=\'evenodd\' d=\'M10 14l-5-5h10l-5 5z\' clip-rule=\'evenodd\' /%3E%3C/svg%3E')]">
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>新着順</option>
                                    <option value="bestselling" {{ request('sort') == 'bestselling' ? 'selected' : '' }}>売れ筋順</option>
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
    
                <div class="all-products-grid">
                    @foreach($ingredients as $ingredient)
                    <div class="all-products-item">
                        <div class="all-products-item-img">
                            <a href="{{ route('ingredients.show', $ingredient->uuid) }}">
                                <img src="{{ Storage::disk('s3')->url($ingredient->image_path) }}" alt="{{ $ingredient->name }}">
                            </a>
                        </div>
                        <div class="all-products-title">
                            <h2>{{ $ingredient->name }}</h2>
                        </div>
                        <div class="all-products-info">
                            <h3 class="price">{{ number_format($ingredient->price) }}円</h3>
                            <p class="all-products-total-price">(税込み <span class="total-price-display">{{ number_format($ingredient->price * 1.08) }}円</span>)</p>
                        </div>
                        <div class="cart-push2" style="display: none;">
                            カートに追加しました
                        </div>
                        <div class="all-products-btn">
                        <a class="into-cart btn btn--pink btn--radius" data-ingredient-id="{{ $ingredient->uuid }}"data-quantity="1">カートに入れる</a></div>
                    </div>
                    @endforeach
                </div>

                {{-- ページネーション --}}
                <div class="pagination">
                    {{ $ingredients->appends(request()->input())->links() }}
                </div>
                
            </article>
        </main>

        <aside id="sidebar">
            <section class="ranking">
                <h3 class="side-title">ランキングカテゴリ</h3>
                <ul>
                    <li><p class="subject"><a href="{{ route('ranking.show', ['category' => 'sougou']) }}">総合ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 4) }}">野菜ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 5) }}">果物ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 1) }}">お肉ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 2) }}">魚介ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 3) }}">乳製品ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 9) }}">調味料ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 10) }}">飲料ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 6) }}">冷凍ランキング</a></p></li>
                    <li><p class="subject"><a href="{{ route('ranking.show', 11) }}">その他ランキング</a></p></li>
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
@endpush
