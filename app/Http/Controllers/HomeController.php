<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RCategory;
use App\Models\Ingredient;
use App\Models\RecipeCategory;
use App\Models\RecipeIngredient;

class HomeController extends Controller
{
    public function index()
    {
        // ブックマーク数でソート（withCount使用）
        $popularRecipes = Recipe::withCount('savedItems')
            ->orderBy('saved_items_count', 'desc')
            ->take(3)
            ->get();
        $categories = RCategory::orderBy('category_id')->get()->groupBy('group');

        $groupImages = [
        '肉' => 'meat.png',
        '魚介' => 'seafood.png',
        'ご飯もの' => 'rice.png',
        '麺' => 'noodl.png',
        'サラダ' => 'salad.png',
        'スープ' => 'soup.png',
        '副菜' => 'side.png',
        'パーティー' => 'party.png',
        ];

        // 旬の野菜レシピ特集用
        $currentMonth = date('n'); // 1〜12
        $seasonalRecipes = Recipe::whereHas('ingredients', function($q) use ($currentMonth) {
            $q->whereHas('categories', function($q2) {
                $q2->where('name', '野菜');
            })
            ->whereJsonContains('seasonality', $currentMonth)
            // 旬が設定されていない（空配列）または全月選択（1-12全て）を除外
            ->whereRaw('JSON_LENGTH(seasonality) > 0')
            ->whereRaw('JSON_LENGTH(seasonality) < 12');
        })
        ->take(6)
        ->get();

        // 取得したレシピをビューに渡す
        return view('top', compact('popularRecipes', 'groupImages', 'categories', 'seasonalRecipes'));
    }
}
