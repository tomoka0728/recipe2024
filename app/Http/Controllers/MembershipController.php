<?php

namespace App\Http\Controllers;

use App\Enums\MembershipStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;


class MembershipController extends Controller
{
    // グレード変更画面の表示
    public function edit()
    {
        $user = Auth::user();

        return view('membership-upgrade', [
            'user' => $user,
            'currentStatus' => $user->membership_status_code,
        ]);
    }

    // グレード変更の処理
    public function update(Request $request)
    {
        $request->validate([
            'status' => ['required', new Enum(MembershipStatus::class)],
        ]);

        $user = Auth::user();

        // from() でEnumに変換 → valueを保存
        $membershipStatus = MembershipStatus::from((int) $request->input('status'));

        // 変更前と同じステータスを選択した場合はエラーにする
        if ($membershipStatus->value === $user->membership_status_code->value) {
            throw ValidationException::withMessages([
                'status' => ['すでに選択されている会員グレードです。'],
            ]);
        }

        $user->membership_status_code = $membershipStatus->value;
        $user->save();

        return redirect()->route('membership.edit')->with('status', '会員プランを変更しました。');
    }
}
