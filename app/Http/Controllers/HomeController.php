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
        $popularRecipes = Recipe::orderBy('favorite_count', 'desc')->take(3)->get();
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
            ->whereJsonContains('seasonality', $currentMonth);
        })
        ->take(6)
        ->get();

        // 取得したレシピをビューに渡す
        return view('top', compact('popularRecipes', 'groupImages', 'categories', 'seasonalRecipes'));
    }
}
