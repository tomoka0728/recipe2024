@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('contact.show', $contact) }}
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto">
            <div class="mb-6">
                <a href="{{ route('contact.history') }}"
                   class="inline-flex items-center text-gray-600 hover:text-gray-800 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    お問い合わせ履歴に戻る
                </a>
            </div>

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <!-- ヘッダー -->
                <div class="bg-gray-50 px-6 py-4 border-b">
                    <div class="flex justify-between items-center">
                        <h1 class="text-xl font-bold text-gray-900">{{ $contact->subject }}</h1>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($contact->status->value === 'pending') bg-red-100 text-red-800
                            @elseif($contact->status->value === 'in_progress' || $contact->status->value === 'replied') bg-blue-100 text-blue-800
                            @elseif($contact->status->value === 'closed') bg-green-100 text-green-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $contact->status_label }}
                        </span>
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        <p>送信日: {{ $contact->created_at->format('Y年m月d日 H:i') }}</p>
                        <p>送信者: {{ $contact->name }} ({{ $contact->email }})</p>
                    </div>
                </div>

                <!-- お問い合わせ内容 -->
                <div class="px-6 py-4">
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="text-xs text-gray-500 mb-2">{{ $contact->created_at->format('Y年m月d日 H:i') }}</div>
                        <p class="text-gray-700 whitespace-pre-line">{{ $contact->message }}</p>
                    </div>
                </div>

                <!-- メッセージ -->
                @if($contact->messages && $contact->messages->count() > 0)
                    <div class="px-6 py-4 space-y-3">
                        @foreach($contact->messages as $message)
                            <div class="{{ $message->sender_type === 'admin' ? 'bg-blue-50' : 'bg-white border border-gray-200' }} rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm {{ $message->sender_type === 'admin' ? 'text-blue-600' : 'text-gray-700' }} font-medium">
                                        {{ $message->sender_name }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $message->created_at->format('Y/m/d H:i') }}</span>
                                </div>
                                <p class="text-gray-700 whitespace-pre-line text-sm">{{ $message->message }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- 返信フォーム -->
                @if($contact->status->value !== 'closed' && $contact->messages && $contact->messages->count() > 0)
                    <div class="px-6 py-4 border-t">
                        @if(session('success'))
                            <div class="bg-green-50 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('contact.sendReply', $contact->uuid) }}">
                            @csrf
                            <div class="mb-3">
                                <textarea name="message" rows="4"
                                          class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 text-sm"
                                          placeholder="返信する...">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 px-5 rounded-lg transition">
                                    送信
                                </button>
                            </div>
                        </form>
                    </div>
                @elseif($contact->status->value !== 'closed')
                    <div class="px-6 py-4 border-t bg-blue-50">
                        <p class="text-blue-700 text-sm">管理者からの返信をお待ちください。</p>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    @vite(['resources/css/app.css'])
@endpush
