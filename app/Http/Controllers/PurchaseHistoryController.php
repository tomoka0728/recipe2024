<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseHistory;

class PurchaseHistoryController extends Controller
{
    /**
     * 購入履歴一覧を表示
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // デバッグ情報
        if (!$user) {
            return redirect()->route('login');
        }

        // フィルターのクエリ
        $query = PurchaseHistory::with(['details.ingredient'])
            ->where('user_uuid', $user->uuid);

        // フィルターが指定されている場合
        if ($request->has('filter') && $request->filter != '') {
            $filter = $request->filter;
            
            if ($filter == 'recent_3_months') {
                // 直近3か月
                $threeMonthsAgo = now()->subMonths(3);
                $query->where('purchased_at', '>=', $threeMonthsAgo);
            } elseif (is_numeric($filter)) {
                // 年フィルター
                $query->whereYear('purchased_at', $filter);
            }
        }

        // 購入履歴を取得
        $purchaseHistories = $query->orderBy('purchased_at', 'desc')->paginate(10);

        // 利用可能な年のリストを取得
        $availableYears = PurchaseHistory::where('user_uuid', $user->uuid)
            ->whereNotNull('purchased_at')
            ->selectRaw('YEAR(purchased_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        // デバッグ: データが取得できているか確認
        \Log::info('Purchase History Debug:', [
            'user_uuid' => $user->uuid,
            'purchaseHistories_count' => $purchaseHistories->count(),
            'availableYears_count' => $availableYears->count(),
            'request_filter' => $request->filter
        ]);

        return view('purchase-history.index', compact('purchaseHistories', 'availableYears'));
    }

    /**
     * 購入履歴の詳細を表示
     */
    public function show($uuid)
    {
        $user = Auth::user();

        $purchaseHistory = PurchaseHistory::with(['details.ingredient'])
            ->where('uuid', $uuid)
            ->where('user_uuid', $user->uuid)
            ->firstOrFail();

        return view('purchase-history.show', compact('purchaseHistory'));
    }
}
