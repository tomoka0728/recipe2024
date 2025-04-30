<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AdminLog;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $logs = AdminLog::with('admin')->latest()->limit(20)->get();
        return view('admin.dashboard', compact('logs'));
    }
}
