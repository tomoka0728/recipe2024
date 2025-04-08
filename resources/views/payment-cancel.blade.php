<!DOCTYPE html>
<html>
<head>
    <title>決済キャンセル</title>
</head>
<body>
    <h1>決済がキャンセルされました</h1>
    <p>{{ $errors->first('error') }}</p>
    <a href="{{ route('payment.show') }}">ホームに戻る</a>
</body>
</html>