<header class="text-gray-600 body-font pt-4">
    <div class="container mx-auto px-4 flex flex-wrap flex-col md:flex-row items-center">
    {{-- タイトル --}}
      <a href="/" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
        <img src="{{ Storage::disk('s3')->url('logo.png') }}" alt="Logo" width="40px">
        <span class="text-xl">RecipeApp</span>
      </a>

    {{-- 検索フォーム --}}
        <form onsubmit="return false;" class="flex md:ml-auto md:mr-auto items-center text-base justify-center">
            {{-- ラジオボタン --}}
            <fieldset class="radio-2 flex items-center">
                <label class="flex items-center">
                    <input type="radio" name="radio-2" checked/>
                    レシピ
                </label>
                <label class="flex items-center">
                    <input type="radio" name="radio-2"/>
                    食材
                </label>
            </fieldset>

            <div class="relative ml-4">
                <div class="absolute bottom-0 start-0 top-0 flex w-14 items-center justify-center">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20"
                        fill="currentColor"
                        class="h-5 w-5 text-amber-900"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                            clip-rule="evenodd"
                        />
                    </svg>
                </div>
                <input
                    type="text"
                    class="block w-96 sm:w-72 lg:w-96 border-transparent bg-original3 py-3 pe-5 ps-12 text-sm leading-5 text-yellow-800 placeholder:text-yellow-900/50 hover:border-transparent focus:border-transparent focus:ring focus:ring-original4  focus:ring-1"
                    id="search"
                    name="search"
                    placeholder="キーワードで検索"
                />
            </div>
        </form>
        <!-- 検索ここまで -->
      <nav>
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white  items-end justify-center">
            @auth
            <li class="flex flex-col items-center">
                <a href="{{ route('mypage') }}" class="flex flex-col items-center block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0 ">
                    <img src="{{ Storage::disk('s3')->url('user.png') }}" width="30px" class="mb-1">
                    マイページ
                </a>
            </li>
            <li class="flex flex-col items-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex flex-col items-center block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0">
                        <img src="{{ Storage::disk('s3')->url('logout.png') }}" width="30px" class="mb-1">
                        ログアウト
                    </button>
                </form>
            </li>
            @else
            <li class="flex flex-col items-center">
                <a href="{{ route('login') }}" class="flex flex-col items-center block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0 ">
                    <img src="{{ Storage::disk('s3')->url('user.png') }}" width="30px" class="mb-1">
                    ログイン
                </a>
            </li>
            <li class="flex flex-col items-center">
                <a href="{{ route('register') }}" class="flex flex-col items-center block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0 ">
                    <img src="{{ Storage::disk('s3')->url('register.png') }}" width="30px" class="mb-1">
                    会員登録
                </a>
            </li>
            @endauth
            <li class="flex flex-col items-center">
                <a href="#" class="flex flex-col items-center block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0 ">
                    <img src="{{ Storage::disk('s3')->url('support.png') }}" width="30px" class="mb-1">
                    ご利用ガイド
                </a>
            </li>

        </ul>
      </nav>
      <ul class="flex flex-col p-4 md:p-0 mt-4  font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
        <li class="flex flex-col items-center ml-8">
            <a href="{{ route('cart.show') }}" class="flex flex-col items-center block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0" >
                <img src="{{ Storage::disk('s3')->url('cart.png') }}" width="30px" class="mb-1">
                @php
                $cartCount = session('cart', []);
            @endphp
            @if($cartCount && count($cartCount) > 0)  {{-- カート内にアイテムがあれば表示 --}}
                <span class="absolute top-6 right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                    {{ count($cartCount) }} {{-- カートのアイテム数 --}}
                </span>
            @endif
                カート
            </a>
        </li>
    </ul>
    </div>
</header>

  <section  class="w-full bg-original">
    <div class="flex justify-center">
        <div class="flex items-center p-5 w-full">
            <ul class="inline-flex list-none items-center w-full justify-center">
                <li>
                    <a href="#" class="mr-1 rounded-md px-4 py-1 text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out">食材</a>
                    <span class="mx-1 border-l border-yellow-900/20 h-5"></span>
                </li>
                <li>
                    <a href="#" class="mr-1 rounded-md px-4 py-1 text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out">レシピ</a>
                    <span class="mx-1 border-l border-yellow-900/20 h-5"></span>
                </li>
                <li>
                    <a href="#" class="mr-1 rounded-md px-4 py-1 text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out">読みもの</a>
                    <span class="mx-1 border-l border-yellow-900/20 h-5"></span>
                </li>
                <li>
                    <a href="#" class="mr-1 rounded-md px-4 py-1 text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out">特集</a>
                    <span class="mx-1 border-l border-yellow-900/20 h-5"></span>
                </li>
                <li>
                    <a href="#" class="mr-1 rounded-md px-4 py-1 text-base text-rose-950 ring-offset-2 ring-offset-current transition duration-500 ease-in-out">ブックマーク</a>
                </li>
            </ul>
        </div>
    </div>
</section>
