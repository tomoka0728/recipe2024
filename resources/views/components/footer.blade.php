<footer class="text-gray-600 body-font bg-original w-full">
  <div class="px-5 py-10 mx-auto flex md:items-center lg:items-start md:flex-row md:flex-nowrap flex-wrap flex-col">
    <div class="w-64 flex-shrink-0 md:mx-0 mx-auto text-center md:text-left">
      <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
    {{-- タイトル --}}
        <a href="/" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
            <img src="{{ Storage::disk('s3')->url('logo.png') }}" alt="Logo" width="40px">
            <span class="text-xl">RecipeMart</span>
        </a>
      </a>
    </div>
    <div class="flex-grow flex flex-wrap md:pl-20 -mb-10 md:mt-0 mt-10 mb-5 md:text-left text-center">
      <div class="lg:w-1/3 md:w-1/2 w-full px-4">
        <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm mb-3">RecipeMartについて</h2>
        <nav class="list-none mb-10">
          <li>
            <a class="text-gray-600 hover:text-gray-800">会社概要</a>
          </li>
          <li>
            <a class="text-gray-600 hover:text-gray-800">環境への取り組み</a>
          </li>
          <li>
            <a class="text-gray-600 hover:text-gray-800">採用情報</a>
          </li>
        </nav>
      </div>
      <div class="lg:w-1/3 md:w-1/2 w-full px-4">
        <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm mb-3">RecipeMartでのお支払い</h2>
        <nav class="list-none mb-10">
          <li>
            <a class="text-gray-600 hover:text-gray-800">RecipeMartポイント</a>
          </li>
          <li>
            <a class="text-gray-600 hover:text-gray-800">RecipeMartギフトカード</a>
          </li>
          <li>
            <a class="text-gray-600 hover:text-gray-800">ポイントプログラム</a>
          </li>
        </nav>
      </div>
      <div class="lg:w-1/3 md:w-1/2 w-full px-4">
        <h2 class="title-font font-medium text-gray-900 tracking-widest text-sm mb-3">ヘルプ＆ガイド</h2>
        <nav class="list-none mb-10">
          <li>
            <a class="text-gray-600 hover:text-gray-800">配送料と配送情報</a>
          </li>
          <li>
            <a class="text-gray-600 hover:text-gray-800">商品の返品・交換</a>
          </li>
          <li>
            <a class="text-gray-600 hover:text-gray-800">価格について</a>
          </li>
          <li>
            <a class="text-gray-600 hover:text-gray-800">お客様サポート</a>
          </li>
        </nav>
      </div>
    </div>
  </div>
  <div class="bg-original">
    <div class="container mx-auto py-4 px-5 flex flex-wrap flex-col items-center sm:flex-row">
      <p class="text-gray-500 text-sm text-center sm:text-left">© 2024 RecipeMart Co., Ltd.</p>

      <nav class="text-gray-500 text-sm text-center sm:mx-auto my-2">
        <ul class="inline-flex list-none items-center">
            <li>
                <a href="#" class="mr-1 rounded-md px-4 py-1 text-gray-500 ring-offset-2 ring-offset-current transition duration-500 ease-in-out">よくある質問</a>
                <span class="mx-1 border-l border-yellow-900/20 h-5"></span>
            </li>
            <li>
                <a href="#" class="mr-1 rounded-md px-4 py-1 text-gray-500 ring-offset-2 ring-offset-current transition duration-500 ease-in-out">利用規約</a>
                <span class="mx-1 border-l border-yellow-900/20 h-5"></span>
            </li>
            <li>
                <a href="#" class="mr-1 rounded-md px-4 py-1 text-gray-500 ring-offset-2 ring-offset-current transition duration-500 ease-in-out">プライバシー規約</a>
                <span class="mx-1 border-l border-yellow-900/20 h-5"></span>
            </li>
            <li>
                <a href="#" class="mr-1 rounded-md px-4 py-1 text-gray-500 ring-offset-2 ring-offset-current transition duration-500 ease-in-out">特定商品取引に関する法律に基づく表記</a>
            </li>
        </ul>
      </nav>

      <span class="inline-flex sm:mt-0 mt-2 justify-center sm:justify-start">
        <a class="text-gray-500">
          <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-500">
          <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-500">
          <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
            <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
            <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
          </svg>
        </a>
        <a class="ml-3 text-gray-500">
          <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
            <path stroke="none" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
            <circle cx="4" cy="4" r="2" stroke="none"></circle>
          </svg>
        </a>
      </span>
    </div>
  </div>
</footer>
