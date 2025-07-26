<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 6px;
            overflow: hidden;
        }
        .header {
            text-align: center;
            padding: 20px 0;
        }
        .logo {
            height: 50px;
        }
        .orange-box {
            background-color: rgb(248, 242, 236);;
            padding: 20px;
            text-align: center;
        }
        .orange-box strong {
            font-size: 18px;
        }
        .orange-box p {
            font-size: 14px;
        }
        .notice {
            border: 1px solid #f8d7da;
            padding: 10px;
            margin-top: 10px;
            font-size: 12px;
            color: #721c24;
            background-color: #fefefe;
        }
        .section-title {
            font-weight: bold;
            font-size: 18px;
            margin: 20px;
        }
        .info {
            padding: 0 20px;
            font-size: 14px;
            line-height: 1.6;
        }
        .info2 {
            padding: 0 20px;
            font-size: 14px;
            line-height: 1.6;
            text-align: right;
        }
        .product {
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            align-items: center;
        }
        .product .product-name {
            flex: 2 1 0;
            min-width: 0;
            word-break: break-all;
        }
        .product .product-qty {
            flex: 0 0 60px;
            text-align: right;
        }
        .product .product-price {
            flex: 0 0 90px;
            text-align: right;
        }
        .divider {
            border-top: 1px solid #dee2e6;
            margin: 0 20px;
        }
        .total {
            padding: 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: right;
        }
        .dotted-line {
            border-top: 2px dashed #ccc;
            margin: 0 20px;
        }
        .delivery {
            padding: 20px;
            font-size: 14px;
        }
        .button-container {
            text-align: center;
            margin: 30px 0 10px;
        }
        .button {
            display: inline-block;
            background-color: #a88686;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
        }
        .sns {
            text-align: center;
            margin: 10px 0 20px;
        }
        .sns img {
            height: 24px;
            margin: 0 8px;
        }
        .footer-line {
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            padding-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <a href="{{ url('/') }}">
                 <img src="{{ Storage::disk('s3')->url('logo.png') }}" alt="Logo" width="40px">
            </a>
        </div>

        <div class="orange-box">
            <strong>{{ $user->name }} 様<br><br>
                ご注文が確定しました
            </strong><br>
            <p>以下のご注文を承りました。</p>
            <div class="notice">
                本メールはRecipeMartでご購入いただいたお客様宛の自動配信メールです。<br>
                このアドレスへの返信はできません。
            </div>
        </div>

        <div class="section-title">ご注文内容</div>

        @php
            use Carbon\Carbon;
            $formattedDateTime = Carbon::parse($purchaseCreatedAt)->format('Y年m月d日 H:i');
        @endphp

        <div class="info">
            <p><strong>ご注文日時：</strong>{{ $formattedDateTime }}</p>
            <p><strong>お支払い方法：</strong>{{ ucfirst($paymentMethod) }}</p>
        </div>

        @foreach ($carts as $uuid => $item)
            <div class="product">
                <div class="product-name">{{ $item['name'] }}</div>
                <div class="product-qty">{{ $item['quantity'] }}個</div>
                <div class="product-price">¥{{ number_format($item['price']) }}</div>
            </div>
            <div class="divider"></div>
        @endforeach

        <div class="total" style="display: flex; justify-content: space-between; font-size: 16px; font-weight: bold; padding: 20px 20px 0 20px;">
            <span>商品合計</span>
            <span>¥{{ number_format($sum) }}</span>
        </div>
        <div class="divider"></div>
        <div class="section-title" style="text-align:left; margin: 20px 20px 0 20px; font-size: 15px; font-weight: bold;">内訳</div>
        <div class="product" style="display: flex; justify-content: space-between; padding: 10px 20px;">
            <span>消費税</span>
            <span>¥{{ number_format($tax) }}</span>
        </div>
        <div class="product" style="display: flex; justify-content: space-between; padding: 10px 20px;">
            <span>送料</span>
            <span>¥{{ number_format($sendPrice) }}</span>
        </div>
        <div class="product" style="display: flex; justify-content: space-between; padding: 10px 20px;">
            <span>使用ポイント</span>
            <span>
                @if ($pointUsage === 'use' && $usedPoints > 0)
                    -¥{{ number_format($usedPoints) }}
                @else
                    0円
                @endif
            </span>
        </div>
        <div class="dotted-line"></div>
        <div class="total" style="display: flex; justify-content: space-between; font-size: 17px; font-weight: bold; padding: 20px;">
            <span>合計</span>
            <span>¥{{ number_format($total) }}</span>
        </div>
        <div class="grant-point" style="font-size: 12px; color: #888; text-align: right; padding: 20px;">
            付与予定ポイント：{{ number_format($grantPoint) }}pt
        </div>

        <div class="divider"></div>

        <div class="delivery">
            <strong>お届け先</strong><br>
            {{ $address->name }}<br>
            〒{{ $address->zipcode }}<br>
            {{ $address->prefectures }} {{ $address->city }} {{ $address->address }} {{ $address->room }}<br>
            TEL：{{ $address->phone }}
        </div>

        <div class="orange-box">
            お問い合わせ<br>
            <p>下記に該当する場合、コールセンターまでお問い合わせください。</p>
            <p>■ご注文内容に誤りがある場合<br>
                ■本メールに心当たりがない方<br>
            </p>
            <div class="notice">
                <strong>コールセンター</strong><br><br>
                0120-123-456<br>
                受付時間：平日9:00～18:00<br>
            </div>
        </div>

        <div class="button-container">
            <a href="{{ url('/') }}" class="button">RecipeMartはこちら</a>
        </div>

        <div class="footer-line"></div>

        <div class="footer">
            <img src="{{ Storage::disk('s3')->url('logo.png') }}" alt="Logo" width="40px">
            <div>© 2024 RecipeMart Co., Ltd.</div>
        </div>
    </div>
</body>
</html>
