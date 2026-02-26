<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SavedItem;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // ブックマーク一覧表示（統合版）
    public function index()
    {
        // ログインチェック
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'ブックマークを利用するにはログインが必要です。');
        }

        $user = Auth::user();

        // レシピのブックマーク（最初の4件のみ）
        $savedRecipes = SavedItem::where('user_uuid', $user->uuid)
            ->where('item_type', Recipe::class)
            ->with('item')
            ->latest()
            ->limit(4)
            ->get();

        // レシピの総数
        $totalRecipes = SavedItem::where('user_uuid', $user->uuid)
            ->where('item_type', Recipe::class)
            ->count();

        // 食材のブックマーク（最初の5件のみ）
        $savedIngredients = SavedItem::where('user_uuid', $user->uuid)
            ->where('item_type', Ingredient::class)
            ->with('item')
            ->latest()
            ->limit(5)
            ->get();

        // 食材の総数
        $totalIngredients = SavedItem::where('user_uuid', $user->uuid)
            ->where('item_type', Ingredient::class)
            ->count();

        return view('bookmarks.index', compact('savedRecipes', 'savedIngredients', 'totalRecipes', 'totalIngredients'));
    }

    // レシピのブックマーク一覧
    public function recipes()
    {
        // ログインチェック
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'ブックマークを利用するにはログインが必要です。');
        }

        $user = Auth::user();

        $savedRecipes = SavedItem::where('user_uuid', $user->uuid)
            ->where('item_type', Recipe::class)
            ->with('item')
            ->latest()
            ->paginate(12);

        return view('bookmarks.recipes', compact('savedRecipes'));
    }

    // 食材のブックマーク一覧
    public function ingredients()
    {
        // ログインチェック
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'ブックマークを利用するにはログインが必要です。');
        }

        $user = Auth::user();

        $savedIngredients = SavedItem::where('user_uuid', $user->uuid)
            ->where('item_type', Ingredient::class)
            ->with('item')
            ->latest()
            ->paginate(16);

        return view('bookmarks.ingredients', compact('savedIngredients'));
    }

    // ブックマーク追加
    public function store(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:recipe,ingredient',
            'item_uuid' => 'required|uuid',
        ]);

        $user = Auth::user();
        $itemType = $request->item_type === 'recipe' ? Recipe::class : Ingredient::class;

        // 会員レベル別のブックマーク上限
        $bookmarkLimits = [
            \App\Enums\MembershipStatus::Free->value => 10,
            \App\Enums\MembershipStatus::Silver->value => 50,
            \App\Enums\MembershipStatus::Gold->value => 100,
        ];

        $membershipStatus = $user->membership_status_code->value;
        $limit = $bookmarkLimits[$membershipStatus] ?? 10;

        // 現在のブックマーク数をカウント
        $currentCount = SavedItem::where('user_uuid', $user->uuid)->count();

        // 上限チェック
        if ($currentCount >= $limit) {
            return response()->json([
                'message' => 'ブックマークの上限に達しました',
                'limit_exceeded' => true,
                'current' => $currentCount,
                'limit' => $limit,
                'membership' => $membershipStatus
            ], 400);
        }

        // 既に存在するかチェック
        $exists = SavedItem::where('user_uuid', $user->uuid)
            ->where('item_type', $itemType)
            ->where('item_uuid', $request->item_uuid)
            ->exists();

        if ($exists) {
            return response()->json(['message' => '既にブックマークに追加されています'], 400);
        }

        SavedItem::create([
            'user_uuid' => $user->uuid,
            'item_type' => $itemType,
            'item_uuid' => $request->item_uuid,
        ]);

        return response()->json([
            'message' => 'ブックマークに追加しました',
            'current' => $currentCount + 1,
            'limit' => $limit
        ], 201);
    }

    // ブックマーク削除
    public function destroy(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:recipe,ingredient',
            'item_uuid' => 'required|uuid',
        ]);

        $user = Auth::user();
        $itemType = $request->item_type === 'recipe' ? Recipe::class : Ingredient::class;

        $deleted = SavedItem::where('user_uuid', $user->uuid)
            ->where('item_type', $itemType)
            ->where('item_uuid', $request->item_uuid)
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'ブックマークから削除しました'], 200);
        }

        return response()->json(['message' => 'ブックマークが見つかりません'], 404);
    }

    // ブックマーク状態確認
    public function check(Request $request)
    {
        $request->validate([
            'item_type' => 'required|in:recipe,ingredient',
            'item_uuid' => 'required|uuid',
        ]);

        $user = Auth::user();
        $itemType = $request->item_type === 'recipe' ? Recipe::class : Ingredient::class;

        $exists = SavedItem::where('user_uuid', $user->uuid)
            ->where('item_type', $itemType)
            ->where('item_uuid', $request->item_uuid)
            ->exists();

        return response()->json(['bookmarked' => $exists]);
    }
}
