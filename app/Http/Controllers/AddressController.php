<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Models\User;
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
        $addressType = $request->input('address_type');

        // 共通バリデーション項目
        $commonRules = [
            'method' => 'required|string',
            'point' => 'required|in:use,not_use',
            'use_point' => 'nullable|integer|min:0',
        ];

         if ($addressType === 'existing') {
            $validatedData = $request->validate(array_merge([
                'address_type' => 'required|in:existing,new',
                'existing_address_id' => [
                    'required',
                    Rule::exists('addresses', 'uuid')->where('user_uuid', Auth::user()->uuid),
                ],
            ], $commonRules));

            session()->put('selected_address_id', $request->input('existing_address_id'));
            session()->forget('address_data');
        } else {
            $validatedData = $request->validate(array_merge([
                'address_type' => 'required|in:existing,new',
                'existing_address_id' => 'required_if:address_type,existing|exists:addresses,id',

                'name' => 'required_if:address_type,new|string|max:255',
                'zipcode' => ['required_if:address_type,new', 'regex:/^\d{7}$/'],
                'prefectures' => 'required_if:address_type,new|string|max:255',
                'city' => 'required_if:address_type,new|string|max:255',
                'address' => 'required_if:address_type,new|string|max:255',
                'room' => 'nullable|string|max:255',
                'phone' => ['required_if:address_type,new', 'regex:/^\d{10,11}$/'],
            ], $commonRules), [
                'address_type.required' => '住所の選択をしてください。',
                'address_type.in' => '無効な住所の選択です。',
                'existing_address_id.required_if' => '既存の住所を選択してください。',
                'existing_address_id.exists' => '選択した住所が存在しません。',
                'name.required_if' => '新しい住所の名前を入力してください。',
                'name.required' => '名前を入力してください。',
                'name.string' => '名前は文字列で入力してください。',
                'name.max' => '名前は255文字以内で入力してください。',
                'zipcode.required' => '郵便番号を入力してください。',
                'zipcode.regex' => '郵便番号は7桁の数字で入力してください。',
                'prefectures.required' => '都道府県を選択してください。',
                'city.required' => '市区町村を入力してください。',
                'address.required' => '住所を入力してください。',
                'phone.required' => '電話番号を入力してください。',
                'phone.regex' => '電話番号は10桁または11桁の数字で入力してください。',
            ]);


            // セッションにデータを保存
            session()->put('address_data', $request->only(['name','zipcode', 'prefectures', 'city', 'address', 'room', 'phone']));
            session()->forget('selected_address_id');
        }

        session()->put('payment-method', $request->input('method'));
        session()->put('pointUsage', $request->input('point'));
        session()->put('usedPoints', $request->input('use_point', 0));

        // デバッグ用ログ
        \Log::info('セッションデータ・AddressController:', session()->all());

        return redirect()->route('payment.confirm');
    }
}
