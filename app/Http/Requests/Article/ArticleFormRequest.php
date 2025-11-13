<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Carbon\Carbon;
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
            'translated_by' => 'nullable|string',
            'origin_link' => 'nullable|url',
            'cover' => 'nullable',
            'hashtags' => 'nullable|array',
            'created_at' => 'nullable|date|before:tomorrow',
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

    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'slug_title' => Str::afterLast($this->slug_title, '/'),
            'created_at' => Carbon::parseFromLocale($this['created_at']),
        ]);
    }
}
