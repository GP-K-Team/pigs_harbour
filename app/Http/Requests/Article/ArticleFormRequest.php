<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

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
        $formData = parent::validated($key, $default);
        $formData['slug_title'] = Str::afterLast($formData['slug_title'], '/');

        return $formData;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string|max:300',
            'text' => 'required|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'author' => 'nullable|string',
            'origin_link' => 'nullable|url',
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
            'url' => 'Невалидная ссылка'
        ];
    }
}
