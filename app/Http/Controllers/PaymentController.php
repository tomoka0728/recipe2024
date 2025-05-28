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
use App\Mail\PurchaseReceived;
use Illuminate\Support\Facades\Mail;


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

        // 消費税（10%）
        $tax = floor(($sum + $sendPrice) * 0.1);

        // 合計
        $total = $sum + $sendPrice + $tax;

        // セッションを更新
        session()->put('sum', $sum);

    // ビューに変数を渡す
    return view('payment', ['carts' => $carts, 'sum' => $sum, 'tax' => $tax, 'sendPrice' => $sendPrice]);
    }


    // 購入確認画面を表示
    public function confirm(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'address_type' => 'required|in:existing,new',
            'existing_address_id' => 'required_if:address_type,existing|exists:addresses,uuid',
            'name' => 'required_if:address_type,new|string|max:255',
            'zipcode' => ['required_if:address_type,new', 'regex:/^\d{7}$/'],
            'prefectures' => 'required_if:address_type,new|string|max:255',
            'city' => 'required_if:address_type,new|string|max:255',
            'address' => 'required_if:address_type,new|string|max:255',
            'room' => 'nullable|string|max:255',
            'phone' => ['required_if:address_type,new', 'regex:/^\d{10,11}$/'],
            'method' => 'required|string',
            'point' => 'required|in:use,not_use',
            'use_point' => 'nullable|integer|min:0',
        ]);

        // 住所情報のセッション保存
        if ($request->input('address_type') === 'existing') {
            session()->put('selected_address_id', $request->input('existing_address_id'));
            session()->forget('address_data');
        } else {
            session()->put('address_data', $request->only(['name','zipcode', 'prefectures', 'city', 'address', 'room', 'phone']));
            session()->forget('selected_address_id');
        }

        // 支払い方法・ポイント利用のセッション保存
        session()->put('payment-method', $request->input('method'));
        session()->put('pointUsage', $request->input('point'));
        session()->put('usedPoints', $request->input('use_point', 0));

        // カート情報
        $carts = session()->get('carts', []);
        $sum = array_reduce($carts, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        $sendPrice = session()->get('sendPrice', 500);
        $tax = floor($sum * 0.1);

        $user = Auth::user();
        $userPoints = $user->points;

        // ポイント利用
        $pointUsage = session()->get('pointUsage', 'not_use');
        $usedPoints = session()->get('usedPoints', 0);
        if ($pointUsage === 'use') {
            $usedPoints = min($usedPoints, $userPoints, $sum + $tax + $sendPrice);
        } else {
            $usedPoints = 0;
        }

        // 合計
        $total = max(0, $sum + $tax + $sendPrice - $usedPoints);

        session()->put('pointUsage', $pointUsage);
        session()->put('usedPoints', $usedPoints);

        // 住所の取得
        $sessionAddress = session()->get('address_data');
        $selectedAddressId = session()->get('selected_address_id');
        $defaultAddress = $user->addresses()->latest()->first();

        if ($selectedAddressId) {
            // 既存住所を選択した場合
            $address = $user->addresses()->find($selectedAddressId);
        } elseif ($sessionAddress) {
            // 新規住所入力の場合
            $address = $sessionAddress;
        } else {
            $address = $defaultAddress;
        }

        //支払い方法を取得
        $paymentMethod = session()->get('payment-method', 'クレジットカード');

        if (!$address) {
            \Log::warning('住所情報が取得できませんでした。');
            return back()->withErrors(['address' => '住所情報が見つかりません。登録してください。']);
        }

        $total = max(0, $sum + $sendPrice - $usedPoints);

        // 付与予定ポイント計算（送料を除いた商品合計＋消費税が対象）
        $baseForPoint = $sum + $tax;
        switch ($user->rank) {
            case 'gold':
                $pointRate = 0.05;
                break;
            case 'silver':
                $pointRate = 0.03;
                break;
            default:
                $pointRate = 0.01;
                break;
        }
        $grantPoint = floor($baseForPoint * $pointRate);

        // デバッグ用ログ
        \Log::info('セッションに保存する住所データ:', $request->only(['name', 'zipcode', 'prefectures', 'city', 'address', 'room', 'phone']));
        \Log::info('セッションデータ:', session()->all());
        \Log::info('取得した住所情報:', $address ? (is_object($address) ? $address->toArray() : $address) : []);
        \Log::info('取得したポイント情報:', ['pointUsage' => $pointUsage, 'usedPoints' => $usedPoints, 'userPoints' => $userPoints]);
        \Log::info('ポイント利用:', ['pointUsage' => $pointUsage, 'usedPoints' => $usedPoints]);

        return view('payment-confirm', compact(
            'carts', 'sum', 'sendPrice', 'tax', 'total', 'usedPoints', 'pointUsage', 'address', 'paymentMethod', 'userPoints', 'grantPoint'
        ));
    }

        public function checkout()
        {
            // カート情報
            $carts = session()->get('carts', []);
            $sum = array_reduce($carts, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
            $sendPrice = session()->get('sendPrice', 500);
            $tax = floor($sum * 0.1);

            $user = Auth::user();
            $userPoints = $user->points;

            // ポイント利用
            $pointUsage = session()->get('pointUsage', 'not_use');
            $usedPoints = session()->get('usedPoints', 0);
            if ($pointUsage === 'use') {
                $usedPoints = min($usedPoints, $userPoints, $sum + $tax + $sendPrice);
            } else {
                $usedPoints = 0;
            }

            // 合計
            $total = max(0, $sum + $tax + $sendPrice - $usedPoints);

            if ($total <= 0) {
                return back()->withErrors(['error' => '決済金額が無効です。']);
            }

            $total = max(0, $sum + $tax + $sendPrice - $usedPoints);

            Stripe::setApiKey(config('services.stripe.secret'));

            $lineItems = [];
            foreach ($carts as $item) {
                $itemTax = floor($item['price'] * 0.1); // 商品ごとの消費税
                $itemTotal = $item['price'] + $itemTax; // 商品ごとの税込価格
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => (int)$itemTotal,
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
                        'unit_amount' => $sendPrice,
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

                // 決済成功後にポイント減算
                if ($usedPoints > 0) {
                    $user->points -= $usedPoints;
                    $user->save();
                }

                // ポイント利用明細を登録
                \App\Models\PointHistory::create([
                    'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                    'user_uuid' => $user->uuid,
                    'points' => $usedPoints, // 使用ポイント数
                    'type' => 'used',        // 使用
                    'description' => 'ポイント利用',
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
            \Log::info('決済成功: セッションID ' . $sessionId);

            // カート情報
            $carts = session()->get('carts', []);
            $sum = array_reduce($carts, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
            $sendPrice = session()->get('sendPrice', 500);
            $tax = floor($sum * 0.1);

            $user = Auth::user();
            $userPoints = $user->points;

            // ポイント利用
            $pointUsage = session()->get('pointUsage', 'not_use');
            $usedPoints = session()->get('usedPoints', 0);
            if ($pointUsage === 'use') {
                $usedPoints = min($usedPoints, $userPoints, $sum + $tax + $sendPrice);
            } else {
                $usedPoints = 0;
            }

            // 合計
            $total = max(0, $sum + $tax + $sendPrice - $usedPoints);

            $paymentMethod = session()->get('payment-method', 'クレジットカード');

            // 住所情報の取得
            $addressId = session()->get('selected_address_id');
            $addressData = session()->get('address_data');

            \Log::info('カートの内容: ', $carts);
            DB::beginTransaction();

            try {
                // 住所の保存または取得
                if ($addressId) {
                    // 既存住所を利用
                    $address = $user->addresses()->find($addressId);
                    if (!$address) {
                        throw new \Exception('選択された住所が見つかりません。');
                    }
                } elseif ($addressData) {
                    // 新規住所を保存
                    $addressUuid = Str::uuid()->toString();
                    $address = $user->addresses()->create([
                        'uuid'        => $addressUuid,
                        'name'        => $addressData['name'] ?? '',
                        'zipcode'     => $addressData['zipcode'] ?? '',
                        'prefectures' => $addressData['prefectures'] ?? '',
                        'city'        => $addressData['city'] ?? '',
                        'address'     => $addressData['address'] ?? '',
                        'room'        => $addressData['room'] ?? '',
                        'phone'       => $addressData['phone'] ?? '',
                    ]);
                } else {
                    throw new \Exception('住所情報がありません。');
                }

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
                $purchaseCreatedAt = now();
                foreach ($carts as $uuid => $item) {
                    DB::table('purchase_details')->insert([
                        'uuid' => Str::uuid()->toString(),
                        'purchase_uuid' => $purchaseUuid,
                        'ingredient_uuid' => $uuid,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'created_at' => $purchaseCreatedAt,
                        'updated_at' => $purchaseCreatedAt,
                    ]);

                    // 商品の累計購入数を更新
                    DB::table('ingredients')
                    ->where('uuid', $uuid)
                    ->increment('total_purchased', $item['quantity']);
                }

                DB::commit();

                // 付与ポイント計算
                $baseForPoint = $sum + $tax;
                switch ($user->rank) {
                    case 'gold':
                        $pointRate = 0.05;
                        break;
                    case 'silver':
                        $pointRate = 0.03;
                        break;
                    default:
                        $pointRate = 0.01;
                        break;
                }
                $grantPoint = floor($baseForPoint * $pointRate);

                // ユーザーにポイント付与
                if ($grantPoint > 0) {
                    $user->points += $grantPoint;
                    $user->save();
                }

                \App\Models\PointHistory::create([
                    'uuid' => \Illuminate\Support\Str::uuid()->toString(),
                    'user_uuid' => $user->uuid,
                    'points' => $grantPoint, // 付与ポイント数（正の値）
                    'type' => 'earned',      // 獲得
                    'description' => '商品購入時のポイント還元',
                ]);

                // メール送信前にキャスト
                $sum = (int)$sum;
                $tax = (int)$tax;
                $sendPrice = (int)$sendPrice;
                $usedPoints = (int)$usedPoints;
                $total = (int)$total;
                $grantPoint = (int)$grantPoint;

                // メール送信
                Mail::to($user->email)->send(new PurchaseReceived(
                        $user,
                        $carts,
                        $address,
                        $sendPrice,      // int
                        $usedPoints,     // int
                        $pointUsage,     // string
                        $total,          // int
                        $sum,            // int
                        $tax,            // int
                        $paymentMethod,  // string
                        $purchaseCreatedAt,
                        $grantPoint
                ));

                // カート関連のセッションデータを削除
                session()->forget('carts');
                session()->forget('sendPrice');
                session()->forget('usedPoints');
                session()->forget('pointUsage');

                \Log::info('購入履歴・詳細・住所を登録しました。');
                \Log::info('メールを送信しました。');

                return view('payment-success')->with('message', '決済が成功しました！');
            } catch (\Exception $e) {
                // トランザクションをロールバック
                DB::rollBack();

                \Log::error('購入履歴登録中にエラーが発生しました: ' . $e->getMessage());

                return back()->withErrors(['error' => '購入履歴の登録中にエラーが発生しました。']);
            }
        }
}

