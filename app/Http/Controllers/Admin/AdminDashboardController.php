<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminLog;
use App\Models\DailySale;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $logs = AdminLog::with('admin')->latest()->limit(20)->get();

        // 昨日までの7日分をグラフに表示
        $startDate = Carbon::now()->subDays(7)->startOfDay();
        $endDate = Carbon::now()->subDay()->toDateString();

        $dailySales = \App\Models\DailySale::whereBetween('date', [$startDate, $endDate])
            ->selectRaw('date, SUM(total_sales) as total_sales')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $labels = [];
        $data = [];

        // 日付を補完：売上が0の日も表示されるようにする
        for ($i = 7; $i >= 1; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $labels[] = Carbon::parse($date)->format('Y/m/d');
            $data[] = isset($dailySales[$date]) ? $dailySales[$date]->total_sales : 0;
        }

        return view('admin.dashboard', compact('logs', 'labels', 'data'));
    }
}
