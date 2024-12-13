<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirm(Request $request): View
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'birth' => ['nullable', 'date', 'before:today'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'],
        ], [
            'terms.accepted' => '同意がない場合は会員登録ができません',
        ]);

        // セッションに値保管し、登録完了画面でDBに登録する
        $request->session()->regenerate();

        $birth = $request->session()->get('birth');
        $formattedBirth = $birth ? str_replace('-', '/', $birth) : null;

        // 値保管
        $request->session()->put('name', $request->name);
        $request->session()->put('birth', $request->birth);
        $request->session()->put('email', $request->email);
        $request->session()->put('password', Hash::make($request->password));
        $request->session()->put('terms_accepted', $request->terms);


        // 確認画面を表示
        return view('auth.register-confirm', [
            'name' => $request->name,
            'birth' => $formattedBirth,
            'email' => $request->email,
            'terms_accepted' => $request->terms,
        ]);
    }


    public function complete(Request $request): View
    {
        $request->session()->regenerate();

        DB::transaction(function () use ($request) {

            $user = User::create([
                'name' => $request->session()->get('name'),
                'birth' => $request->session()->get('birth'),
                'email' => $request->session()->get('email'),
                'password' => $request->session()->get('password'), // ハッシュ化済みのパスワードを使用
                'terms_accepted' => $request->session()->get('terms_accepted')
            ]);

            Auth::login($user);

            event(new Registered($user));
        });

        return view('auth.register-complete');
    }
}
