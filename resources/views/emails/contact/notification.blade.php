<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>新しいお問い合わせ</title>
</head>
<body style="font-family: 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', Meiryo, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #d4af37; border-bottom: 2px solid #d4af37; padding-bottom: 10px;">RecipeMart 管理画面</h1>

        <p>新しいお問い合わせが届きました。</p>

        <div style="background-color: #fff3cd; border: 1px solid #ffeaa7; border-radius: 5px; padding: 20px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #856404;">お問い合わせ詳細</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7; font-weight: bold; width: 120px;">受付日時</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7;">{{ $contact->created_at->format('Y年m月d日 H:i') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7; font-weight: bold;">お名前</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7;">{{ $contact->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7; font-weight: bold;">メールアドレス</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7;">{{ $contact->email }}</td>
                </tr>
                @if($contact->user)
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7; font-weight: bold;">会員ID</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7;">#{{ $contact->user->id }} ({{ $contact->user->name }})</td>
                </tr>
                @endif
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7; font-weight: bold;">件名</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #ffeaa7;">{{ $contact->subject }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; vertical-align: top;">お問い合わせ内容</td>
                    <td style="padding: 8px 0; white-space: pre-line;">{{ $contact->message }}</td>
                </tr>
            </table>
        </div>

        <p>管理画面より確認・返信を行ってください。</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('admin.contacts.show', $contact) }}"
               style="background-color: #d4af37; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block;">
                管理画面で確認する
            </a>
        </div>

        <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">

        <div style="font-size: 12px; color: #6c757d;">
            <p>RecipeMart 管理システム<br>
            このメールは自動送信されています。</p>
        </div>
    </div>
</body>
</html>
