<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>お問い合わせ受付完了</title>
</head>
<body style="font-family: 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', Meiryo, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #d4af37; border-bottom: 2px solid #d4af37; padding-bottom: 10px;">RecipeMart</h1>

        <p>{{ $contact->name }} 様</p>

        <p>この度は、RecipeMartにお問い合わせいただき、誠にありがとうございます。<br>
        以下の内容でお問い合わせを受け付けいたしました。</p>

        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px; padding: 20px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #495057;">お問い合わせ内容</h3>
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6; font-weight: bold; width: 120px;">受付日時</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $contact->created_at->format('Y年m月d日 H:i') }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6; font-weight: bold;">お名前</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $contact->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6; font-weight: bold;">メールアドレス</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $contact->email }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6; font-weight: bold;">件名</td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #dee2e6;">{{ $contact->subject }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: bold; vertical-align: top;">お問い合わせ内容</td>
                    <td style="padding: 8px 0; white-space: pre-line;">{{ $contact->message }}</td>
                </tr>
            </table>
        </div>

        <p>担当者が内容を確認次第、ご連絡させていただきます。<br>
        返信まで2〜3営業日程度お時間をいただく場合がございますので、あらかじめご了承ください。</p>

        <p>今後ともRecipeMartをよろしくお願いいたします。</p>

        <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">

        <div style="font-size: 12px; color: #6c757d;">
            <p>RecipeMart カスタマーサポート<br>
            このメールは自動送信されています。このメールに直接返信されても対応できませんのでご了承ください。</p>
        </div>
    </div>
</body>
</html>
