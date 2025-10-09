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
                            @if($contact->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($contact->status === 'replied') bg-green-100 text-green-800
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
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">お問い合わせ内容</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $contact->message }}</p>
                    </div>
                </div>

                <!-- 管理者からの返信 -->
                @if($contact->admin_reply)
                    <div class="px-6 py-4 border-t">
                        <h2 class="text-lg font-semibold text-gray-900 mb-3">管理者からの返信</h2>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-line">{{ $contact->admin_reply }}</p>
                        </div>
                        <div class="mt-3 text-sm text-gray-600">
                            <p>返信日: {{ $contact->admin_replied_at->format('Y年m月d日 H:i') }}</p>
                            @if($contact->adminRepliedBy)
                                <p>返信者: {{ $contact->adminRepliedBy->name }}</p>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="px-6 py-4 border-t bg-yellow-50">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-yellow-800">管理者からの返信をお待ちください。返信まで2〜3営業日程度お時間をいただく場合がございます。</p>
                        </div>
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
