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
                ->get();

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
                ->get();

            return view('ranking', [
                'title' => $category->name . 'ランキング',
                'ingredients' => $ingredients,
            ]);
        }

        // カテゴリーが見つからなかった場合
        return redirect()->route('ranking.show', ['sougou']);
    }
}
