<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Address;

class AddressController extends Controller
{
    /**
     * 住所確認画面に必要なデータを取得する
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirm(Request $request): View
    {
        $request->validate([
            'zipcode' => ['required', 'integer', 'max:255'],
            'prefectures' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'room' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'integer','max:15'],
        ]);

        // セッションに住所の情報を保管
        $request->session()->regenerate();
        $request->session()->put('zipcode', $request->zipcode);
        $request->session()->put('prefectures', $request->prefectures);
        $request->session()->put('city', $request->city);
        $request->session()->put('address', $request->address);
        $request->session()->put('room', $request->room);
        $request->session()->put('phone', $request->phone);

        // 確認画面を表示
        return view('user.address.register-confirm', [
            'zipcode' => $request->zipcode,
            'prefectures' => $request->prefectures,
            'city' => $request->city,
            'address' => $request->address,
            'room' => $request->room,
            'phone' => $request->phone,
        ]);
    }

    /**
     * 住所登録を完了し、データベースに保存する。
     */
    public function complete(Request $request): View
    {
        $request->session()->regenerate();

        DB::transaction(function () use ($request) {
            // ログインしているユーザーの住所を登録
            $user = Auth::user();
            $user->addresses()->create([
                'zipcode' => $request->session()->get('zipcode'),
                'prefectures' => $request->session()->get('prefectures'),
                'city' => $request->session()->get('city'),
                'address' => $request->session()->get('address'),
                'room' => $request->session()->get('room'),
                'phone' => $request->session()->get('phone'),
            ]);
        });

        return view('user.address.register-complete');
    }
}