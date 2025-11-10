<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

use Illuminate\Validation\Rule;

class UpdateArticleFormRequest extends ArticleFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return parent::rules() + [
            'slug_title' => [
                'required',
                'string',
                Rule::unique('articles', 'slug_title')->ignore($this->route('article'))
            ]
        ];
    }
}
