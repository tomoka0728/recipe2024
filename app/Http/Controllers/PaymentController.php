<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;

class PaymentController extends Controller
{
    // カートの内容を表示
    public function show()
    {
        $carts = session()->get('carts', []);
        $sum = 0;

        // 商品合計を再計算
        foreach ($carts as $item) {
            $sum += $item['price'] * $item['quantity'];
        }

        // 送料を取得（デフォルト値を設定）
        $sendPrice = session()->get('sendPrice', 500);

        // セッションを更新
        session()->put('sum', $sum);

    // ビューに変数を渡す
    return view('payment', ['carts' => $carts, 'sum' => $sum, 'sendPrice' => $sendPrice]);
    }

}
