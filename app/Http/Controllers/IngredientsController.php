<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;

class IngredientsController extends Controller {

    public function index()
    {
        // 全商品を取得（画像があるものに限定）
        $ingredients = Ingredient::whereNotNull('image_path')->get();

        return view('ingredients.index', compact('ingredients'));
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


}
