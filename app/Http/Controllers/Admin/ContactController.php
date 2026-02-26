<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Enums\ContactStatus;
use App\Enums\ContactType;
use App\Mail\ContactReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * お問い合わせ一覧表示
     */
    public function index(Request $request)
    {
        $query = Contact::with(['user']);

        // ステータスフィルター
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 種別フィルター
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 検索フィルター
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        $contacts = $query->orderBy('created_at', 'desc')->paginate(15);
        $statusOptions = ContactStatus::options();
        $typeOptions = ContactType::options();

        return view('admin.contacts.index', compact('contacts', 'statusOptions', 'typeOptions'));
    }

    /**
     * お問い合わせ詳細表示
     */
    public function show($uuid)
    {
        $contact = Contact::where('uuid', $uuid)->with(['user', 'messages'])->firstOrFail();
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * お問い合わせ返答送信
     */
    public function sendReply(Request $request, $uuid)
    {
        $contact = Contact::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'admin_reply' => 'required|string|max:2000',
        ], [
            'admin_reply.required' => '返答内容は必須です。',
            'admin_reply.max' => '返答内容は2000文字以内で入力してください。',
        ]);

        // メッセージを保存
        $contact->messages()->create([
            'sender_type' => 'admin',
            'sender_id' => Auth::guard('admin')->user()->uuid,
            'message' => $request->admin_reply,
        ]);

        // お問い合わせを更新
        $contact->update([
            'status' => ContactStatus::IN_PROGRESS,
            'admin_replied_at' => now(),
            'admin_replied_by' => Auth::guard('admin')->user()->uuid,
        ]);

        // admin_replyフィールドも更新（互換性のため）
        if (!$contact->admin_reply) {
            $contact->update(['admin_reply' => $request->admin_reply]);
        }

        // ユーザーに返答メール送信
        Mail::to($contact->email)->send(new ContactReply($contact));

        return redirect()->route('admin.contacts.show', $contact->uuid)
            ->with('success', '返答を送信しました。');
    }

    /**
     * お問い合わせステータス更新
     */
    public function updateStatus(Request $request, $uuid)
    {
        $contact = Contact::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'status' => 'required|string|in:' . implode(',', array_keys(ContactStatus::options())),
        ]);

        $contact->update([
            'status' => ContactStatus::from($request->status),
        ]);

        return redirect()->back()->with('success', 'ステータスを更新しました。');
    }

    /**
     * お問い合わせ削除
     */
    public function destroy($uuid)
    {
        $contact = Contact::where('uuid', $uuid)->firstOrFail();
        $contact->delete();
        return redirect()->route('admin.contacts.index')
            ->with('success', 'お問い合わせを削除しました。');
    }
}
