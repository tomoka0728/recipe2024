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
                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">受付中</span>
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
                <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
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
                    <div class="bg-green-50 p-4 rounded border-l-4 border-green-500 mb-6">
                        <div class="whitespace-pre-line text-gray-700 leading-relaxed">{{ $contact->admin_reply }}</div>
                    </div>

                    <!-- 追加返答フォーム -->
                    <div class="border-t pt-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">追加返答</h4>
                        <form method="POST" action="{{ route('admin.contacts.sendReply', $contact->uuid) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="admin_reply" class="block text-sm font-medium text-gray-600 mb-2">追加返答内容</label>
                                <textarea name="admin_reply" id="admin_reply" rows="8"
                                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="追加の返答内容を入力してください...">{{ old('admin_reply') }}</textarea>
                                @error('admin_reply')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-1">2000文字以内で入力してください。</p>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg">
                                    <i class="fas fa-plus mr-2"></i> 追加返答を送信
                                </button>
                                <button type="button" onclick="insertTemplate()"
                                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    <i class="fas fa-clipboard mr-2"></i> テンプレート
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <!-- 返答待ち・返答フォーム -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                    <div class="text-center mb-6">
                        <div class="text-yellow-600 mb-3">
                            <i class="fas fa-clock text-3xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-yellow-800 mb-2">返答待ち</h3>
                        <p class="text-yellow-700 mb-4">このお問い合わせにはまだ返答されていません。</p>
                    </div>

                    <!-- 返答フォーム -->
                    <div class="bg-white p-6 rounded-lg border">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">返答内容</h4>
                        <form method="POST" action="{{ route('admin.contacts.sendReply', $contact->uuid) }}">
                            @csrf
                            <div class="mb-4">
                                <label for="admin_reply" class="block text-sm font-medium text-gray-600 mb-2">返答メッセージ</label>
                                <textarea name="admin_reply" id="admin_reply" rows="10"
                                          class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="お客様への返答内容を入力してください...">{{ old('admin_reply') }}</textarea>
                                @error('admin_reply')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-sm text-gray-500 mt-1">2000文字以内で入力してください。この返答は {{ $contact->email }} 宛にメールで送信されます。</p>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg">
                                    <i class="fas fa-reply mr-2"></i> 返答を送信
                                </button>
                                <button type="button" onclick="insertTemplate()"
                                        class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    <i class="fas fa-clipboard mr-2"></i> テンプレート
                                </button>
                            </div>
                        </form>
                    </div>
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
            @if($contact->status !== 'closed')
            <div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">お問い合わせをクローズ</h3>
                <form method="POST" action="{{ route('admin.contacts.updateStatus', $contact->uuid) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="closed">
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-3">このお問い合わせを完了としてクローズしますか？</p>
                        <p class="text-sm text-red-600">※ クローズ後も内容の確認は可能ですが、ステータスの変更はできなくなります。</p>
                    </div>
                    <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded"
                            onclick="return confirm('このお問い合わせをクローズしますか？')">
                        <i class="fas fa-check mr-2"></i> お問い合わせをクローズ
                    </button>
                </form>
            </div>
            @endif
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

<script>
function insertTemplate() {
    const textarea = document.getElementById('admin_reply');
    const templates = [
        {
            title: 'お礼の返答',
            content: `{{ $contact->name }} 様

この度は貴重なお時間を割いて、お問い合わせをいただき誠にありがとうございます。

いただいたご連絡を拝読させていただきました。
お客様のご意見は私どもにとって大変貴重なものであり、心より感謝申し上げます。

今後ともどうぞよろしくお願いいたします。

Recipe2024 サポートチーム`
        },
        {
            title: '情報提供の返答',
            content: `{{ $contact->name }} 様

お問い合わせいただき、ありがとうございます。

ご質問の件についてご案内させていただきます。

【ここに具体的な情報を記載してください】

ご不明な点がございましたら、お気軽にお問い合わせください。

Recipe2024 サポートチーム`
        },
        {
            title: 'お詫びの返答',
            content: `{{ $contact->name }} 様

この度はご迷惑をおかけし、誠に申し訳ございません。

いただいたご指摘を真摯に受け止め、改善に努めてまいります。

【ここに具体的な対応策を記載してください】

今後このようなことがないよう十分注意いたします。
何かご不明な点がございましたら、お気軽にお問い合わせください。

Recipe2024 サポートチーム`
        }
    ];

    // シンプルな選択ダイアログ
    let choice = prompt(
        "テンプレートを選択してください:\n" +
        "1: お礼の返答\n" +
        "2: 情報提供の返答\n" +
        "3: お詫びの返答\n\n" +
        "番号を入力してください (1-3):"
    );

    const index = parseInt(choice) - 1;
    if (index >= 0 && index < templates.length) {
        if (textarea.value.trim() === '' || confirm('既存の内容を置き換えますか？')) {
            textarea.value = templates[index].content;
            textarea.focus();
        }
    }
}
</script>
@endsection
