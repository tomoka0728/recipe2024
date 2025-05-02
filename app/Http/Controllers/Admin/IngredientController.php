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


    // // ダミー画像生成（テスト用）
    // $file = UploadedFile::fake()->image('test.jpg');

    // $s3Path = 'test.jpg';

    // try {
    //     // ファイルの中身を取得
    //     $fileContents = File::get($file->getRealPath());
    
    //     // ファイルのパスをログに出力
    //     Log::info('File path: ' . $file->getRealPath());
    
    //     // ファイル内容が空かどうかを確認
    //     if (empty($fileContents)) {
    //         Log::error('ファイル内容が空です', ['file' => $file]);
    //     } else {
    //         Log::info('ファイル内容が取得できました', ['file' => $file]);
    //     }

    //     Log::info('S3へのアップロード前の準備', [
    //         'file_path' => $file->getRealPath(),
    //         'file_size' => $file->getSize(),
    //     ]);
    
    //     // アップロード
    //     $result = Storage::disk('s3')->put($s3Path, $fileContents, 'public');

        
    //     Log::info('アップロード結果', [
    //         'result' => $result,
    //         'path' => $s3Path
    //     ]);
    
    //     if ($result) {
    //         Log::info('ファイルがS3にアップロードされました', ['path' => $s3Path]);
    //         return 'アップロード成功: ' . Storage::disk('s3')->url($s3Path);
    //     } else {
    //         Log::error('S3へのアップロードに失敗しました', ['path' => $s3Path]);
    //         return 'アップロード失敗';
    //     }
    // } catch (\Exception $e) {
    //     Log::error('アップロード中に例外が発生', ['message' => $e->getMessage()]);
    //     return 'エラー: ' . $e->getMessage();
    // }
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
dd($ingredient);
        IngredientCategory::create([
            'uuid' => (string) Str::uuid(),
            'ingredients_uuid' => $ingredient->uuid,
            'i_category_uuid' => $request->i_category_uuid,
        ]);

        return redirect()->route('admin.ingredients.create')->with('success', '材料を登録しました');
    }
}
