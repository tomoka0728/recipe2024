@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold mb-6">ポイント明細</h2>

    <div class="mb-4">
        <p>現在の保有ポイント：<span class="font-bold text-green-600">{{ Auth::user()->points }} pt</span></p>
    </div>

    <div class="bg-white shadow rounded">
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 text-left">日付</th>
                    <th class="px-4 py-2 text-left">内容</th>
                    <th class="px-4 py-2 text-right">増減</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($histories as $history)
                @if ($history->points == 0)
                    @continue
                @endif
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $history->created_at->format('Y/m/d H:i') }}</td>
                        <td class="px-4 py-2">{{ $history->description }}</td>
                        <td class="px-4 py-2 text-right {{ $history->type === 'earned' ? 'text-green-600' : 'text-red-500' }}">
                            {{ $history->type === 'earned' ? '+' : '-' }}{{ $history->points }} pt
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-gray-500">ポイント履歴はまだありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6 px-4">
            {{ $histories->links() }}
        </div>
    </div>
</div>
@endsection
