<header class="text-gray-600 body-font py-2">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-2 lg:gap-4">
            {{-- タイトル --}}
            <div class="flex justify-center lg:justify-start lg:flex-1">
                <a href="/" class="flex title-font font-medium items-center text-gray-900">
                    <img src="{{ Storage::disk('s3')->url('logo.png') }}" alt="Logo" width="40px">
                    <span class="text-xl ml-2">RecipeMart</span>
                </a>
            </div>

            {{-- 検索フォーム（中央） --}}
            <div class="flex justify-center lg:flex-1">
                <form id="header-search-form" method="GET"
                    action="{{ request('search_type') === 'recipe' ? route('recipes.index') : route('ingredients.index') }}"
                    class="flex flex-col sm:flex-row items-center justify-center gap-2 w-full md:w-auto">

                    {{-- ラジオボタン --}}
                    <fieldset class="radio-2 flex items-center gap-2">
                        <label class="flex items-center text-sm">
                            <input type="radio" name="search_type" value="recipe"
                                {{ !request()->has('search_type') || request('search_type') === 'recipe' ? 'checked' : '' }} />
                            レシピ
                        </label>
                        <label class="flex items-center text-sm">
                            <input type="radio" name="search_type" value="ingredient"
                                {{ request('search_type') === 'ingredient' ? 'checked' : '' }} />
                            食材
                        </label>
                    </fieldset>

                    <div class="relative w-full sm:w-auto">
                        <div class="absolute bottom-0 start-0 top-0 flex w-12 items-center justify-center">
                            <button type="submit" class="search-btn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="h-4 w-4 text-amber-900">
                                    <path fill-rule="evenodd"
                                        d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <input type="text"
                            class="block w-full sm:w-48 md:w-56 lg:w-64 border-transparent bg-original3 py-2 pe-4 ps-10 text-sm leading-5 text-yellow-800 placeholder:text-yellow-900/50 hover:border-transparent focus:border-transparent focus:ring focus:ring-original4 focus:ring-1"
                            id="search" name="search" value="{{ request('search') }}" placeholder="キーワードで検索" />
                    </div>
                </form>
            </div>

            {{-- ナビゲーション（右側） --}}
            <div class="flex justify-center lg:justify-end lg:flex-1">
                <div class="flex items-center gap-2 lg:gap-3">
                    <nav>
                        <ul class="flex items-center gap-2 lg:gap-3">
                            @auth
                                <li class="flex flex-col items-center">
                                    <a href="{{ route('mypage') }}"
                                        class="flex flex-col items-center py-1 px-1 lg:py-2 lg:px-2 text-gray-900 text-xs rounded hover:bg-gray-100">
                                        <img src="{{ Storage::disk('s3')->url('user.png') }}" width="24" class="mb-1">
                                        <span class="hidden md:block">マイページ</span>
                                    </a>
                                </li>
                                <li class="flex flex-col items-center">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex flex-col items-center py-1 px-1 lg:py-2 lg:px-2 text-gray-900 text-xs rounded hover:bg-gray-100">
                                            <img src="{{ Storage::disk('s3')->url('logout.png') }}" width="24" class="mb-1">
                                            <span class="hidden md:block">ログアウト</span>
                                        </button>
                                    </form>
                                </li>
                            @else
                                <li class="flex flex-col items-center">
                                    <a href="{{ route('login') }}"
                                        class="flex flex-col items-center py-1 px-1 lg:py-2 lg:px-2 text-gray-900 text-xs rounded hover:bg-gray-100">
                                        <img src="{{ Storage::disk('s3')->url('user.png') }}" width="24" class="mb-1">
                                        <span class="hidden md:block">ログイン</span>
                                    </a>
                                </li>
                                <li class="flex flex-col items-center">
                                    <a href="{{ route('register') }}"
                                        class="flex flex-col items-center py-1 px-1 lg:py-2 lg:px-2 text-gray-900 text-xs rounded hover:bg-gray-100">
                                        <img src="{{ Storage::disk('s3')->url('register.png') }}" width="24" class="mb-1">
                                        <span class="hidden md:block">会員登録</span>
                                    </a>
                                </li>
                            @endauth
                            <li class="flex flex-col items-center">
                                <a href="{{ route('contact.create') }}"
                                    class="flex flex-col items-center py-1 px-1 lg:py-2 lg:px-2 text-gray-900 text-xs rounded hover:bg-gray-100">
                                    <img src="{{ Storage::disk('s3')->url('support.png') }}" width="24" class="mb-1">
                                    <span class="hidden md:block">お問い合わせ</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                    {{-- カート --}}
                    <div class="flex flex-col items-center relative">
                        <a href="{{ route('cart.show') }}"
                            class="flex flex-col items-center py-1 px-1 lg:py-2 lg:px-2 text-gray-900 text-xs rounded hover:bg-gray-100">
                            <img src="{{ Storage::disk('s3')->url('cart.png') }}" width="24" class="mb-1">
                            @php
                                $cartCount = session('carts', []);
                            @endphp
                            <span id="cart-badge" class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full {{ count($cartCount) > 0 ? '' : 'hidden' }}">
                                <span id="cart-count">{{ count($cartCount) }}</span>
                            </span>
                            <span class="hidden md:block">カート</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<section class="w-full bg-original">
    <div class="flex justify-center">
        <div class="flex items-center p-2 md:p-3 w-full">
            <ul class="inline-flex list-none items-center w-full justify-center flex-wrap gap-2 md:gap-0">
                <li>
                    <a href="{{ route('ingredients.index', ['search_type' => 'ingredient']) }}"
                        class="rounded-md px-2 md:px-4 py-1 text-sm md:text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out whitespace-nowrap">食材</a>
                    <span class="mx-1 border-l border-yellow-900/20 h-5 hidden md:inline-block"></span>
                </li>
                <li>
                    <a href="{{ route('recipes.index', ['search_type' => 'recipe']) }}"
                        class="rounded-md px-2 md:px-4 py-1 text-sm md:text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out whitespace-nowrap">レシピ</a>
                    <span class="mx-1 border-l border-yellow-900/20 h-5 hidden md:inline-block"></span>
                </li>
                <li>
                    <a href="{{ route('column') }}"
                        class="rounded-md px-2 md:px-4 py-1 text-sm md:text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out whitespace-nowrap">読みもの</a>
                    <span class="mx-1 border-l border-yellow-900/20 h-5 hidden md:inline-block"></span>
                </li>
                <li>
                    <a href="{{ url('/special-feature') }}"
                        class="rounded-md px-2 md:px-4 py-1 text-sm md:text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out whitespace-nowrap">特集</a>
                    <span class="mx-1 border-l border-yellow-900/20 h-5 hidden md:inline-block"></span>
                </li>
                <li>
                    <a href="#"
                        class="rounded-md px-2 md:px-4 py-1 text-sm md:text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out whitespace-nowrap">ブックマーク</a>
                </li>
            </ul>
        </div>
    </div>
</section>

<script>
    window.appRoutes = {
        ingredientIndex: "{{ route('ingredients.index') }}",
        recipeIndex: "{{ route('recipes.index') }}"
    };
</script>

@vite(['resources/js/cart-badge.js'])
