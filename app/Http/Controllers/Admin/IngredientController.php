<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Ingredient;
use App\Models\ICategory;
use App\Models\IngredientCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;

class IngredientController extends Controller
{
    public function create()
    {
        $categories = ICategory::all(); // カテゴリーを全取得
        return view('admin.ingredients.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'seasonality' => 'array',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:10',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'i_category_uuid' => 'required|exists:i_categories,uuid',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                // S3に保存する
                $imagePath = $request->file('image')->storeAs(
                    'ingredients',
                    $request->file('image')->hashName(),
                    's3'
                );

                // 保存した画像パスを確認
                \Log::debug('Image saved to S3: ' . $imagePath);

                // S3に保存した画像を公開設定
                Storage::disk('s3')->setVisibility($imagePath, 'public');
            } else {
                \Log::debug('No image was uploaded.');
            }
        } catch (\Exception $e) {
            \Log::error('Error saving image: ' . $e->getMessage());  // エラーメッセージをログに出力
            return redirect()->route('admin.ingredients.create')->with('error', '画像の保存中にエラーが発生しました');
        }

        \Log::debug('Request has file: ' . ($request->hasFile('image') ? 'Yes' : 'No'));
        \Log::debug('File info: ' . json_encode($request->file('image')));


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

        return redirect()->route('admin.ingredients.create')->with('success', '材料を登録しました');
    }

    public function edit($uuid)
    {
        $ingredient = Ingredient::where('uuid', $uuid)->firstOrFail();
        $categories = ICategory::all();
        $ingredientCategory = IngredientCategory::where('ingredient_uuid', $uuid)->first();

        return view('admin.ingredients.edit', compact('ingredient', 'categories', 'ingredientCategory'));
    }

    public function update(Request $request, $uuid)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'seasonality' => 'array',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'i_category_uuid' => 'required|exists:i_categories,uuid',
        ], [
            'i_category_uuid.required' => 'カテゴリーを選択してください。',
        ]);

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

        return redirect()->route('admin.ingredients.edit', $uuid)->with('success', '材料を更新しました');
    }

}
