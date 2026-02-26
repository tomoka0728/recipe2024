<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\ICategory;
use App\Models\AdminLog;
use App\Enums\AdminLogAction;
use App\Enums\AdminLogTargetType;
use App\Models\Sale;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class IngredientManageController extends Controller
{
    public function index(Request $request)
    {
        $query = Ingredient::with(['categories', 'sale'])
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

        // 旬の絞り込み
        if ($request->filled('seasonality')) {
            $seasonality = $request->seasonality;

            if ($seasonality === 'current') {
                // 今が旬（今月が含まれている、かつseasonalityが空でない）
                $currentMonth = (int) date('n');
                $query->where(function($q) use ($currentMonth) {
                    $q->whereRaw("JSON_LENGTH(seasonality) > 0")
                      ->where(function($subQ) use ($currentMonth) {
                          // 整数としても文字列としても検索
                          $subQ->whereRaw("JSON_CONTAINS(seasonality, ?)", [json_encode($currentMonth)])
                               ->orWhereRaw("JSON_CONTAINS(seasonality, ?)", [json_encode((string)$currentMonth)]);
                      });
                });
            } elseif ($seasonality === 'out_of_season') {
                // 旬が過ぎた（seasonalityが設定されているが、今月が含まれていない）
                $currentMonth = (int) date('n');
                $query->where(function($q) use ($currentMonth) {
                    $q->whereRaw("JSON_LENGTH(seasonality) > 0")
                      ->whereRaw("NOT JSON_CONTAINS(seasonality, ?)", [json_encode($currentMonth)])
                      ->whereRaw("NOT JSON_CONTAINS(seasonality, ?)", [json_encode((string)$currentMonth)]);
                });
            } elseif (is_numeric($seasonality)) {
                // 特定の月が旬（その月が含まれている）
                $month = (int) $seasonality;
                $query->where(function($q) use ($month) {
                    $q->whereRaw("JSON_LENGTH(seasonality) > 0")
                      ->where(function($subQ) use ($month) {
                          // 整数としても文字列としても検索
                          $subQ->whereRaw("JSON_CONTAINS(seasonality, ?)", [json_encode($month)])
                               ->orWhereRaw("JSON_CONTAINS(seasonality, ?)", [json_encode((string)$month)]);
                      });
                });
            }
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

    /**
     * 一括セール設定
     */
    public function bulkSale(Request $request)
    {
        $request->validate([
            'ingredient_uuids' => 'required|array|min:1',
            'ingredient_uuids.*' => 'exists:ingredients,uuid',
            'discount_percent' => 'required|integer|min:1|max:100',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
        ]);

        DB::beginTransaction();

        try {
            foreach ($request->ingredient_uuids as $ingredientUuid) {
                // 既存のセールがあれば削除
                Sale::where('ingredient_uuid', $ingredientUuid)->delete();

                // 新しいセールを作成
                Sale::create([
                    'uuid' => (string) Str::uuid(),
                    'ingredient_uuid' => $ingredientUuid,
                    'discount_percent' => $request->discount_percent,
                    'start_at' => $request->start_at,
                    'end_at' => $request->end_at,
                ]);

                // 管理ログに記録
                $ingredient = Ingredient::where('uuid', $ingredientUuid)->first();
                AdminLog::record(
                    auth('admin')->user()->uuid,
                    AdminLogAction::EDIT,
                    AdminLogTargetType::INGREDIENT,
                    $ingredientUuid,
                    "セール設定: {$ingredient->name}"
                );
            }

            DB::commit();
            return redirect()->route('admin.ingredients.index')
                ->with('success', count($request->ingredient_uuids) . '件の商品にセールを設定しました');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('一括セール設定エラー: ' . $e->getMessage());
            return redirect()->back()->with('error', 'セール設定に失敗しました');
        }
    }

    /**
     * セール解除
     */
    public function removeSale($uuid)
    {
        $ingredient = Ingredient::where('uuid', $uuid)->firstOrFail();

        DB::beginTransaction();

        try {
            // セールを削除
            Sale::where('ingredient_uuid', $uuid)->delete();

            // 管理ログに記録
            AdminLog::record(
                auth('admin')->user()->uuid,
                AdminLogAction::EDIT,
                AdminLogTargetType::INGREDIENT,
                $uuid,
                "セール解除: {$ingredient->name}"
            );

            DB::commit();
            return redirect()->route('admin.ingredients.index')
                ->with('success', "{$ingredient->name}のセールを解除しました");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('セール解除エラー: ' . $e->getMessage());
            return redirect()->back()->with('error', 'セール解除に失敗しました');
        }
    }
}
