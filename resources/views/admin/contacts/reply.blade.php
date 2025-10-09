@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- ヘッダー部分 -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center bg-white p-4 rounded shadow-sm">
                <div>
                    <h2 class="mb-1 text-primary">
                        <i class="fas fa-reply me-2"></i>
                        お問い合わせ返答
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">ダッシュボード</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.contacts.index') }}">お問い合わせ管理</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.contacts.show', $contact->uuid) }}">詳細</a></li>
                            <li class="breadcrumb-item active">返答</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.contacts.show', $contact->uuid) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> 詳細に戻る
                    </a>
                    <span class="badge bg-warning fs-6 py-2 px-3">
                        <i class="fas fa-clock me-1"></i> 返答作成中
                    </span>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>入力エラーがあります:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <!-- 返答フォーム -->
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        返答内容の作成
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.contacts.sendReply', $contact->uuid) }}" id="replyForm">
                        @csrf

                        <!-- 返答内容 -->
                        <div class="mb-4">
                            <label for="admin_reply" class="form-label fs-5 fw-bold">
                                <i class="fas fa-comment me-1"></i>
                                返答メッセージ
                                <span class="text-danger">*</span>
                            </label>
                            <div class="position-relative">
                                <textarea name="admin_reply" id="admin_reply" rows="12"
                                          class="form-control form-control-lg @error('admin_reply') is-invalid @enderror"
                                          placeholder="お客様への返答内容を入力してください...&#10;&#10;丁寧で分かりやすい返答を心がけましょう。"
                                          style="resize: vertical; min-height: 300px;">{{ old('admin_reply') }}</textarea>
                                <div class="position-absolute bottom-0 end-0 p-2">
                                    <small class="text-muted" id="charCount">0 / 2000文字</small>
                                </div>
                            </div>
                            @error('admin_reply')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- 注意事項 -->
                        <div class="alert alert-info border-0 shadow-sm">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-info-circle text-info fs-4"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="alert-heading">送信前の確認事項</h6>
                                    <ul class="mb-0">
                                        <li>この返答は <strong>{{ $contact->email }}</strong> 宛にメールで送信されます</li>
                                        <li>送信後、お問い合わせのステータスは「返答済み」に変更されます</li>
                                        <li>送信後の編集はできませんので、内容をよくご確認ください</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- 送信ボタン -->
                        <div class="d-flex justify-content-end gap-3 mt-4">
                            <a href="{{ route('admin.contacts.show', $contact->uuid) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i> キャンセル
                            </a>
                            <button type="button" class="btn btn-primary btn-lg" id="sendReplyBtn">
                                <i class="fas fa-paper-plane me-2"></i> 返答を送信
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- 元のお問い合わせ内容 -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">
                        <i class="fas fa-envelope-open me-2"></i>
                        元のお問い合わせ
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-user text-primary me-2"></i>
                            <span class="fw-bold">{{ $contact->name }}</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-envelope text-secondary me-2"></i>
                            <small class="text-muted">{{ $contact->email }}</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-tag text-info me-2"></i>
                            <span class="badge bg-info">{{ $contact->type->label() }}</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-calendar text-warning me-2"></i>
                            <small class="text-muted">{{ $contact->created_at->format('Y年m月d日 H:i') }}</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">件名</h6>
                        <p class="mb-0">{{ $contact->subject }}</p>
                    </div>

                    <div class="mb-3">
                        <h6 class="fw-bold mb-2">内容</h6>
                        <div class="content-box p-3 bg-light rounded border-start border-4 border-primary" style="max-height: 250px; overflow-y: auto;">
                            <div style="line-height: 1.6; white-space: pre-line;">{{ $contact->message }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 返答テンプレート -->
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        返答テンプレート
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">よく使用される返答内容をクリックで挿入できます</p>

                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-outline-success" onclick="insertTemplate('thanks')">
                            <i class="fas fa-heart me-2"></i> お礼の返答
                        </button>
                        <button type="button" class="btn btn-outline-info" onclick="insertTemplate('info')">
                            <i class="fas fa-info-circle me-2"></i> 情報提供の返答
                        </button>
                        <button type="button" class="btn btn-outline-warning" onclick="insertTemplate('apology')">
                            <i class="fas fa-exclamation-triangle me-2"></i> お詫びの返答
                        </button>
                        <button type="button" class="btn btn-outline-primary" onclick="insertTemplate('inquiry')">
                            <i class="fas fa-question-circle me-2"></i> 詳細確認の返答
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 送信確認モーダル -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-paper-plane me-2"></i>
                    返答送信の確認
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning border-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    以下の内容で返答を送信しますか？
                </div>
                <div class="mb-3">
                    <strong>送信先:</strong> {{ $contact->email }}
                </div>
                <div class="mb-3">
                    <strong>送信者:</strong> {{ Auth::guard('admin')->user()->name }}
                </div>
                <div class="alert alert-info border-0 small">
                    <i class="fas fa-info-circle me-1"></i>
                    送信後は編集できません。内容をよくご確認ください。
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i> キャンセル
                </button>
                <button type="button" class="btn btn-primary" onclick="submitReply()">
                    <i class="fas fa-paper-plane me-1"></i> 送信する
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('admin_reply');
    const charCount = document.getElementById('charCount');
    const sendBtn = document.getElementById('sendReplyBtn');

    // 文字数カウント
    function updateCharCount() {
        const length = textarea.value.length;
        charCount.textContent = `${length} / 2000文字`;

        if (length > 2000) {
            charCount.className = 'text-danger';
        } else if (length > 1800) {
            charCount.className = 'text-warning';
        } else {
            charCount.className = 'text-muted';
        }
    }

    textarea.addEventListener('input', updateCharCount);
    updateCharCount();

    // 送信ボタンのイベント
    sendBtn.addEventListener('click', function() {
        if (textarea.value.trim() === '') {
            alert('返答内容を入力してください。');
            textarea.focus();
            return;
        }

        if (textarea.value.length > 2000) {
            alert('返答内容は2000文字以内で入力してください。');
            textarea.focus();
            return;
        }

        // モーダルを表示
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
    });
});

// テンプレート挿入機能
function insertTemplate(type) {
    const textarea = document.getElementById('admin_reply');
    let template = '';

    switch(type) {
        case 'thanks':
            template = `{{ $contact->name }} 様

この度は貴重なお時間を割いて、お問い合わせをいただき誠にありがとうございます。

いただいたご連絡を拝読させていただきました。
お客様のご意見は私どもにとって大変貴重なものであり、心より感謝申し上げます。

今後ともどうぞよろしくお願いいたします。

Recipe2024 サポートチーム`;
            break;

        case 'info':
            template = `{{ $contact->name }} 様

お問い合わせいただき、ありがとうございます。

ご質問の件についてご案内させていただきます。

【ここに具体的な情報を記載してください】

ご不明な点がございましたら、お気軽にお問い合わせください。

Recipe2024 サポートチーム`;
            break;

        case 'apology':
            template = `{{ $contact->name }} 様

この度はご迷惑をおかけし、誠に申し訳ございません。

いただいたご指摘を真摯に受け止め、改善に努めてまいります。

【ここに具体的な対応策を記載してください】

今後このようなことがないよう十分注意いたします。
何かご不明な点がございましたら、お気軽にお問い合わせください。

Recipe2024 サポートチーム`;
            break;

        case 'inquiry':
            template = `{{ $contact->name }} 様

お問い合わせいただき、ありがとうございます。

より詳細にご対応させていただくため、以下の点についてお教えいただけますでしょうか。

【ここに確認したい項目を記載してください】

お手数をおかけいたしますが、ご協力のほどよろしくお願いいたします。

Recipe2024 サポートチーム`;
            break;
    }

    if (textarea.value.trim() === '') {
        textarea.value = template;
    } else {
        // 既存の内容がある場合は確認
        if (confirm('既存の内容を置き換えますか？\n\n「キャンセル」を選択すると末尾に追加されます。')) {
            textarea.value = template;
        } else {
            textarea.value += '\n\n' + template;
        }
    }

    // 文字数更新とフォーカス
    textarea.dispatchEvent(new Event('input'));
    textarea.focus();
}

// フォーム送信
function submitReply() {
    document.getElementById('replyForm').submit();
}
</script>
@endsection
