<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\RCategory;
use App\Models\SavedItem;
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

        // ブックマーク状態をチェック
        $isBookmarked = false;
        if (Auth::check()) {
            $isBookmarked = SavedItem::where('user_uuid', Auth::id())
                ->where('item_type', Recipe::class)
                ->where('item_uuid', $uuid)
                ->exists();
        }

        return view('recipes.show', compact('recipe', 'isBookmarked'));
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
        // カテゴリUUID
        $categoryUuid = $request->input('category');
        // カテゴリUUIDが指定されている場合、カテゴリで絞り込み
        $recipesQuery = Recipe::query();
        // ベースクエリ作成（レシピのみ対応例）
        if ($searchType === 'recipe') {
            $recipesQuery = Recipe::query();
        } else {
            $recipesQuery = Ingredient::query();
        }

        // カテゴリ絞り込み
        if ($categoryUuid) {
            $recipesQuery->whereHas('categories', function ($query) use ($categoryUuid) {
                $query->where('r_category_uuid', $categoryUuid);
            });
        }

        // 検索キーワード絞り込み
        if (!empty($search)) {
            $normalized = mb_convert_kana($search, 'c', 'UTF-8');
            $recipesQuery->where('title', 'like', '%' . $normalized . '%');
        }

        // 並び替え
        if (Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value && $sort === 'favorites') {
            $recipesQuery->withCount('savedItems')->orderBy('saved_items_count', 'desc');
        } else {
            $recipesQuery->orderBy('created_at', 'desc');
        }


        // レシピを取得
        $recipes = $recipesQuery->paginate($perPage);

        // ログインユーザーのブックマークIDリストを取得
        $bookmarkedRecipeIds = [];
        if (Auth::check()) {
            $bookmarkedRecipeIds = SavedItem::where('user_uuid', Auth::id())
                ->where('item_type', Recipe::class)
                ->pluck('item_uuid')
                ->toArray();
        }

        // レシピカテゴリ一覧取得
        $recipeCategories = RCategory::where('category_id', '<=', 12)
                                  ->orderBy('category_id', 'asc')
                                  ->get();

        return view('recipes.index', compact('recipes', 'recipeCategories', 'sort', 'perPage', 'categoryUuid', 'bookmarkedRecipeIds'));
    }

    public function category(Request $request, $categoryUuid)
    {
        $perPage = $request->input('per_page', 20);
        $sort = $request->input('sort', 'newest');
        // カテゴリを取得
        $selectedCategory = RCategory::findOrFail($categoryUuid);

        $recipesQuery = Recipe::whereHas('categories', function ($query) use ($categoryUuid) {
            $query->where('r_category_uuid', $categoryUuid);
        });

        if (Auth::check() && Auth::user()->membership_status_code->value == \App\Enums\MembershipStatus::Silver->value && $sort === 'favorites') {
            $recipesQuery->orderBy('favorite_count', 'desc');
        } else {
            $recipesQuery->orderBy('created_at', 'desc');
        }

        $recipes = $recipesQuery->paginate($perPage);

        // ログインユーザーのブックマークIDリストを取得
        $bookmarkedRecipeIds = [];
        if (Auth::check()) {
            $bookmarkedRecipeIds = SavedItem::where('user_uuid', Auth::id())
                ->where('item_type', Recipe::class)
                ->pluck('item_uuid')
                ->toArray();
        }

        $recipeCategories = RCategory::where('category_id', '<=', 12)
                                    ->orderBy('category_id', 'asc')
                                    ->get();

        return view('recipes.index', compact('recipes', 'recipeCategories', 'selectedCategory', 'sort', 'perPage', 'bookmarkedRecipeIds'));
    }
}
