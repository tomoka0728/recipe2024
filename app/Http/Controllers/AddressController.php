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
    public function confirm(Request $request)
    {
        $validatedData = $request->validate([
            'zipcode' => ['required', 'regex:/^\d{7}$/'],
            'prefectures' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'room' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^\d{10,11}$/'],
            'method' => ['required', 'string'],
            'point' => ['required', 'in:use,not_use'],
            'use_point' => ['nullable', 'integer', 'min:0'],
        ], [
            'zipcode.required' => '郵便番号を入力してください。',
            'zipcode.regex' => '郵便番号は7桁の数字で入力してください。',
            'prefectures.required' => '都道府県を選択してください。',
            'city.required' => '市区町村を入力してください。',
            'address.required' => '住所を入力してください。',
            'phone.required' => '電話番号を入力してください。',
            'phone.regex' => '電話番号は10桁または11桁の数字で入力してください。',
            'method.required' => '支払い方法を選択してください。',
            'point.required' => 'ポイント利用の選択をしてください。',
        ]);

    
        // セッションにデータを保存
        session()->put('address_data', $request->only(['zipcode', 'prefectures', 'city', 'address', 'room', 'phone']));
        session()->put('payment-method', $request->input('method'));
        session()->put('pointUsage', $request->input('point'));
        session()->put('usedPoints', $request->input('use_point', 0));

        // デバッグ用ログ
        \Log::info('セッションデータ・AddressController:', session()->all());
    
        return redirect()->route('payment.confirm');
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
            $addressData = session()->get('address_data', []);

            if (!empty($addressData)) {
                $user->addresses()->create($addressData);
            }
        });

        return view('user.address.register-complete');
    }
}