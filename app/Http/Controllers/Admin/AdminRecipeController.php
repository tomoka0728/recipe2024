<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Models\RecipeCategory;
use App\Models\RecipeStep;
use App\Models\RecipeIngredient;
use App\Models\Step;
use App\Models\RCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingredient;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminRecipeController extends Controller
{
    public function create()
    {
        // 必要なデータをビューに渡して新規作成ページを表示
        $categories = RCategory::orderBy('category_id', 'asc')->get();
        return view('admin.recipes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:50',
            'description' => 'nullable|string',
            'ingredient_names.*' => 'required|string',
            'quantities.*' => 'nullable|string',
            'units.*' => 'nullable|string',
            'step_descriptions.*' => 'required|string|max:255',
            'step_images.*' => 'nullable|image',
            'categories'  => 'required|array',
            'categories.*' => 'exists:r_categories,uuid', // カテゴリのUUIDが存在するか確認
            'cooking_time' => 'required|integer|min:1',
            'servings' => 'required|integer|min:1',
            'image' => 'required|image|max:2048', // 2MBまでの画像
        ]);

        // トランザクション開始
        DB::beginTransaction();

        try {
            Log::debug('レシピ作成開始');
            // 新規レシピの作成
            $recipe = new Recipe();
            $recipe->uuid = Str::uuid();
            $recipe->admin_uuid = auth('admin')->user()->uuid;
            $recipe->title = $request->input('title');
            $recipe->description = $request->input('description');
            $recipe->cooking_time = $request->input('cooking_time');
            $recipe->servings = $request->input('servings');

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->storeAs(
                    'recipe',
                    $request->file('image')->hashName(),
                    's3'
                );
                \Log::debug('Image saved to S3: ' . $imagePath);
                // S3に保存した画像を公開設定
                Storage::disk('s3')->setVisibility($imagePath, 'public');
                // 画像パスをレシピに設定
                $recipe->image_path = $imagePath;
            }

            $recipe->save();

            // 材料保存
            Log::debug('材料保存開始');
            $ingredientNames = $request->input('ingredient_names');
            $units = $request->input('units');
            $quantities = $request->input('quantities');

            foreach ($ingredientNames as $i => $ingredientName) {
                $ingredient = Ingredient::where('name', $ingredientName)->first();
                if (!$ingredient) {
                    DB::rollBack();
                    return back()->with('error', '指定された材料が見つかりません: ' . $ingredientName);
                }

                RecipeIngredient::create([
                    'uuid' => Str::uuid(),
                    'recipe_uuid' => $recipe->uuid,
                    'ingredient_uuid' => $ingredient->uuid,
                    'quantity' => $quantities[$i],
                    'unit' => $units[$i] ?? null,
                ]);
            }

            Log::debug('ステップ保存開始');
            // 手順登録
            foreach ($request->step_descriptions as $i => $desc) {
                $step = new Step();
                $step->uuid = Str::uuid();
                $step->recipe_uuid = $recipe->uuid;
                $step->step_number = $i + 1;
                $step->description = $desc;

                if ($request->hasFile("step_images.$i")) {
                    $stepImage = $request->file("step_images.$i");
                    $imagePath = $stepImage->storeAs('recipe', $stepImage->hashName(), 's3');
                    \Log::debug('Image saved to S3: ' . $imagePath);
                    Storage::disk('s3')->setVisibility($imagePath, 'public');
                    $step->image_path = $imagePath;
                }

                $step->save();
            }

            Log::debug('カテゴリ保存開始');
            // カテゴリ登録
            $categories = $request->input('categories');
            $categoryData = [];
            foreach ($categories as $categoryUuid) {
                $categoryData[] = [
                    'recipe_uuid' => $recipe->uuid,
                    'r_category_uuid' => $categoryUuid,
                    'uuid' => Str::uuid(), // uuidを明示的に生成
                ];
            }

            DB::table('recipe_categories')->insert($categoryData);

            DB::commit();
            return redirect()->route('admin.recipes.index')->with('success', 'レシピを登録しました。');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('レシピ登録エラー: ' . $e->getMessage());
            Log::error('スタックトレース: ' . $e->getTraceAsString());
            return back()->with('error', 'レシピの登録に失敗しました。もう一度お試しください。');
        }
    }


    public function edit($uuid)
    {
        $recipe = Recipe::where('uuid', $uuid)->firstOrFail();
        $categories = RCategory::orderBy('category_id', 'asc')->get();
        return view('admin.recipes.edit', compact('recipe', 'categories'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $ingredients = Ingredient::where('name', 'like', '%' . $query . '%')
                                ->limit(10)
                                ->get(['uuid', 'name']);

        return response()->json($ingredients);
    }


    public function update(Request $request, string $uuid)
    {
        \Log::info("Update method called for recipe UUID: {$uuid}");
        $ingredients = Ingredient::all();

        if (is_array($request->ingredient_uuids) && is_array($request->ingredient_names)) {
            foreach ($request->ingredient_uuids as $index => $ingredientUuid) {
                $name = $request->ingredient_names[$index] ?? 'なし';
                $uuid_display = $ingredientUuid ?? 'NULL';

                // UUIDが空なら材料名からUUIDを検索する
                if (empty($ingredientUuid)) {
                    $ingredient = \App\Models\Ingredient::where('name', $name)->first();
                    if ($ingredient) {
                        $ingredientUuid = $ingredient->uuid;
                        $uuid_display = $uuid;
                    }
                }
                // UUIDが存在し、ingredientsテーブルに存在するかチェック
                $exists = $ingredientUuid && \App\Models\Ingredient::where('uuid', $ingredientUuid)->exists();

                \Log::debug("材料{$index} - 名前: {$name}, UUID: {$uuid_display}, DBに存在: " . ($exists ? '〇' : '×'));
            }
        }

        // バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:r_categories,uuid',
            'servings' => 'required|integer|min:1',
            'cooking_time' => 'required|integer|min:1',
            'ingredient_uuids' => 'required|array',  // 材料のUUIDは配列として必須
            'ingredient_uuids.*' => 'exists:ingredients,uuid', // UUIDがingredientsテーブルに存在するか確認
            'step_descriptions' => 'required|array',  // 手順の説明を配列としてバリデーション
            'step_descriptions.*' => 'required|string',
            'step_images.*' => 'nullable|image', // 画像があれば画像ファイル
        ]);

        \Log::info('Validated data:', $validated);

        $recipe = Recipe::where('uuid', $uuid)->first();

        if (!$recipe) {
            \Log::error("Recipe not found for UUID: {$uuid}");
            abort(404);
        }

        $stepDescriptions = $request->input('step_descriptions', []);
        $stepUUIDs = $request->input('step_uuids', []);
        $stepImages = $request->file('step_images', []);

        // レシピの取得
        $recipe = Recipe::with(['steps' => function ($query) {
            $query->orderBy('step_number');
        }])->where('uuid', $uuid)->firstOrFail();

        $existingSteps = $recipe->steps->keyBy('uuid');

        DB::beginTransaction();

        try {
            // レシピ情報の更新
            $recipe->title = $request->title;
            $recipe->description = $request->description;
            $recipe->servings = $request->servings ?? $recipe->servings;
            $recipe->cooking_time = $request->cooking_time ?? $recipe->cooking_time;
            \Log::debug('all files:', request()->allFiles());

            // 画像がアップロードされた場合の処理
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('recipes', 'public');
                $recipe->image_path = $path;
            }
            $recipe->save();

            // カテゴリの更新
            $recipe->categories()->sync([]); // 既存のカテゴリを一旦解除
            foreach ($request->categories as $category_uuid) {
                // カテゴリを挿入
                RecipeCategory::create([
                    'recipe_uuid' => $recipe->uuid,
                    'r_category_uuid' => $category_uuid,
                    'uuid' => (string) Str::uuid(),
                ]);
            }

            \Log::info('categories:', $request->input('categories', []));

            // 材料の更新
            $ingredientData = [];
            foreach ($request->ingredient_uuids as $index => $ingredientUuid) {
                $ingredientData[$ingredientUuid] = [
                    'quantity' => $request->quantities[$index],
                    'unit' => $request->units[$index],
                    'uuid' => (string) Str::uuid(),
                ];
            }
            $recipe->ingredients()->sync($ingredientData);

            // 手順の差分更新
            foreach ($stepDescriptions as $index => $description) {
                $stepUUID = $stepUUIDs[$index] ?? null;
                $imageFile = $stepImages[$index] ?? null;

                if ($stepUUID && isset($existingSteps[$stepUUID])) {
                    // 既存ステップの更新
                    $step = $existingSteps[$stepUUID];
                    $step->description = $description;
                    $step->step_number = $index + 1;

                    if ($imageFile) {
                        $imagePath = $imageFile->storeAs(
                            'recipe',
                            $imageFile->hashName(),
                            's3'
                        );
                        Storage::disk('s3')->setVisibility($imagePath, 'public');
                        $step->image_path = $imagePath;
                    }

                    $step->save();
                    $existingSteps->forget($stepUUID);
                } else {
                    // 新規ステップの追加
                    $newStep = new RecipeStep();
                    $newStep->uuid = (string) \Str::uuid();
                    $newStep->recipe_uuid = $recipe->uuid;
                    $newStep->description = $description;
                    $newStep->step_number = $index + 1;

                    if ($imageFile) {
                        $imagePath = $imageFile->storeAs(
                            'recipe',
                            $imageFile->hashName(),
                            's3'
                        );
                        Storage::disk('s3')->setVisibility($imagePath, 'public');
                        $newStep->image_path = $imagePath;
                    }

                    $newStep->save();
                }
            }


            // 残った既存手順は削除
            foreach ($existingSteps as $step) {
                $step->delete();
            }

            DB::commit();

            return redirect()->route('admin.recipes.edit',  ['uuid' => $recipe->uuid])
                ->with('success', 'レシピを更新しました。');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('レシピ更新エラー: ' . $e->getMessage());
            Log::error('スタックトレース: ' . $e->getTraceAsString());
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
