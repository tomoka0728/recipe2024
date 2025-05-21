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

        $dailySales = DailySale::orderBy('date')->get();
        $labels = $dailySales->pluck('date')->map(fn($d) => Carbon::parse($d)->format('m/d'));
        $data = $dailySales->pluck('total_sales');

        return view('admin.dashboard', compact('logs', 'labels', 'data'));
    }
}
