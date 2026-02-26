<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Enums\ContactType;
use App\Enums\ContactStatus;
use App\Mail\ContactReceived;
use App\Mail\ContactReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * お問い合わせフォーム表示
     */
    public function create()
    {
        $user = Auth::user();
        $contactTypes = ContactType::options();

        return view('contact.create', compact('user', 'contactTypes'));
    }

    /**
     * 修正ボタンからの戻り処理
     */
    public function edit(Request $request)
    {
        return redirect()->route('contact.create')->withInput($request->all());
    }

    /**
     * お問い合わせ確認画面表示
     */
    public function confirm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys(ContactType::options())),
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'お名前は必須です。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => 'メールアドレスの形式が正しくありません。',
            'type.required' => 'お問い合わせ種別を選択してください。',
            'type.in' => '有効なお問い合わせ種別を選択してください。',
            'subject.required' => '件名は必須です。',
            'message.required' => 'お問い合わせ内容は必須です。',
            'message.max' => 'お問い合わせ内容は2000文字以内で入力してください。',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        return view('contact.confirm', [
            'data' => $request->all(),
            'typeName' => ContactType::from($request->type)->label()
        ]);
    }

    /**
     * お問い合わせ送信処理
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'type' => 'required|string|in:' . implode(',', array_keys(ContactType::options())),
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contact.create')
                ->withErrors($validator)
                ->withInput();
        }

        // お問い合わせデータを保存
        $contact = Contact::create([
            'user_uuid' => Auth::user() ? Auth::user()->uuid : null,
            'name' => $request->name,
            'email' => $request->email,
            'type' => ContactType::from($request->type),
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => ContactStatus::PENDING,
        ]);

        // TODO: 一時的にメール送信を無効化（Mailtrapエラー回避のため）
        // ユーザーに自動返信メール送信
        // Mail::to($request->email)->send(new ContactReceived($contact));

        // 管理者に通知メール送信
        // $adminEmail = config('mail.admin_email', 'admin@example.com');
        // Mail::to($adminEmail)->send(new \App\Mail\ContactNotification($contact));

        return redirect()->route('contact.complete');
    }

    /**
     * お問い合わせ完了画面表示
     */
    public function complete()
    {
        return view('contact.complete');
    }

    /**
     * ユーザーのお問い合わせ履歴表示
     */
    public function history()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $contacts = Contact::where('user_uuid', Auth::user()->uuid)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('contact.history', compact('contacts'));
    }

    /**
     * お問い合わせ詳細表示
     */
    public function show($uuid)
    {
        $contact = Contact::where('uuid', $uuid)->with('messages')->firstOrFail();

        // ログインユーザーの場合は自分のお問い合わせのみ表示
        if (Auth::guard('web')->check() && $contact->user_uuid !== Auth::user()->uuid) {
            abort(403);
        }

        return view('contact.show', compact('contact'));
    }

    /**
     * ユーザーからの返信送信
     */
    public function sendReply(Request $request, $uuid)
    {
        $contact = Contact::where('uuid', $uuid)->firstOrFail();

        // ログインユーザーの場合は自分のお問い合わせのみ
        if (Auth::guard('web')->check() && $contact->user_uuid !== Auth::user()->uuid) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ], [
            'message.required' => '返信内容は必須です。',
            'message.max' => '返信内容は2000文字以内で入力してください。',
        ]);

        // メッセージを保存
        $contact->messages()->create([
            'sender_type' => 'user',
            'sender_id' => Auth::check() ? Auth::user()->uuid : null,
            'message' => $request->message,
        ]);

        // ステータスは対応中のまま（管理者の再対応を促すが、やり取り中であることを明示）
        // 初回でない限り、statusはIN_PROGRESSのまま維持される

        return redirect()->route('contact.show', $contact->uuid)
            ->with('success', '返信を送信しました。');
    }
}
