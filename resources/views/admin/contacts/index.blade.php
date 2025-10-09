@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>お問い合わせ管理</h1>
    </div>

    <!-- フィルター -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.contacts.index') }}">
                <div class="row">
                    <div class="col-md-4">
                        <label for="status" class="form-label">ステータス</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">すべて</option>
                            @foreach($statusOptions as $value => $label)
                                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="search" class="form-label">検索</label>
                        <input type="text" name="search" id="search" class="form-control"
                               value="{{ request('search') }}" placeholder="名前、メール、件名で検索">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">検索</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- お問い合わせ一覧 -->
    <div class="card">
        <div class="card-body">
            @if($contacts->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>受付日時</th>
                                <th>送信者</th>
                                <th>件名</th>
                                <th>ステータス</th>
                                <th>最終更新</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>
                                        <small>{{ $contact->created_at->format('Y/m/d H:i') }}</small>
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $contact->name }}</strong>
                                            @if($contact->user)
                                                <span class="badge bg-info">会員</span>
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $contact->email }}</small>
                                    </td>
                                    <td>
                                        <div>{{ Str::limit($contact->subject, 30) }}</div>
                                        <small class="text-muted">{{ Str::limit($contact->message, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge
                                            @if($contact->status === 'pending') bg-warning text-dark
                                            @elseif($contact->status === 'replied') bg-success
                                            @else bg-secondary @endif">
                                            {{ $contact->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $contact->updated_at->format('Y/m/d H:i') }}</small>
                                        @if($contact->admin_replied_at)
                                            <br><small class="text-success">返信済み</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.contacts.show', $contact) }}"
                                               class="btn btn-sm btn-outline-primary">詳細</a>
                                            @if($contact->status === 'pending')
                                                <a href="{{ route('admin.contacts.reply', $contact) }}"
                                                   class="btn btn-sm btn-success">返信</a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- ページネーション -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $contacts->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">お問い合わせがありません</h5>
                    <p class="text-muted">条件に一致するお問い合わせが見つかりませんでした。</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table th {
    font-weight: 600;
}
.btn-group .btn {
    margin-right: 0;
}
</style>
@endpush
