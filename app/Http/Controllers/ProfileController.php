<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the name edit form.
     */
    public function editName(Request $request): View
    {
        return view('profile.edit-name', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the email edit form.
     */
    public function editEmail(Request $request): View
    {
        return view('profile.edit-email', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the birthday edit form.
     */
    public function editBirthday(Request $request): View
    {
        return view('profile.edit-birthday', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the nickname edit form.
     */
    public function editNickname(Request $request): View
    {
        return view('profile.edit-nickname', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Display the password edit form.
     */
    public function editPassword(Request $request): View
    {
        return view('profile.edit-password', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $user = $request->user();

        // 空の値の場合の処理（誕生日のみ）
        if (array_key_exists('birth', $validatedData) && empty($validatedData['birth'])) {
            $validatedData['birth'] = null;
        }

        $user->fill($validatedData);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // どのフィールドが送信されたかに基づいてリダイレクト先を決定
        if ($request->has('name') && !$request->has(['email', 'birth', 'nickname'])) {
            return Redirect::route('profile.edit.name')->with('success', 'お名前を更新しました。');
        } elseif ($request->has('email') && !$request->has(['name', 'birth', 'nickname'])) {
            return Redirect::route('profile.edit.email')->with('success', 'メールアドレスを更新しました。');
        } elseif ($request->has('birth') && !$request->has(['name', 'email', 'nickname'])) {
            return Redirect::route('profile.edit.birthday')->with('success', '誕生日を更新しました。');
        } elseif ($request->has('nickname') && !$request->has(['name', 'email', 'birth'])) {
            return Redirect::route('profile.edit.nickname')->with('success', 'ニックネームを更新しました。');
        }

        return Redirect::route('profile.edit')->with('success', 'アカウント情報を更新しました。');
    }    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Show account deletion confirmation page.
     */
    public function deleteConfirm(Request $request): View
    {
        return view('profile.delete-confirm', [
            'user' => $request->user(),
        ]);
    }
}
