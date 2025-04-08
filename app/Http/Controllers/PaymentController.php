<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\CardException;
use Illuminate\Support\Str;


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


    // 購入確認画面を表示
    public function confirm(Request $request)
    {
        // カート情報
        $carts = session()->get('carts', []);
        $sum = array_reduce($carts, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        $sendPrice = session()->get('sendPrice', 500);
 
        $user = Auth::user();
        $userPoints = $user->points;

        // 住所の取得（セッションに保存された住所 or 最新の登録住所）
        $sessionAddress = session()->get('address_data');
        $defaultAddress = $user->addresses()->latest()->first();
        $address = $sessionAddress ?? $defaultAddress;
        
        //支払い方法を取得
        $paymentMethod = session()->get('payment-method', 'クレジットカード');

        // ユーザーのポイント使用処理
        $pointUsage = session()->get('pointUsage', 'not_use');
        $usedPoints = session()->get('usedPoints', 0);

        if ($pointUsage === 'use') {
            // 使用可能なポイントの範囲内で使用
            $usedPoints = min($usedPoints, $userPoints, $sum + $sendPrice);
        } else {
            $usedPoints = 0;
        }

        \Log::info('セッションから取得した住所データ:', session()->get('address_data') ?? []);
        \Log::info('デフォルトの住所データ:', $defaultAddress ? $defaultAddress->toArray() : []);

        if (!$address) {
            \Log::warning('住所情報が取得できませんでした。');
            return back()->withErrors(['address' => '住所情報が見つかりません。登録してください。']);
        }

        $total = max(0, $sum + $sendPrice - $usedPoints);

        // デバッグ用ログ
        \Log::info('セッションに保存する住所データ:', $request->only(['zipcode', 'prefectures', 'city', 'address', 'room', 'phone']));
        \Log::info('セッションデータ:', session()->all());
        \Log::info('取得した住所情報:', $address ? (is_object($address) ? $address->toArray() : $address) : []);
        \Log::info('取得したポイント情報:', ['pointUsage' => $pointUsage, 'usedPoints' => $usedPoints, 'userPoints' => $userPoints]);

        return view('payment-confirm', compact(
            'carts', 'sum', 'sendPrice', 'total', 'usedPoints', 'pointUsage', 'address', 'paymentMethod', 'userPoints'
        ));
    }

        public function checkout()
        {
            $carts = session()->get('carts', []);
            $sum = array_reduce($carts, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
            $sendPrice = session()->get('sendPrice', 500);
            
            $user = Auth::user();
            $userPoints = $user->points;
            $usedPoints = session()->get('usedPoints', 0);
            $pointUsage = session()->get('pointUsage', 'not_use');

            if ($pointUsage === 'use') {
                $usedPoints = min($usedPoints, $userPoints, $sum + $sendPrice);
            } else {
                $usedPoints = 0;
            }

            $total = max(0, $sum + $sendPrice - $usedPoints);
            
            if ($total <= 0) {
                return back()->withErrors(['error' => '決済金額が無効です。']);
            }

            Stripe::setApiKey(config('services.stripe.secret'));

            $lineItems = [];
            foreach ($carts as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => round($item['price'] * 100), // Stripeは最小単位で扱う（例: 100円 -> 10000）
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            // 送料を追加
            if ($sendPrice > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => '送料',
                        ],
                        'unit_amount' => $sendPrice * 100,
                    ],
                    'quantity' => 1,
                ];
            }

            \Log::info('Stripeに送信する金額:', [
                'line_items' => $lineItems,
                'total' => $total,
            ]);

            try {
                $checkoutSession = StripeSession::create([
                    'payment_method_types' => ['card'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => route('payment.cancel'),
                ]);
                
                return redirect($checkoutSession->url);
            } catch (Exception $e) {
                \Log::error('Stripe セッションエラー: ' . $e->getMessage());
                return back()->withErrors(['error' => '決済処理に失敗しました。']);
            }

            return redirect()->route('payment.checkout')->with('message', '購入が完了しました。');
        }


        public function cancel()
        {
            \Log::info('決済がキャンセルされました。');
            return view('payment-cancel')->withErrors(['error' => '決済がキャンセルされました。']);
        }

        public function success(Request $request)
        {
            // Stripe セッション ID を取得
            $sessionId = $request->query('session_id');

            // 必要に応じてセッション ID を使った処理を追加
            \Log::info('決済成功: セッションID ' . $sessionId);

            // カート情報を取得
            $carts = session()->get('carts', []);
            $sendPrice = session()->get('sendPrice', 0);
            $usedPoints = session()->get('usedPoints', 0);
            $pointUsage = session()->get('pointUsage', 'not_use');
            $user = Auth::user();

            // 合計金額を計算
            $sum = array_reduce($carts, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
            $total = max(0, $sum + $sendPrice - $usedPoints);
            \Log::info('カートの内容: ', $carts);
            DB::beginTransaction();

            try {
                // 購入履歴を登録
                $purchaseUuid = Str::uuid()->toString();
                DB::table('purchase_history')->insert([
                    'uuid' => $purchaseUuid,
                    'user_uuid' => $user->uuid,
                    'total_price' => $total,
                    'purchased_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
        
                // 購入詳細を登録
                foreach ($carts as $uuid => $item) {
                    DB::table('purchase_details')->insert([
                        'uuid' => Str::uuid()->toString(),
                        'purchase_uuid' => $purchaseUuid,
                        'ingredient_uuid' => $uuid,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // 商品の累計購入数を更新
                    DB::table('ingredients')
                    ->where('uuid', $uuid)
                    ->increment('total_purchased', $item['quantity']);
                }

                DB::commit();

                // カート関連のセッションデータを削除
                session()->forget('carts');
                session()->forget('sendPrice');
                session()->forget('usedPoints');
                session()->forget('pointUsage');

                \Log::info('購入履歴と詳細を登録しました。');

                return view('payment-success')->with('message', '決済が成功しました！');
            } catch (\Exception $e) {
                // トランザクションをロールバック
                DB::rollBack();
        
                \Log::error('購入履歴登録中にエラーが発生しました: ' . $e->getMessage());
        
                return back()->withErrors(['error' => '購入履歴の登録中にエラーが発生しました。']);
            }
        }
}

    