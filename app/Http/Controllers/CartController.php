<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\SavedItem;
use App\Models\PurchaseDetail;
use App\Models\PurchaseHistory;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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

        $saveForLaterItems = [];

        // ログインしている場合のみデータベースから取得
        if (Auth::check()) {
            $saveForLaterItems = SavedItem::with('ingredient')
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
                'price' => $ingredient->price,
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
        $sendPrice = session()->get('sendPrice', 500);

        // セッションを更新
        session()->put('sum', $sum);

        // リダイレクトまたはJSONレスポンスを返す
        return response()->json(['success' => true, 'sum' => $sum, 'sendPrice' => $sendPrice, 'total' => $sum + $sendPrice]);
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

            // ログインしている場合
            if (auth()->check()) {
                $user = auth()->user();

                // 「後で買う」アイテムがすでに存在するか確認
                $exists = SavedItem::where('user_uuid', $user->uuid)
                    ->where('ingredient_uuid', $ingredientUuid)
                    ->first();

                if (!$exists) {
                    SavedItem::create([
                        'uuid' => (string) Str::uuid(),
                        'user_uuid' => $user->uuid,
                        'ingredient_uuid' => $ingredientUuid,
                        'quantity' => $quantity,
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

            return back()->with('message', '「後で買う」に保存しました');
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
                $exists = SavedItem::where('user_uuid', $user->uuid)
                    ->where('ingredient_uuid', $ingredientUuid)
                    ->first();

                if (!$exists) {
                    SavedItem::create([
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


    public function moveToCart($uuid)
    {
        \Log::debug('moveToCart called', ['uuid' => $uuid]);

        $carts = session()->get('carts', []);
        
        if (auth()->check()) {
            \Log::debug('User logged in', ['user_uuid' => auth()->user()->uuid]);

            $user = auth()->user();

            // saved_items テーブルから該当商品を取得
            $savedItem = SavedItem::where('user_uuid', $user->uuid)
                ->where('ingredient_uuid', $uuid)
                ->first();

            if (!$savedItem) {
                return back()->with('error', '商品が見つかりませんでした');
            }

            $ingredient = $savedItem->ingredient;

            // カートにアイテムを追加または数量を加算
            if (isset($carts[$uuid])) {
                // すでにカートにある場合は数量を加算
                $carts[$uuid]['quantity'] += $savedItem->quantity;
            } else {
                // カートにアイテムを追加
                $carts[$uuid] = [
                    'name' => $ingredient->name,
                    'price' => $ingredient->price,
                    'quantity' => $savedItem->quantity,
                    'image_path' => $ingredient->image_path,
                ];
            }

            // カートをセッションに保存
            session()->put('carts', $carts);

            // saved_items テーブルから削除
            $savedItem->delete();

            return redirect()->route('cart.show')->with('message', 'カートに移動しました');
        } else {
            // ログインしていない場合はセッションから処理
            $saveForLaterItems = session()->get('saveForLater', []);

            if (!isset($saveForLaterItems[$uuid])) {
                return back()->with('error', '商品が見つかりませんでした');
            }

            $item = $saveForLaterItems[$uuid];

            // カートにアイテムを追加または数量を加算
            if (isset($carts[$uuid])) {
                $carts[$uuid]['quantity'] += $item['quantity'];
            } else {
                $carts[$uuid] = [
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'image_path' => $item['image_path'],
                ];
            }

            // カートをセッションに保存
            session()->put('carts', $carts);

            // 「後で買う」リストから削除
            unset($saveForLaterItems[$uuid]);
            session()->put('saveForLater', $saveForLaterItems);

            return redirect()->route('cart.show')->with('message', 'カートに移動しました');
        }
    }
}