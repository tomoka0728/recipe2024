<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PointHistory;
use Illuminate\Support\Facades\Auth;

class PointHistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $histories = PointHistory::where('user_uuid', $user->uuid)
            ->where('points', '!=', 0)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('points', compact('histories'));
    }
}
