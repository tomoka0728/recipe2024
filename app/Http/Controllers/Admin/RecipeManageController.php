<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeManageController extends Controller
{
    public function index()
    {
        $recipes = Recipe::latest()->get(); // 新しい順に取得
        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('admin.recipes.create'); // 作成用ビュー（必要であれば）
    }

    public function edit($uuid)
    {
        $recipe = Recipe::where('uuid', $uuid)->firstOrFail();
        return view('admin.recipes.edit', compact('recipe'));
    }

    public function destroy($uuid)
    {
        $recipe = Recipe::where('uuid', $uuid)->firstOrFail();
        $recipe->delete();
        return redirect()->route('admin.recipes.index')->with('success', 'レシピを削除しました');
    }
}
