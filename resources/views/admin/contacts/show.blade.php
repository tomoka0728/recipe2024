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
            @if($contact->status->value === 'pending')
                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">未対応</span>
            @elseif($contact->status->value === 'in_progress' || $contact->status->value === 'replied')
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">対応中</span>
            @elseif($contact->status->value === 'closed')
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
                <h3 class="text-base font-semibold text-gray-800 mb-4">お問い合わせ内容</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-xs text-gray-500 mb-2">{{ $contact->created_at->format('Y年m月d日 H:i') }} - {{ $contact->name }}</div>
                    <div class="whitespace-pre-line text-gray-700 leading-relaxed text-sm">{{ $contact->message }}</div>
                </div>
            </div>

            <!-- メッセージ -->
            @if($contact->messages && $contact->messages->count() > 0)
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                    <div class="space-y-3">
                        @foreach($contact->messages as $message)
                            <div class="{{ $message->sender_type === 'admin' ? 'bg-blue-50' : 'bg-white border border-gray-200' }} rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm {{ $message->sender_type === 'admin' ? 'text-blue-600' : 'text-gray-700' }} font-medium">
                                        {{ $message->sender_name }}
                                    </span>
                                    <span class="text-xs text-gray-400">{{ $message->created_at->format('Y/m/d H:i') }}</span>
                                </div>
                                <div class="whitespace-pre-line text-gray-700 leading-relaxed text-sm">{{ $message->message }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 返答フォーム -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <form method="POST" action="{{ route('admin.contacts.sendReply', $contact->uuid) }}">
                    @csrf
                    <div class="mb-4">
                        <textarea name="admin_reply" id="admin_reply" rows="8"
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 text-sm {{ $contact->status->value === 'closed' ? 'bg-gray-100 text-gray-500 cursor-not-allowed' : '' }}"
                                  placeholder="返答内容を入力..."
                                  {{ $contact->status->value === 'closed' ? 'disabled' : '' }}>{{ old('admin_reply') }}</textarea>
                        @error('admin_reply')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex gap-2">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 px-5 rounded-lg transition {{ $contact->status->value === 'closed' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $contact->status->value === 'closed' ? 'disabled' : '' }}>
                            送信
                        </button>
                        <button type="button" onclick="openTemplateModal()"
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium py-2 px-4 rounded-lg transition {{ $contact->status->value === 'closed' ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $contact->status->value === 'closed' ? 'disabled' : '' }}>
                            テンプレート
                        </button>
                    </div>
                </form>
            </div>

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
                                <div>会員登録日: {{ $contact->user->created_at->format('Y年m月d日') }}</div>
                                <div>会員ランク: {{
                                    $contact->user->membership_status_code === \App\Enums\MembershipStatus::General ? '一般会員' :
                                    ($contact->user->membership_status_code === \App\Enums\MembershipStatus::Silver ? 'シルバー会員' :
                                    ($contact->user->membership_status_code === \App\Enums\MembershipStatus::Gold ? 'ゴールド会員' : '不明'))
                                }}</div>
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
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                @if($contact->status->value === 'closed')
                    <button type="button" disabled
                            class="w-full bg-gray-300 text-gray-500 font-semibold py-2 px-4 rounded cursor-not-allowed">
                        <i class="fas fa-check mr-2"></i> クローズ完了
                    </button>
                @else
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">お問い合わせをクローズ</h3>
                    <form method="POST" action="{{ route('admin.contacts.updateStatus', $contact->uuid) }}">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="closed">
                        <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded"
                                onclick="return confirm('このお問い合わせをクローズしますか？')">
                            <i class="fas fa-check mr-2"></i> お問い合わせをクローズ
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- 削除操作 -->
    <div class="bg-white border border-red-200 rounded-lg p-6 mt-6">
        <h3 class="text-lg font-semibold text-red-600 mb-4">危険な操作</h3>
        <div class="bg-red-50 p-4 rounded mb-4">
            <p class="text-sm text-red-700 mb-2">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <strong>注意:</strong> この操作は元に戻すことができません。
            </p>
            <p class="text-sm text-red-600">お問い合わせを削除すると、すべての履歴と返答内容が完全に削除されます。</p>
        </div>
        <form method="POST" action="{{ route('admin.contacts.destroy', $contact->uuid) }}"
              onsubmit="return confirm('本当にこのお問い合わせを完全に削除しますか？\n\nこの操作は取り消すことができません。')"
              class="text-center">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 rounded-lg">
                <i class="fas fa-trash mr-2"></i> お問い合わせを完全に削除
            </button>
        </form>
    </div>
</div>

<!-- テンプレートモーダル -->
<div id="templateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] flex flex-col">
        <!-- ヘッダー -->
        <div class="px-6 py-4 border-b flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">テンプレートを選択</h3>
            <button onclick="closeTemplateModal()" class="text-white hover:text-gray-100 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- コンテンツ -->
        <div class="px-6 py-4 flex-1 overflow-y-auto">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">テンプレート</label>
                <select id="templateSelect" onchange="previewTemplate()"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400">
                    <option value="">選択してください</option>
                    <option value="0">お礼の返答</option>
                    <option value="1">情報提供の返答</option>
                    <option value="2">お詫びの返答</option>
                    <option value="3">確認依頼の返答</option>
                    <option value="4">対応完了の返答</option>
                </select>
            </div>

            <div id="templatePreview" class="hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">プレビュー</label>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <pre id="previewContent" class="whitespace-pre-wrap text-sm text-gray-700 font-sans"></pre>
                </div>
            </div>
        </div>

        <!-- フッター -->
        <div class="px-6 py-4 border-t flex justify-end gap-3">
            <button onclick="closeTemplateModal()"
                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition">
                キャンセル
            </button>
            <button onclick="insertSelectedTemplate()"
                    class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition">
                挿入
            </button>
        </div>
    </div>
</div>

<script>
const templates = [
    {
        title: 'お礼の返答',
        content: `{{ $contact->name }} 様

この度は温かいお言葉をお寄せいただき、
誠にありがとうございます。

大変励みになり、関係者一同心より感謝しております。
今後もご期待に添えるよう、より一層努めてまいります。

引き続き何卒よろしくお願いいたします。

RecipeMart サポートチーム`
    },
    {
        title: '情報提供の返答',
        content: `{{ $contact->name }} 様

平素よりお世話になっております。
お問い合わせいただいた件につきまして、以下のとおりご回答いたします。

【質問内容】
【回答】

上記内容でご不明な点がございましたら、お気軽にお問い合わせください。
何卒よろしくお願いいたします。

RecipeMart サポートチーム`
    },
    {
        title: 'お詫びの返答',
        content: `{{ $contact->name }} 様

平素より大変お世話になっております。
この度は【ご返信／対応】が遅くなり、誠に申し訳ございませんでした。

本件につきましては現在確認を進めており、
【○月○日まで】に改めてご連絡いたします。

ご不便・ご迷惑をおかけいたしましたこと、重ねてお詫び申し上げます。
何卒よろしくお願いいたします。

RecipeMart サポートチーム`
    },
    {
        title: '確認依頼の返答',
        content: `{{ $contact->name }} 様

平素よりお世話になっております。
お問い合わせいただいた件につきまして、詳細を確認させていただきたく存じます。

【確認したい内容を記載してください】

お手数をおかけいたしますが、ご確認のうえご返信いただけますと幸いです。
何卒よろしくお願いいたします。

RecipeMart サポートチーム`
    },
    {
        title: '対応完了の返答',
        content: `{{ $contact->name }} 様

平素よりお世話になっております。
お問い合わせいただいておりました件につきまして、
下記のとおり対応が完了いたしました。

【対応内容を記載してください】

ご確認いただき、万が一不明点等がございましたらお気軽にお知らせください。
今後とも何卒よろしくお願いいたします。

RecipeMart サポートチーム`
    }
];

function openTemplateModal() {
    document.getElementById('templateModal').classList.remove('hidden');
    document.getElementById('templateSelect').value = '';
    document.getElementById('templatePreview').classList.add('hidden');
}

function closeTemplateModal() {
    document.getElementById('templateModal').classList.add('hidden');
}

function previewTemplate() {
    const select = document.getElementById('templateSelect');
    const preview = document.getElementById('templatePreview');
    const content = document.getElementById('previewContent');

    if (select.value !== '') {
        const template = templates[parseInt(select.value)];
        content.textContent = template.content;
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
    }
}

function insertSelectedTemplate() {
    const select = document.getElementById('templateSelect');
    const textarea = document.getElementById('admin_reply');

    if (select.value !== '') {
        const template = templates[parseInt(select.value)];
        if (textarea.value.trim() === '' || confirm('既存の内容を置き換えますか？')) {
            textarea.value = template.content;
            closeTemplateModal();
            textarea.focus();
        }
    } else {
        alert('テンプレートを選択してください。');
    }
}

// モーダル外クリックで閉じる
document.getElementById('templateModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeTemplateModal();
    }
});

// Escapeキーで閉じる
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeTemplateModal();
    }
});
</script>
@endsection
