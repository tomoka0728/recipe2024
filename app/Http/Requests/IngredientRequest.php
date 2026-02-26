<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'seasonality' => 'array',
            'price' => 'required|numeric',
            'unit' => 'required|string|max:10',
            'image' => $this->isMethod('post')
                ? 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                : 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'i_category_uuid' => 'required|exists:i_categories,uuid',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '材料名は必ず入力してください。',
            'name.max' => '材料名は255文字以内で入力してください。',
            'price.required' => '価格は必ず入力してください。',
            'price.numeric' => '価格は数値で入力してください。',
            'unit.required' => '単位は必ず入力してください。',
            'unit.max' => '単位は10文字以内で入力してください。',
            'image.required' => '画像は必ず選択してください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.mimes' => '画像はjpeg、png、jpg、gif形式でアップロードしてください。',
            'image.max' => '画像のサイズは2MB以下にしてください。',
            'i_category_uuid.required' => 'カテゴリーは必ず選択してください。',
            'i_category_uuid.exists' => '選択されたカテゴリーが存在しません。',
        ];
    }
}
