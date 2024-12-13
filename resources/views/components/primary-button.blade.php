<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-2 py-2 bg-rose-500 border border-transparent rounded-md text-white uppercase tracking-widest hover:bg-rose-600 focus:bg-rose-600 active:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
