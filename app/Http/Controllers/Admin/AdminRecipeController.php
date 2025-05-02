<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingredient;
use App\Models\RecipeStep;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRecipeController extends Controller
{
    public function create()
    {
        // 必要なデータをビューに渡して新規作成ページを表示
        $categories = RCategory::all();
        return view('admin.recipes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:255',
            'category' => 'required|exists:r_categories,uuid',
            // 他のバリデーション
        ]);

        // 新規レシピの作成
        $recipe = new Recipe();
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->r_category_uuid = $request->category;
        // 他のフィールドの保存
        $recipe->save();

        return redirect()->route('admin.recipes.index')->with('success', 'レシピを作成しました');
    }

    public function edit($uuid)
    {
        $recipe = Recipe::where('uuid', $uuid)->firstOrFail();
        $categories = RCategory::all();
        return view('admin.recipes.edit', compact('recipe', 'categories'));
    }

    public function update(Request $request, $uuid)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:r_categories,uuid',
            'servings' => 'required|integer|min:1',
            'cooking_time' => 'required|integer|min:1',
        ]);
    
        // レシピの取得
        $recipe = Recipe::with(['steps' => function ($query) {
            $query->orderBy('step_number');
        }])->where('uuid', $uuid)->firstOrFail();
        
        DB::beginTransaction();
    
        try {
            // レシピ情報の更新
            $recipe->title = $request->title;
            $recipe->description = $request->description;
            $recipe->servings = $request->servings ?? $recipe->servings;
            $recipe->cooking_time = $request->cooking_time ?? $recipe->cooking_time;
            
            // 画像がアップロードされた場合の処理
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('recipes', 'public');
                $recipe->image_path = $path;
            }
            $recipe->save();
    
            // カテゴリの更新
            $recipe->categories()->sync($request->categories);
            
            // 手順の更新
            $stepUUIDs = $request->input('step_uuids', []);
            $stepDescriptions = $request->input('step_descriptions', []);
            $stepImages = $request->file('step_images', []);

            // 既存の手順を削除する
            foreach ($recipe->steps as $existingStep) {
                // 更新されない手順（UUIDがリストにないもの）は削除
                if (!in_array($existingStep->uuid, $stepUUIDs)) {
                    $existingStep->delete();
                }
            }
            
            foreach ($stepDescriptions as $index => $description) {
                $stepUUID = $stepUUIDs[$index] ?? null;
                $imageFile = $stepImages[$index] ?? null;
    
                if ($stepUUID) {
                    // 既存ステップの更新
                    $step = RecipeStep::where('uuid', $stepUUID)->where('recipe_uuid', $recipe->uuid)->first();
                    if ($step) {
                        $step->description = $description;
                        $step->step_number = $index + 1;
    
                        // 画像が新しくアップされた場合のみ保存
                        if ($imageFile) {
                            $path = $imageFile->store('steps', 'public');
                            $step->image_path = $path;
                        }
    
                        $step->save();
                    }
                } else {
                    // 新規ステップの追加
                    $newStep = new RecipeStep();
                    $newStep->uuid = (string) \Str::uuid();
                    $newStep->recipe_uuid = $recipe->uuid;
                    $newStep->description = $description;
                    $newStep->step_number = $index + 1;
    
                    if ($imageFile) {
                        $path = $imageFile->store('steps', 'public');
                        $newStep->image_path = $path;
                    }
    
                    $newStep->save();
                }
            }
            
            // コミットして変更を確定
            DB::commit();
    
            return redirect()->route('admin.recipes.index')->with('success', 'レシピを更新しました');
        } catch (\Exception $e) {
            // エラーが発生した場合はロールバック
            DB::rollBack();
    
            // エラーメッセージをログに記録
            \Log::error('レシピ更新エラー: ' . $e->getMessage());
    
            // ユーザーにエラーメッセージを表示
            return back()->with('error', 'レシピの更新に失敗しました。もう一度お試しください。');
        }
    }
    

    public function destroy($uuid)
    {
        $recipe = Recipe::where('uuid', $uuid)->firstOrFail();
        $recipe->delete();
        return redirect()->route('admin.recipes.index')->with('success', 'レシピを削除しました');
    }
}
