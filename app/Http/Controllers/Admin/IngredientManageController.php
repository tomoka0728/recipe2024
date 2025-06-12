<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\ICategory;
use App\Models\AdminLog;
use App\Enums\AdminLogAction;
use App\Enums\AdminLogTargetType;

class IngredientManageController extends Controller
{
    public function index(Request $request)
    {
        $query = Ingredient::with(['categories'])
        ->where('price', '>', 0); // 価格が0円を除外

        // 検索キーワード
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // カテゴリ絞り込み
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('i_category_uuid', $request->category);
            });
        }

        // 並び替え
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name');
                    break;
                case 'name_desc':
                    $query->orderByDesc('name');
                    break;
                case 'price_asc':
                    $query->orderBy('price');
                    break;
                case 'price_desc':
                    $query->orderByDesc('price');
                    break;
                case 'created_desc':
                    $query->orderByDesc('created_at');
                    break;
                case 'created_asc':
                    $query->orderBy('created_at');
                    break;
            }
        } else {
            $query->orderByDesc('created_at');
        }

        $ingredients = $query->paginate(10);
        $categories = ICategory::orderBy('i_category_id')->get();

        return view('admin.ingredients.index', compact('ingredients', 'categories'));
    }

    /**
     * 材料のオートコンプリート検索
     */
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        // 名前が検索クエリに一致する材料を検索（大文字小文字を区別しない）
        $ingredients = Ingredient::where('name', 'like', '%' . $query . '%')
            ->limit(10) // 一度に返す件数を制限（必要に応じて調整）
            ->get(['uuid', 'name']);

        return response()->json($ingredients);
    }

    public function destroy($uuid)
{
    $ingredient = Ingredient::where('uuid', $uuid)->firstOrFail();
    $name = $ingredient->name;

    $ingredient->categories()->detach();
    $ingredient->delete();

    AdminLog::record(
        auth('admin')->user()->uuid,
        AdminLogAction::DELETE,
        AdminLogTargetType::INGREDIENT,
        $uuid,
        $name
    );

    return redirect()->route('admin.ingredients.index')->with('success', '商品を削除しました');
}






}
