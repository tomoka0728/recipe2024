@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">お問い合わせ管理</h2>
        <div class="flex items-center gap-4">
            <!-- 統計情報 -->
            <div class="text-center">
                <div class="font-bold text-red-600 text-lg">{{ $contacts->where('status', 'pending')->count() }}</div>
                <small class="text-gray-500">未対応</small>
            </div>
            <div class="text-center">
                <div class="font-bold text-blue-600 text-lg">{{ $contacts->whereIn('status', ['in_progress', 'replied'])->count() }}</div>
                <small class="text-gray-500">対応中</small>
            </div>
            <div class="text-center">
                <div class="font-bold text-green-600 text-lg">{{ $contacts->where('status', 'closed')->count() }}</div>
                <small class="text-gray-500">対応済み</small>
            </div>
            <div class="text-center">
                <div class="font-bold text-blue-600 text-lg">{{ $contacts->count() }}</div>
                <small class="text-gray-500">総件数</small>
            </div>
        </div>
    </div>

    <form method="GET" class="mb-6 flex flex-wrap items-center gap-4">
        <input type="text" name="search" placeholder="名前、メール、件名で検索" value="{{ request('search') }}"
               class="border rounded px-3 py-2 w-64">

        <select name="status" class="border rounded px-3 py-2">
            <option value="">全ステータス</option>
            @foreach($statusOptions as $value => $label)
                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        <select name="type" class="border rounded px-3 py-2">
            <option value="">全種別</option>
            @foreach($typeOptions as $value => $label)
                <option value="{{ $value }}" {{ request('type') === $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">検索</button>
        <a href="{{ route('admin.contacts.index') }}"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 hover:text-white font-semibold py-2 px-4 rounded">
            リセット
        </a>
    </form>

    <table class="min-w-full bg-white border">
        <thead>
            <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6">受付日時</th>
                <th class="py-3 px-6">送信者</th>
                <th class="py-3 px-6">種別</th>
                <th class="py-3 px-6">お問い合わせ内容</th>
                <th class="py-3 px-6">ステータス</th>
                <th class="py-3 px-6">最終更新</th>
                <th class="py-3 px-6 text-center w-20">操作</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm">
            @forelse($contacts as $contact)
                <tr class="border-b border-gray-200 hover:bg-gray-50 {{ $contact->status->value === 'pending' ? 'bg-red-50' : '' }}">
                    <td class="py-3 px-6">
                        <div class="font-bold">{{ $contact->created_at->format('Y/m/d') }}</div>
                        <div class="text-gray-500">{{ $contact->created_at->format('H:i') }}</div>
                    </td>
                    <td class="py-3 px-6">
                        <div class="font-bold">{{ $contact->name }}</div>
                        <div class="text-gray-500">{{ $contact->email }}</div>
                    </td>
                    <td class="py-3 px-6">
                        {{ $contact->type->label() }}
                    </td>
                    <td class="py-3 px-6">
                        <div class="font-bold mb-1">{{ Str::limit($contact->subject, 40) }}</div>
                        <div class="text-gray-500">{{ Str::limit($contact->message, 60) }}</div>
                    </td>
                    <td class="py-3 px-6">
                        @if($contact->status->value === 'pending')
                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded">
                                未対応
                            </span>
                        @elseif($contact->status->value === 'in_progress' || $contact->status->value === 'replied')
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                対応中
                            </span>
                        @elseif($contact->status->value === 'closed')
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                対応済み
                            </span>
                        @else
                            <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                                {{ $contact->status_label }}
                            </span>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        <div class="font-bold">{{ $contact->updated_at->format('Y/m/d') }}</div>
                        <div class="text-gray-500">{{ $contact->updated_at->format('H:i') }}</div>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('admin.contacts.show', $contact) }}"
                           class="text-blue-600 hover:underline text-sm" title="詳細表示">
                            詳細
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-gray-500">
                        <i class="fas fa-comments text-4xl mb-3"></i>
                        <div class="text-lg">お問い合わせがありません</div>
                        @if(request()->hasAny(['status', 'type', 'search']))
                            <div class="text-sm">検索条件に一致するお問い合わせが見つかりませんでした。</div>
                        @else
                            <div class="text-sm">まだお問い合わせが投稿されていません。</div>
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($contacts, 'links'))
        <div class="mt-6">
            {{ $contacts->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection
