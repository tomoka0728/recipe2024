<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Ingredient;
use App\Models\ICategory;
use App\Models\IngredientCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use App\Models\AdminLog;
use App\Enums\AdminLogAction;
use App\Enums\AdminLogTargetType;
use App\Http\Requests\IngredientRequest;

class IngredientController extends Controller
{
    public function create()
    {
        $categories = ICategory::all(); // カテゴリーを全取得
        return view('admin.ingredients.create', compact('categories'));
    }

    public function store(IngredientRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            // 画像保存
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->storeAs(
                    'ingredients',
                    $request->file('image')->hashName(),
                    's3'
                );
                Storage::disk('s3')->setVisibility($imagePath, 'public');
            }

            $validated['seasonality'] = array_map(function($value) {
                return (int) $value;
            }, $validated['seasonality']);
            $validated['image_path'] = $imagePath;

            $ingredient = Ingredient::create([
                'uuid' => (string) Str::uuid(),
                'name' => $request->name,
                'seasonality' => json_encode($request->seasonality),
                'price' => $request->price,
                'unit' => $request->unit,
                'image_path' => $imagePath,
            ]);

            IngredientCategory::create([
                'uuid' => (string) Str::uuid(),
                'ingredient_uuid' => $ingredient->uuid,
                'i_category_uuid' => $request->i_category_uuid,
            ]);

            AdminLog::record(
                auth('admin')->user()->uuid,
                AdminLogAction::CREATE,
                AdminLogTargetType::INGREDIENT,
                $ingredient->uuid,
                $ingredient->name
            );

            DB::commit();
            return redirect()->route('admin.ingredients.create')->with('success', '材料を登録しました');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('材料登録エラー: ' . $e->getMessage());
            return redirect()->route('admin.ingredients.create')->with('error', '登録に失敗しました');
        }
    }

    public function edit($uuid)
    {
        $ingredient = Ingredient::where('uuid', $uuid)->firstOrFail();
        $categories = ICategory::all();
        $ingredientCategory = IngredientCategory::where('ingredient_uuid', $uuid)->first();

        return view('admin.ingredients.edit', compact('ingredient', 'categories', 'ingredientCategory'));
    }

    public function update(IngredientRequest $request, $uuid)
    {
        $validated = $request->validated();
        $ingredient = Ingredient::where('uuid', $uuid)->firstOrFail();

        try {
            if ($request->hasFile('image')) {
                // 新しい画像をS3に保存
                $imagePath = $request->file('image')->storeAs(
                    'ingredients',
                    $request->file('image')->hashName(),
                    's3'
                );
                Storage::disk('s3')->setVisibility($imagePath, 'public');
                $ingredient->image_path = $imagePath;
            }
        } catch (\Exception $e) {
            \Log::error('Error updating image: ' . $e->getMessage());
            return redirect()->back()->with('error', '画像の保存中にエラーが発生しました');
        }

        $seasonality = array_map('intval', $request->seasonality ?? []);
        \Log::info($seasonality);  // ここで中身を確認

        $ingredient->update([
            'name' => $request->name,
            'seasonality' => json_encode(array_map('intval', $request->seasonality ?? [])),
            'price' => $request->price,
            'unit' => $request->unit,
        ]);

        IngredientCategory::updateOrCreate(
            ['ingredient_uuid' => $uuid],
            ['i_category_uuid' => $request->i_category_uuid,
             'uuid' => (string) Str::uuid()
             ]
        );

        AdminLog::record(
            auth('admin')->user()->uuid,
            AdminLogAction::EDIT,
            AdminLogTargetType::INGREDIENT,
            $ingredient->uuid,
            $ingredient->name
        );

        return redirect()->route('admin.ingredients.edit', $uuid)->with('success', '材料を更新しました');
    }

}
