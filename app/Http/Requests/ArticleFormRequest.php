<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /** @inheritDoc */
    public function validated($key = null, $default = null): array
    {
        // todo

        return parent::validated($key, $default);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'slug_title' => 'required|string|unique:articles,slug_title',
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
}
