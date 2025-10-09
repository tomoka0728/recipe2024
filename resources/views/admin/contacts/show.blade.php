@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- ヘッダー部分 -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">{{ $contact->subject }}</h2>
            <p class="text-gray-600 mt-1">{{ $contact->created_at->format('Y年m月d日 H:i') }} 受付</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- ステータス表示 -->
            @if($contact->status === 'pending')
                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">未対応</span>
            @elseif($contact->status === 'replied')
                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">対応済み</span>
            @else
                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">{{ $contact->status->label() }}</span>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- 操作ボタン -->
    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6">
        <div class="flex flex-wrap gap-3">
            @if($contact->status !== 'replied')
                <a href="{{ route('admin.contacts.reply', $contact->uuid) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg flex items-center">
                    <i class="fas fa-reply mr-2"></i> 返答する
                </a>
            @else
                <a href="{{ route('admin.contacts.reply', $contact->uuid) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg flex items-center">
                    <i class="fas fa-plus mr-2"></i> 追加返答する
                </a>
            @endif

            <button onclick="window.print()"
                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-print mr-2"></i> 印刷
            </button>

            <a href="mailto:{{ $contact->email }}?subject=Re: {{ urlencode($contact->subject) }}"
               class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg flex items-center">
                <i class="fas fa-envelope mr-2"></i> 直接メール
            </a>

            <form method="POST" action="{{ route('admin.contacts.destroy', $contact->uuid) }}"
                  onsubmit="return confirm('本当にこのお問い合わせを削除しますか？')" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg flex items-center">
                    <i class="fas fa-trash mr-2"></i> 削除
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <!-- お問い合わせ基本情報 -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">お問い合わせ基本情報</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">件名</label>
                        <p class="text-gray-800 font-medium">{{ $contact->subject }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">お問い合わせ種別</label>
                        <p class="text-gray-800">{{ $contact->type->label() }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">受付日時</label>
                        <p class="text-gray-800">{{ $contact->created_at->format('Y年m月d日 H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">最終更新</label>
                        <p class="text-gray-800">{{ $contact->updated_at->format('Y年m月d日 H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- お問い合わせ内容 -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">お問い合わせ内容</h3>
                <div class="bg-gray-50 p-4 rounded border-l-4 border-blue-500">
                    <div class="whitespace-pre-line text-gray-700 leading-relaxed">{{ $contact->message }}</div>
                </div>
            </div>

            <!-- 管理者返答 -->
            @if($contact->admin_reply)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">管理者返答</h3>
                    <div class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">返答日時</label>
                                <p class="text-gray-800">{{ $contact->admin_replied_at?->format('Y年m月d日 H:i') }}</p>
                            </div>
                            @if($contact->adminRepliedBy)
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">返答者</label>
                                    <p class="text-gray-800">{{ $contact->adminRepliedBy->name }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="bg-green-50 p-4 rounded border-l-4 border-green-500">
                        <div class="whitespace-pre-line text-gray-700 leading-relaxed">{{ $contact->admin_reply }}</div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                    <div class="text-yellow-600 mb-3">
                        <i class="fas fa-clock text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-yellow-800 mb-2">返答待ち</h3>
                    <p class="text-yellow-700 mb-4">このお問い合わせにはまだ返答されていません。</p>
                    <a href="{{ route('admin.contacts.reply', $contact->uuid) }}"
                       class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg inline-flex items-center">
                        <i class="fas fa-reply mr-2"></i> 今すぐ返答する
                    </a>
                </div>
            @endif
        </div>

        <div class="lg:col-span-1">
            <!-- 送信者情報 -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">送信者情報</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">氏名</label>
                        <p class="text-gray-800 font-medium">{{ $contact->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">メールアドレス</label>
                        <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:underline">{{ $contact->email }}</a>
                    </div>

                    @if($contact->user)
                        <div class="bg-blue-50 p-3 rounded border-l-4 border-blue-500">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-star text-blue-600 mr-2"></i>
                                <span class="font-medium text-blue-800">会員からのお問い合わせ</span>
                            </div>
                            <div class="text-sm text-blue-700">
                                <div>会員ID: {{ $contact->user->uuid }}</div>
                                <div>ニックネーム: {{ $contact->user->nickname }}</div>
                            </div>
                        </div>
                    @else
                        <div class="bg-gray-50 p-3 rounded border-l-4 border-gray-400">
                            <div class="flex items-center">
                                <i class="fas fa-user text-gray-600 mr-2"></i>
                                <span class="font-medium text-gray-800">非会員からのお問い合わせ</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ステータス管理 -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">ステータス管理</h3>
                <form method="POST" action="{{ route('admin.contacts.updateStatus', $contact->uuid) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-600 mb-2">ステータス変更</label>
                        <select name="status" id="status" class="w-full border border-gray-300 rounded px-3 py-2">
                            @foreach(\App\Enums\ContactStatus::options() as $value => $label)
                                <option value="{{ $value }}" {{ $contact->status->value === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">ステータスを変更してお問い合わせの進捗を管理できます。</p>
                    </div>
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded">
                        <i class="fas fa-save mr-2"></i> ステータスを更新
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
