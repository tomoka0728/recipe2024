@extends('layouts.app')

@section('content')
{{ Breadcrumbs::render('contact.history') }}
<div class="min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-yellow-900 mb-8">お問い合わせ履歴</h1>

        <div class="max-w-4xl mx-auto">
            <!-- ナビゲーションボタン -->
            <div class="flex justify-start items-center mb-6">
                <a href="{{ route('mypage') }}"
                   class="inline-flex items-center text-gray-600 hover:text-gray-800 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    マイページに戻る
                </a>
            </div>

            @if($contacts->count() > 0)
                <div class="space-y-4">
                    @foreach($contacts as $contact)
                        <div class="contact-detail bg-white rounded-lg p-6">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $contact->subject }}</h3>
                                    <div class="text-sm text-gray-600 space-y-1">
                                        <p>送信日: {{ $contact->created_at->format('Y年m月d日 H:i') }}</p>
                                        @if($contact->admin_replied_at)
                                            <p>返信日: {{ $contact->admin_replied_at->format('Y年m月d日 H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                        @if($contact->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($contact->status === 'replied') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $contact->status_label }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="text-gray-700 line-clamp-3">{{ Str::limit($contact->message, 150) }}</p>
                            </div>

                            @if($contact->admin_reply)
                                <div class="border-t pt-4 mt-4">
                                    <h4 class="font-semibold text-gray-900 mb-2">管理者からの返信</h4>
                                    <p class="text-gray-700 line-clamp-3">{{ Str::limit($contact->admin_reply, 150) }}</p>
                                </div>
                            @endif

                            <div class="flex justify-end mt-4">
                                <a href="{{ route('contact.show', $contact) }}"
                                   class="contact-detail-button inline-flex items-center px-4 py-2 rounded-md shadow-sm text-sm font-medium text-white transition duration-300">
                                    詳細を見る
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $contacts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-500 mb-4">
                        <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">お問い合わせ履歴がありません</h3>
                    <p class="text-gray-500 mb-6">まだお問い合わせをされていません。</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
    @vite(['resources/css/app.css', 'resources/css/contact-form.css'])
@endpush
