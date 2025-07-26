<header class="text-white body-font pt-2 pb-2 bg-gray-700 border-b border-gray-600">
    <div class="flex items-center justify-between w-full px-4">
        {{-- タイトル（ロゴ＋アプリ名） --}}
        <a href="{{ route('admin.dashboard') }}"
            class="flex title-font font-medium items-center text-white hover:text-gray-300 mb-4 md:mb-0">
            <span class="text-xl">Admin RecipeMart</span>
        </a>

        {{-- 管理者名とログアウト --}}
        <div class="flex items-center space-x-4">
            <span class="text-white">{{ Auth::user()->admin_id }} さん</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    ログアウト
                </button>
            </form>
        </div>
    </div>
</header>
