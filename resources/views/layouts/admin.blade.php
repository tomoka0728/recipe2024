<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-screen">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>管理者ページ - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Css -->
    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    @stack('scripts')
</head>

<body class="font-sans text-gray-900 antialiased h-screen">
    {{-- ヘッダー --}}
    @unless (Route::is('admin.login'))
        <x-admin-header class="fixed-header" />
    @endunless

    {{-- サイドバーとメイン --}}
    <div class="flex h-full">
        @unless (Route::is('admin.login'))
            <x-sidebar class="fixed-sidebar" />
        @endunless

        <main class="flex-1 p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>
</body>

</html>
