<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // カートの内容を表示
    public function show()
    {
        $carts = session()->get('carts', []);

        // 合計金額の計算
        $sum = 0;
        foreach ($carts as $item) {
            $sum += $item['price'] * $item['quantity'];
    }

    // 送料（例として仮に500円）
    $sendPrice = 500;
    session()->put('sum', $sum);
    session()->put('sendPrice', $sendPrice);

    // ビューに変数を渡す
    return view('cart', ['carts' => $carts, 'sum' => $sum, 'sendPrice' => $sendPrice]);
    }

    // カートに商品を追加
    public function add(Request $request)
    {
        $ingredientUuid = $request->input('ingredientUuid');
        $quantity = $request->input('num');

        $carts = session()->get('carts', []);

        // すでにカートにあるなら数量を増やす
        if (isset($carts[$ingredientUuid])) {
            $carts[$ingredientUuid]['quantity'] += $quantity;
        } else {
            // 新しくカートに追加
            $ingredient = Ingredient::where('uuid', $ingredientUuid)->first();
            if (!$ingredient) {

                return response()->json(['message' => 'リクエストが不正です'], 400);
            }

            $carts[$ingredientUuid] = [
                'name' => $ingredient->name,
                'price' => $ingredient->price,
                'quantity' => $quantity,
                'image_path' => $ingredient->image_path,
            ];
        }

        session()->put('carts', $carts);

        Log::info('カートの中身:', session('carts'));

        return response()->json(['carts'=> $carts]);
    }



    // カートに保存されている商品の数量を更新
    public function update(Request $request)
    {
        $ingredientUuid = $request->input('ingredientUuid');
        $quantity = $request->input('quantity');

        $carts = session()->get('carts', []);
        if (isset($carts[$ingredientUuid])) {
            $carts[$ingredientUuid]['quantity'] = $quantity;
            session()->put('carts', $carts);
        }

        // 合計金額を再計算
        $sum = 0;
        foreach ($carts as $item) {
            $sum += $item['price'] * $item['quantity'];
        }

        // 送料を設定（例: 500円）
        $sendPrice = session()->get('sendPrice', 500);

        // セッションを更新
        session()->put('sum', $sum);
        session()->put('sendPrice', $sendPrice);

        return response()->json(['success' => true, 'sum' => $sum, 'sendPrice' => $sendPrice, 'total' => $sum + $sendPrice]);
    }



    // カートから商品を削除
    public function remove($ingredientUuid)
    {
        \Log::info('削除リクエストを受信しました: ' . $ingredientUuid);
        // カート情報を取得
        $carts = session()->get('carts', []);

        // 指定された商品を削除
        if (isset($carts[$ingredientUuid])) {
            unset($carts[$ingredientUuid]);
            session()->put('carts', $carts); // セッションを更新
        }

        // 合計金額を再計算
        $sum = 0;
        foreach ($carts as $item) {
            $sum += $item['price'] * $item['quantity'];
        }

        // 送料を設定（例: 500円）
        $sendPrice = session()->get('sendPrice', 500);

        // セッションを更新
        session()->put('sum', $sum);

        // リダイレクトまたはJSONレスポンスを返す
        return response()->json(['success' => true, 'sum' => $sum, 'sendPrice' => $sendPrice, 'total' => $sum + $sendPrice]);
    }
}
