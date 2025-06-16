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
            'unit.required' => '単位は必ず指定してください。',
            'i_category_uuid.required' => 'カテゴリーは必ず選択してください。',
        ];
    }
}
