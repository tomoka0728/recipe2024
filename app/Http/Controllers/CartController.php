<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\SavedForLater;
use App\Models\PurchaseDetail;
use App\Models\PurchaseHistory;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    // カート数を取得するAPI
    public function getCartCount()
    {
        $carts = session()->get('carts', []);
        return response()->json([
            'success' => true,
            'count' => count($carts)
        ]);
    }

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
        $sendPrice = count($carts) === 0 ? 0 : 500;
        session()->put('sum', $sum);

        $saveForLaterItems = [];

        // ログインしている場合のみデータベースから取得
        if (Auth::check()) {
            $saveForLaterItems = SavedForLater::with('ingredient')
                ->where('user_uuid', Auth::user()->uuid)
                ->get();

        } else {
            // ログインしていない場合はセッションから取得
            $saveForLaterItems = session()->get('saveForLater', []);
        }

        // ビューに変数を渡す
        return view('cart', ['carts' => $carts, 'sum' => $sum, 'sendPrice' => $sendPrice, 'saveForLaterItems' => $saveForLaterItems]);
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
                'price' => $ingredient->sale_price,
                'quantity' => $quantity,
                'image_path' => $ingredient->image_path,
            ];
        }

        session()->put('carts', $carts);

        // ログインしている場合はカートをDBに保存
        if (Auth::check()) {
            $this->saveCartToDatabase(Auth::user());
        }

        Log::info('カートの中身:', session('carts'));

        return response()->json([
            'success' => true,
            'message' => 'カートに追加しました',
            'carts' => $carts,
            'cartCount' => count($carts)
        ]);
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

        // ログインしている場合はDBにも反映
        if (Auth::check()) {
            CartItem::where('user_uuid', Auth::user()->uuid)
                ->where('ingredient_uuid', $ingredientUuid)
                ->update(['quantity' => $quantity]);
        }

        // 合計金額を再計算
        $sum = 0;
        foreach ($carts as $item) {
            $sum += $item['price'] * $item['quantity'];
        }

        // 送料を設定
        $sendPrice = (count($carts) === 0) ? 0 : 500;
        $tax = floor($sum * 0.1);

        return response()->json([
            'success' => true,
            'sum' => $sum,
            'sendPrice' => $sendPrice,
            'tax' => $tax,
            'total' => $sum + $sendPrice + $tax,
            'cartCount' => count($carts)
        ]);
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

        // ログイン中の場合はDBからも削除
        if (Auth::check()) {
            CartItem::where('user_uuid', Auth::user()->uuid)
                ->where('ingredient_uuid', $ingredientUuid)
                ->delete();
        }

        // 合計金額を再計算
        $sum = 0;
        foreach ($carts as $item) {
            $sum += $item['price'] * $item['quantity'];
        }

        // 送料を設定（例: 500円）
        $sendPrice = (count($carts) === 0) ? 0 : 500;
        $tax = floor($sum * 0.1);
        $total = $sum + $sendPrice + $tax;

        // セッションを更新
        session()->put('sum', $sum);

        // リダイレクトまたはJSONレスポンスを返す
        return response()->json([
            'success' => true,
            'sum' => $sum,
            'tax' => $tax,
            'sendPrice' => $sendPrice,
            'total' => $sum + $sendPrice,
            'cartCount' => count($carts)
        ]);
    }

    private function saveCartToDatabase($user)
    {
        $carts = session()->get('carts', []);

        foreach ($carts as $ingredientUuid => $item) {
            $existingItem = CartItem::where('user_uuid', $user->uuid)
                ->where('ingredient_uuid', $ingredientUuid)
                ->first();

            if ($existingItem) {
                $existingItem->quantity = $item['quantity']; // 数量を更新
                $existingItem->save();
            } else {
                CartItem::create([
                    'user_uuid' => $user->uuid,
                    'ingredient_uuid' => $ingredientUuid,
                    'quantity' => $item['quantity'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image_path' => $item['image_path'],
                ]);
            }
        }
    }





    //以下　後で買う機能

    public function saveForLater($ingredientUuid)
    {
        $carts = session()->get('carts', []);

        // 商品がカートに存在する場合
        if (isset($carts[$ingredientUuid])) {
            $quantity = $carts[$ingredientUuid]['quantity'];

            // ここで必ず取得
            $ingredient = Ingredient::where('uuid', $ingredientUuid)->first();
            if (!$ingredient) {
                if (request()->ajax()) {
                    return response()->json(['success' => false, 'message' => '商品が見つかりませんでした'], 404);
                }
                return back()->with('error', '商品が見つかりませんでした');
            }

            if (auth()->check()) {
                $user = auth()->user();
                $exists = SavedForLater::where('user_uuid', $user->uuid)
                    ->where('ingredient_uuid', $ingredientUuid)
                    ->first();

                if (!$exists) {
                    SavedForLater::create([
                        'uuid' => (string) Str::uuid(),
                        'user_uuid' => $user->uuid,
                        'ingredient_uuid' => $ingredientUuid,
                        'quantity' => $quantity,
                    ]);
                }
            } else {
                $saveForLaterItems = session()->get('saveForLater', []);
                if (!isset($saveForLaterItems[$ingredientUuid])) {
                    $saveForLaterItems[$ingredientUuid] = [
                        'name' => $ingredient->name,
                        'price' => $ingredient->price,
                        'image_path' => $ingredient->image_path,
                        'quantity' => $quantity,
                    ];
                    session()->put('saveForLater', $saveForLaterItems);
                }
            }

            // カートから商品を削除
            unset($carts[$ingredientUuid]);
            session()->put('carts', $carts);

            $sum = 0;
            foreach ($carts as $item) {
                $sum += $item['price'] * $item['quantity'];
            }
            if (count($carts) === 0) {
                $sendPrice = 0;
                $tax = 0;
                $total = 0;
            } else {
                $sendPrice = (count($carts) === 0) ? 0 : 500;
                $tax = floor($sum * 0.1);
                $total = $sum + $sendPrice + $tax;
            }
            $sendPrice = (count($carts) === 0) ? 0 : 500;
            $tax = floor($sum * 0.1);
            $total = $sum + $sendPrice + $tax;

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'item' => [
                        'uuid' => $ingredientUuid,
                        'name' => $ingredient->name,
                        'price' => $ingredient->price,
                        'image_path' => Storage::disk('s3')->url($ingredient->image_path),
                        'quantity' => $quantity,
                    ],
                        'sum' => $sum,
                        'tax' => $tax,
                        'sendPrice' => $sendPrice,
                        'total' => $total,
                        'cartCount' => count($carts),
                ]);
            }
            return back()->with('message', '「後で買う」に保存しました');
        }

         if (request()->ajax()) {
            return response()->json(['success' => false, 'message' => '商品がカートに存在しません'], 404);
        }

        return back()->with('error', '商品がカートに存在しません');
    }


    public function showSaveForLater($ingredientUuid)
    {
        $carts = session()->get('carts', []);

        if (isset($carts[$ingredientUuid])) {
            $quantity = $carts[$ingredientUuid]['quantity']; // 数量を取得

            // ログインしている場合
            if (auth()->check()) {
                $user = auth()->user();

                // カートからアイテムを削除
                unset($carts[$ingredientUuid]);
                session()->put('carts', $carts); // セッションを更新

                // 「後で買う」にアイテムを追加
                $exists = SavedForLater::where('user_uuid', $user->uuid)
                    ->where('ingredient_uuid', $ingredientUuid)
                    ->first();

                if (!$exists) {
                    SavedForLater::create([
                        'uuid' => (string) Str::uuid(),
                        'user_uuid' => $user->uuid,
                        'ingredient_uuid' => $ingredientUuid,
                        'quantity' => $quantity, // 数量を保存
                    ]);
                }
            } else {
                // ログインしていない場合はセッションに保存
                $saveForLaterItems = session()->get('saveForLater', []);

                if (!isset($saveForLaterItems[$ingredientUuid])) {
                    $ingredient = Ingredient::where('uuid', $ingredientUuid)->first();
                    if (!$ingredient) {
                        return back()->with('error', '商品が見つかりませんでした');
                    }

                    // セッションに「後で買う」にアイテムを追加
                    $saveForLaterItems[$ingredientUuid] = [
                        'name' => $ingredient->name,
                        'price' => $ingredient->price,
                        'image_path' => $ingredient->image_path,
                        'quantity' => $quantity, // 数量を保存
                    ];

                    session()->put('saveForLater', $saveForLaterItems);
                }
            }

            // カートから商品を削除（ここで再確認）
            unset($carts[$ingredientUuid]);
            session()->put('carts', $carts);

            // リダイレクト
            return redirect()->route('cart.show')->with('message', '「後で買う」に保存しました');
        }

        return redirect()->route('cart.show')->with('error', '商品がカートに存在しません');
    }


    public function moveToCart($ingredientUuid)
    {
        $carts = session()->get('carts', []);

        if (auth()->check()) {
            $user = auth()->user();
            $savedItem = SavedForLater::where('user_uuid', $user->uuid)
                ->where('ingredient_uuid', $ingredientUuid)
                ->first();

            if (!$savedItem) {
                if (request()->ajax()) {
                    return response()->json(['success' => false, 'message' => '商品が見つかりませんでした'], 404);
                }
                return back()->with('error', '商品が見つかりませんでした');
            }

            $ingredient = $savedItem->ingredient;
            if (isset($carts[$ingredientUuid])) {
                $carts[$ingredientUuid]['quantity'] += $savedItem->quantity;
            } else {
                $carts[$ingredientUuid] = [
                    'name' => $ingredient->name,
                    'price' => $ingredient->price,
                    'quantity' => $savedItem->quantity,
                    'image_path' => $ingredient->image_path,
                ];
            }
            session()->put('carts', $carts);
            $savedItem->delete();

            $sum = 0;
            foreach ($carts as $item) {
                $sum += $item['price'] * $item['quantity'];
            }
            if (count($carts) === 0) {
                $sendPrice = 0;
                $tax = 0;
                $total = 0;
            } else {
                $sendPrice = 500;
                $tax = floor($sum * 0.1);
                $total = $sum + $sendPrice + $tax;
            }

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'item' => [
                        'uuid' => $ingredientUuid,
                        'name' => $ingredient->name,
                        'price' => $ingredient->price,
                        'image_path' => Storage::disk('s3')->url($ingredient->image_path),
                        'quantity' => $carts[$ingredientUuid]['quantity'],
                    ],
                    'sum' => $sum,
                    'tax' => $tax,
                    'sendPrice' => $sendPrice,
                    'total' => $total,
                    'cartCount' => count($carts),
                ]);
            }
            return redirect()->route('cart.show')->with('message', 'カートに移動しました');
        } else {
            $saveForLaterItems = session()->get('saveForLater', []);
            if (!isset($saveForLaterItems[$ingredientUuid])) {
                if (request()->ajax()) {
                    return response()->json(['success' => false, 'message' => '商品が見つかりませんでした'], 404);
                }
                return back()->with('error', '商品が見つかりませんでした');
            }
            $item = $saveForLaterItems[$ingredientUuid];
            if (isset($carts[$ingredientUuid])) {
                $carts[$ingredientUuid]['quantity'] += $item['quantity'];
            } else {
                $carts[$ingredientUuid] = [
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'image_path' => $item['image_path'],
                ];
            }
            session()->put('carts', $carts);
            unset($saveForLaterItems[$ingredientUuid]);
            session()->put('saveForLater', $saveForLaterItems);

            $sum = 0;
            foreach ($carts as $item) {
                $sum += $item['price'] * $item['quantity'];
            }
            if (count($carts) === 0) {
                $sendPrice = 0;
                $tax = 0;
                $total = 0;
            } else {
                $sendPrice = 500;
                $tax = floor($sum * 0.1);
                $total = $sum + $sendPrice + $tax;
            }

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'item' => [
                        'uuid' => $ingredientUuid,
                        'name' => $item['name'],
                        'price' => $item['price'],
                        'image_path' => Storage::disk('s3')->url($item['image_path']),
                        'quantity' => $carts[$ingredientUuid]['quantity'],
                    ],
                    'sum' => $sum,
                    'tax' => $tax,
                    'sendPrice' => $sendPrice,
                    'total' => $total,
                    'cartCount' => count($carts),
                ]);
            }
            return redirect()->route('cart.show')->with('message', 'カートに移動しました');
        }
    }

    public function removeSaveForLater($ingredientUuid)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $savedItem = SavedForLater::where('user_uuid', $user->uuid)
                ->where('ingredient_uuid', $ingredientUuid)
                ->first();

            if ($savedItem) {
                $savedItem->delete();
                return response()->json(['success' => true, 'message' => '「後で買う」から削除しました']);
            } else {
                return response()->json(['success' => false, 'message' => '商品が見つかりませんでした'], 404);
            }
        } else {
            $saveForLaterItems = session()->get('saveForLater', []);
            if (isset($saveForLaterItems[$ingredientUuid])) {
                unset($saveForLaterItems[$ingredientUuid]);
                session()->put('saveForLater', $saveForLaterItems);
                return response()->json(['success' => true, 'message' => '「後で買う」から削除しました']);
            } else {
                return response()->json(['success' => false, 'message' => '商品が見つかりませんでした'], 404);
            }
        }
    }
}
