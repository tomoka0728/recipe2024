<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>お問い合わせへの回答</title>
</head>
<body style="font-family: 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', Meiryo, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #d4af37; border-bottom: 2px solid #d4af37; padding-bottom: 10px;">RecipeMart</h1>

        <p>{{ $contact->name }} 様</p>

        <p>この度は、RecipeMarłにお問い合わせいただき、誠にありがとうございました。<br>
        ご質問について回答させていただきます。</p>

        <div style="background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 5px; padding: 20px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #495057;">お問い合わせ内容</h3>
            <div style="background-color: white; padding: 15px; border-radius: 3px; margin-bottom: 15px;">
                <strong>件名:</strong> {{ $contact->subject }}<br>
                <strong>お問い合わせ日:</strong> {{ $contact->created_at->format('Y年m月d日 H:i') }}<br><br>
                <div style="white-space: pre-line;">{{ $contact->message }}</div>
            </div>
        </div>

        <div style="background-color: #e8f4fd; border: 1px solid #b8daff; border-radius: 5px; padding: 20px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #004085;">回答</h3>
            <div style="white-space: pre-line;">{{ $contact->admin_reply }}</div>
            <hr style="border: none; border-top: 1px solid #b8daff; margin: 15px 0;">
            <div style="font-size: 12px; color: #004085;">
                回答日: {{ $contact->admin_replied_at->format('Y年m月d日 H:i') }}
                @if($contact->adminRepliedBy)
                    <br>回答者: {{ $contact->adminRepliedBy->name }}
                @endif
            </div>
        </div>

        <p>ご不明な点がございましたら、お気軽にお問い合わせください。<br>
        今後ともRecipeMartをよろしくお願いいたします。</p>

        <hr style="border: none; border-top: 1px solid #dee2e6; margin: 30px 0;">

        <div style="font-size: 12px; color: #6c757d;">
            <p>RecipeMart カスタマーサポート<br>
            お問い合わせは<a href="{{ route('contact.create') }}">こちら</a>からお願いいたします。</p>
        </div>
    </div>
</body>
</html>
