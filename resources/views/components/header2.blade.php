<nav class="bg-white border-b border-gray-200 dark:bg-gray-900">
    <div class="flex justify-center items-center mx-auto p-6">
    {{-- タイトル --}}
    <a href="/" class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0">
        <img src="{{ Storage::disk('s3')->url('logo.png') }}" alt="Logo" width="50px">
        <span class="text-xl">RecipeApp</span>
    </a>
    </div>
</nav>
