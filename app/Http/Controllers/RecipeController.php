<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\RCategory;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function show($uuid)
    {
        // uuidでレシピを取得し、関連する材料と手順も取得
        $recipe = Recipe::with(['recipeIngredients.ingredient', 'steps'])
                ->where('uuid', $uuid)
                ->firstOrFail();

        $recipe->steps = $recipe->steps->sortBy('step_number');

        foreach ($recipe->recipeIngredients as $recipeIngredient) {
            if ($recipeIngredient->ingredient) {
                // ingredient_id が DB に存在するかチェック
                $recipeIngredient->ingredient->exists_in_db = Ingredient::where('uuid', $recipeIngredient->ingredient->id)->exists();
            }
        }

        return view('recipes.show', compact('recipe'));
    }

    public function index(Request $request)
    {
        // ページごとの表示件数（デフォルトは 20 件）
        $perPage = $request->input('per_page', 20);
        // 並び替えのデフォルトは新着順
        $sort = $request->input('sort', 'newest');
        // 検索キーワード
        $search = $request->input('search'); 
        // 検索タイプ
        $searchType = $request->input('search_type', 'recipe');
        // ベースクエリ作成
        if ($searchType === 'recipe') {
            $recipesQuery = Recipe::query();
        } else {
            $recipesQuery = Ingredient::query();
        }

        // ユーザーがシルバー会員以上の場合、"お気に入りが多い順" を選べる
        if (Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value) {
            $recipesQuery = Recipe::query();
            // 並び替え条件
            if ($sort === 'favorites') {
                $recipesQuery->orderBy('favorite_count', 'desc');
            } else {
                $recipesQuery->orderBy('created_at', 'desc'); // 新着順
            }
        } else {
            $recipesQuery = Recipe::orderBy('created_at', 'desc'); // 新着順
        }

        // 検索キーワードがある場合
        if (!empty($search)) {
            $normalized = mb_convert_kana($search, 'c', 'UTF-8'); // カタカナ→ひらがな
            if ($searchType === 'recipe') {
                $recipesQuery->where('title', 'like', '%' . $normalized . '%');
            } else {
                $recipesQuery->where('name', 'like', '%' . $normalized . '%');
            }
        }

        // レシピを取得
        $recipes = $recipesQuery->paginate($perPage);

        // レシピカテゴリ一覧取得
        $recipeCategories = RCategory::where('category_id', '<=', 12)
                                  ->orderBy('category_id', 'asc')
                                  ->get();

        return view('recipes.index', compact('recipes', 'recipeCategories', 'sort', 'perPage'));
    }

    public function category(Request $request, $categoryUuid)
    {
        $perPage = $request->input('per_page', 20);
        // カテゴリを取得
        $selectedCategory = RCategory::findOrFail($categoryUuid);

        // カテゴリに関連するレシピを取得
        $recipes = Recipe::whereHas('categories', function ($query) use ($categoryUuid) {
            $query->where('r_category_uuid', $categoryUuid);  // カテゴリUUIDで絞り込み
        })
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);

        // 他のカテゴリー一覧
        $recipeCategories = RCategory::where('category_id', '<=', 12)
                                    ->orderBy('category_id', 'asc')
                                    ->get();

        return view('recipes.index', compact('recipes', 'recipeCategories', 'selectedCategory'));
    }
}
