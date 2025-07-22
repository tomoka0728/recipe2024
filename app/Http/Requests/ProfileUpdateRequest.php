<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [];

        // 送信されたフィールドのみバリデーションルールを適用
        if ($this->has('name')) {
            $rules['name'] = ['required', 'string', 'max:255'];
        }

        if ($this->has('nickname')) {
            $rules['nickname'] = ['required', 'string', 'max:255'];
        }

        if ($this->has('birth')) {
            $rules['birth'] = ['nullable', 'date', 'before:today'];
        }

        if ($this->has('email')) {
            $rules['email'] = [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->uuid, 'uuid'),
            ];
        }

        return $rules;
    }
}
