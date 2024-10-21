<header class="text-gray-600 body-font">
    <div class="container mx-auto px-4 flex flex-wrap flex-col md:flex-row items-center">
    {{-- タイトル --}}
      <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-10 h-10 text-white p-2 bg-indigo-500 rounded-full" viewBox="0 0 24 24">
          <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
        </svg>
        <span class="ml-3 text-xl">Tailblocks</span>
      </a>

    {{-- 検索フォーム --}}
        <form onsubmit="return false;" class="w-40 sm:w-72 lg:w-96 mt-4 flex md:ml-auto md:mr-auto items-center text-base justify-center">
            {{-- ラジオボタン --}}
            <fieldset class="radio-2 flex items-center">
                <label class="flex items-center">
                    <input type="radio" name="radio-2" checked/>
                    radio1
                </label>
                <label class="flex items-center">
                    <input type="radio" name="radio-2"/>
                    radio2
                </label>
                <label class="flex items-center">
                    <input type="radio" name="radio-2"/>
                    radio3
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
                    class="block w-96 sm:w-72 lg:w-96 rounded-full border-transparent bg-original3 py-3 pe-5 ps-12 text-sm leading-5 text-yellow-800 placeholder:text-yellow-900/50 hover:border-transparent focus:border-transparent focus:ring focus:ring-original4  focus:ring-1"
                    id="search"
                    name="search"
                    placeholder="レシピ名・食材で検索"
                />
            </div>
        </form>
        <!-- 検索ここまで -->
      <nav>
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
            <li class="flex flex-col items-center">
                <img src="{{ Vite::asset('resources/img/user.png') }}" width="20px" class="mb-3">
                <a href="#" class="block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0 ">マイページ</a>
            </li>
            <li class="flex flex-col items-center">
                <img src="{{ Vite::asset('resources/img/logout.png') }}" width="20px" class="mb-3">
                <a href="#" class="block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0 ">ログアウト</a>
            </li>
            <li class="flex flex-col items-center">
                <img src="{{ Vite::asset('resources/img/support.png') }}" width="20px" class="mb-3">
                <a href="#" class="block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0">ご利用ガイド</a>
            </li>

        </ul>
      </nav>
      <ul class="flex flex-col p-4 md:p-0 mt-4  font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
        <li class="flex flex-col items-center ml-8">
            <img src="{{ Vite::asset('resources/img/cart.png') }}" width="20px" class="mb-3">
            <span class="absolute top-6 right-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">3</span>
            <a href="#" class="block py-2 px-3 text-gray-900 text-xs rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-300 md:p-0">カート</a>
        </li>
    </ul>
    </div>
</header>

  <section>
    <div class="flex justify-center bg-original">
        <div class="flex items-center p-5">
            <ul class="inline-flex list-none items-center">
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
