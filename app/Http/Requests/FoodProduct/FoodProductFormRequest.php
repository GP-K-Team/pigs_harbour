<?php

declare(strict_types=1);

namespace App\Http\Requests\FoodProduct;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class FoodProductFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'synonyms' => 'nullable|string',
            'description' => 'required|string|max:300',
            'text' => 'required|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'cover' => 'nullable',
            'hashtags' => 'nullable|array',
        ];
    }

    /** @inheritDoc */
    public function messages(): array
    {
        return [
            'required' => 'Это обязательное поле',
            'slug_title.unique' => 'Адрес уже занят!',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'slug_title' => Str::afterLast($this->slug_title, '/'),
        ]);
    }
}
