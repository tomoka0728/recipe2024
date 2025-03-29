<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // セッションを再生成
        $request->session()->regenerate();
        $redirectTo = $request->input('redirect_to');

        \Log::info('リクエスト内容:', $request->all());
        \Log::info('redirect_to の値: ' . $redirectTo);

        if ($redirectTo) {
            session(['url.intended' => $redirectTo]);
        }

        return redirect()->intended(route('top'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        \Log::info('Current session ID: ' . session()->getId());

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        \Log::info('Session ID after logout: ' . session()->getId());

        return redirect('/');
    }
}