<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\Recipe;
use App\Models\RCategory;
use Illuminate\Support\Facades\Auth;

class IngredientsController extends Controller {

    public function index(Request $request)
    {
        // ページごとの表示件数（デフォルトは 40 件）
        $perPage = $request->input('per_page', 40);
        // 並び替えのデフォルトは新着順
        $sort = $request->input('sort', 'newest');
        // 検索キーワード
        $search = $request->input('search');
        // 検索タイプ
        $searchType = $request->input('search_type', 'ingredient');
        // ベースクエリ作成
        if ($searchType === 'recipe') {
            $query = Recipe::query();
        } else {
            $query = Ingredient::query();
            $query->where('price', '>', 0);
        }

        // 並び替え条件
        if ($sort === 'bestselling') {
            // 売れ筋順（total_purchasedで並べ替え）
            $query->orderByDesc('total_purchased');
        } elseif ($sort === 'newest') {
            // 新着順
            $query->orderByDesc('created_at');
        } else {
            // デフォルトでは新着順
            $query->orderByDesc('created_at');
        }

        // 検索キーワードが存在する場合
        if ($request->has('search') && $request->filled('search')) {
            $keyword = $request->input('search');

            // ひらがな・カタカナをひらがなに変換
            $keyword = mb_convert_kana($keyword, 'c', 'UTF-8');  // カタカナをひらがなに変換
            
            // 検索キーワードを使用してDB検索
            $query->where('name', 'like', '%' . $keyword . '%');
        }


        // 結果を取得
        $ingredients = $query->paginate($perPage);

        return view('ingredients.index', compact('ingredients', 'sort', 'perPage'));
    }

    public function show($uuid)
    {
        $ingredient = Ingredient::where('uuid', $uuid)->firstOrFail();
        $recipes = $ingredient->recipes()->limit(8)->get();

        return view('ingredients.show', compact('ingredient', 'recipes'));
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

     public function search(Request $request)
    {
        $searchType = $request->input('search_type');
        $keyword = $request->input('search');

        // 食材が選択されたときのみ検索
        if ($searchType === 'ingredient') {
            if (!empty($keyword)) {
                $ingredients = Ingredient::where('name', 'like', '%' . $keyword . '%')->get();
            } else {
                // キーワードが空なら全ての食材
                $ingredients = Ingredient::all();
            }

            return view('ingredient.index', compact('ingredients'));
        }

        // 他の検索タイプ（例:レシピ）は今後対応
        return redirect()->back()->with('error', '検索タイプが無効です');
    }


}
