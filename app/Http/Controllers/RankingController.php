<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\ICategory;


class RankingController extends Controller
{
    public function show($categoryId = null)
    {
        // 総合ランキング（categoryId が null または 'sougou' の場合）
        if ($categoryId === null || $categoryId === 'sougou') {
            $ingredients = Ingredient::whereNotNull('image_path')
                ->orderByDesc('total_purchased')
                ->paginate(15);

            return view('ranking', [
                'title' => '総合ランキング',
                'ingredients' => $ingredients,
            ]);
        }

        // カテゴリーIDから名前を取得
        $category = \App\Models\ICategory::where('i_category_id', $categoryId)->first();

        // カテゴリーが見つかった場合
        if ($category) {
            $ingredients = Ingredient::whereNotNull('image_path')
                ->whereHas('categories', function ($q) use ($category) {
                    $q->where('i_categories.uuid', $category->uuid); // 明示的にテーブル名を指定
                })
                ->orderByDesc('total_purchased')
                ->paginate(15);

            return view('ranking', [
                'title' => $category->name . 'ランキング',
                'ingredients' => $ingredients,
            ]);
        }

        // カテゴリーが見つからなかった場合
        return redirect()->route('ranking.show', ['sougou']);
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

        Log::info('カートの中身:', session('carts'));

        return response()->json(['carts'=> $carts]);
    }

}
