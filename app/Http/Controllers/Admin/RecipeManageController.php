<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\RCategory;
use App\Models\Ingredient;

class RecipeManageController extends Controller
{
    public function index(Request $request)
    {
        $query = Recipe::with('categories');

        // 検索キーワード
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // カテゴリ絞り込み
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('r_category_uuid', $request->category);
            });
        }

        // 並び替え
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'title_asc':
                    $query->orderBy('title');
                    break;
                case 'title_desc':
                    $query->orderByDesc('title');
                    break;
                case 'created_asc':
                    $query->orderBy('created_at');
                    break;
                case 'created_desc':
                    $query->orderByDesc('created_at');
                    break;
            }
        } else {
            $query->orderByDesc('created_at');
        }


        $recipes = $query->paginate(10);
        $categories = RCategory::orderBy('category_id')->get();

        return view('admin.recipes.index', compact('recipes', 'categories'));
    }
}
