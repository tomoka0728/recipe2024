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

        $dailySales = \App\Models\DailySale::selectRaw('date, SUM(total_sales) as total_sales')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $labels = [];
        $data = [];
        foreach ($dailySales as $sale) {
            $labels[] = Carbon::parse($sale->date)->format('Y/m/d');
            $data[] = $sale->total_sales;
        }

        return view('admin.dashboard', compact('logs', 'labels', 'data'));
    }
}
