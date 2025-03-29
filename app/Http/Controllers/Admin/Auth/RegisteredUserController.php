<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('admin.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirm(Request $request): View
    {
        $request->validate([
            'admin_id' => ['required', 'string', 'max:255'],
            'admin_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], );

        // セッションに値保管し、登録完了画面でDBに登録する
        $request->session()->regenerate();

        // 値保管
        $request->session()->put('admin_id', $request->admin_id);
        $request->session()->put('admin_name', $request->admin_name);
        $request->session()->put('password', Hash::make($request->password));


        // 確認画面を表示
        return view('admin.auth.register-confirm', [
            'admin_id' => $request->admin_id,
            'admin_name' => $request->admin_name,
        ]);
    }


    public function complete(Request $request): View
    {
        $request->session()->regenerate();

        DB::transaction(function () use ($request) {

            $user = Admin::create([
                'admin_id' => $request->session()->get('admin_id'),
                'admin_name' => $request->session()->get('admin_name'),
                'password' => $request->session()->get('password'), // ハッシュ化済みのパスワードを使用
            ]);

            Auth::login($user);

            event(new Registered($user));
        });

        return view('admin.auth.register-complete');
    }
}
