@extends('layouts.admin-login')

@section('content')
<div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-10 mb-10">
    <p class="text-3xl font-bold text-gray-800">管理者ログイン</p>
    <p class="text-sm text-gray-500 mt-2">管理者専用ページにアクセスするにはログインしてください。</p>
</div>

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<!-- ログインフォーム -->
<form method="POST" action="{{ route('admin.login') }}" novalidate class="w-full max-w-md mx-auto mb-10">
    @csrf
    <!-- Admin ID -->
    <div class="mb-6">
        <label for="admin_id" class="block text-sm font-medium text-gray-700">管理者ID</label>
        <input id="admin_id" name="admin_id" type="text"
            class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $errors->has('admin_id') ? 'border-red-500 bg-red-100' : '' }}"
            value="{{ old('admin_id') }}" required autofocus autocomplete="admin_id">
        @if ($errors->has('admin_id'))
            <p class="text-sm text-red-500 mt-2">{{ $errors->first('admin_id') }}</p>
        @endif
    </div>

    <!-- Password -->
    <div class="mb-6">
        <label for="password" class="block text-sm font-medium text-gray-700">パスワード</label>
        <input id="password" name="password" type="password"
            class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-sm {{ $errors->has('password') ? 'border-red-500 bg-red-100' : '' }}"
            required autocomplete="current-password">
        @if ($errors->has('password'))
            <p class="text-sm text-red-500 mt-2">{{ $errors->first('password') }}</p>
        @endif
    </div>

    <!-- Submit Button -->
    <div class="text-right">
        <button type="submit"
            class="bg-blue-500 text-white py-2 px-4 rounded-lg shadow hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            ログイン
        </button>
    </div>
</form>
@endsection
