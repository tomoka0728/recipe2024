@extends('layouts.admin')

@section('content')
<div class="p-6 space-y-6">

    <!-- 管理者ログ -->
    <section class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">管理者ログ</h2>
        <div class="overflow-x-auto max-h-32">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-2">日付</th>
                        <th class="px-4 py-2">更新者</th>
                        <th class="px-4 py-2">ステータス</th>
                        <th class="px-4 py-2">詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $log->created_at->format('Y/m/d H:i') }}</td>
                            <td class="px-4 py-2">{{ $log->admin->admin_id ?? '不明' }}</td>
                            <td class="px-4 py-2">
                                @if ($log->action === 'create')
                                    <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">登録</span>
                                @elseif ($log->action === 'edit')
                                    <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">編集</span>
                                @elseif ($log->action === 'delete')
                                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">削除</span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">その他</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $log->detail }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-2" colspan="4">ログがありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

 <!-- ユーザーアクティビティ + 売り上げグラフ -->
 <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- ユーザーアクティビティ -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">ユーザーアクティビティ</h2>
        <ul class="space-y-2 text-sm text-gray-700">
            <li class="flex items-start gap-2">
                <span class="font-medium text-gray-900">佐藤 花子</span>
                が <span class="text-blue-600">レシピ登録</span>
                （春野菜の煮物） - <span class="text-gray-500">2025/04/23</span>
            </li>
            <!-- 他の履歴も追加可 -->
        </ul>
    </div>

    <!-- 売り上げグラフ Chart.js -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="text-lg font-semibold text-gray-800 mb-3 border-b pb-2">売り上げグラフ</h2>
        <canvas id="salesChart" class="w-full h-64"></canvas>
    </div>
    </section>
</div>
@endsection

@push('scripts')
    <script>
        window.salesChartLabels = @json($labels);
        window.salesChartData = @json($data);
    </script>
    @vite('resources/js/sales-chart.js')
@endpush
