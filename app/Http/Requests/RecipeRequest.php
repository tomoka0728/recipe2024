<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
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
            'title' => 'required|string|max:50',
            'description' => 'nullable|string',
            'ingredient_names.*' => 'required|string',
            'quantities.*' => 'nullable|string',
            'units.*' => 'nullable|string',
            'step_descriptions.*' => 'required|string|max:255',
            'step_images.*' => 'nullable|image',
            'categories'  => 'required|array',
            'categories.*' => 'exists:r_categories,uuid',
            'cooking_time' => 'required|integer|min:1',
            'servings' => 'required|integer|min:1',
            'image' => $this->isMethod('post')
                ? 'required|image|max:2048'
                : 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'categories.required' => 'カテゴリは必ず指定してください。',
            'cooking_time.required' => '調理時間は必ず指定してください。',
            'servings.required' => '人数は必ず指定してください。',
            'image.required' => '画像は必ず指定してください。',
            'ingredient_names.0.required' => '1つ目の材料名は必ず指定してください。',
            'step_descriptions.0.required' => '1つ目の手順説明は必ず指定してください。',
        ];
    }
}
