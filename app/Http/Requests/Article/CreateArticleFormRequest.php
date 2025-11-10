<?php

declare(strict_types=1);

namespace App\Http\Requests\Article;

class CreateArticleFormRequest extends ArticleFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return parent::rules() + [
            'slug_title' => 'required|string|unique:articles,slug_title',
        ];
    }
}
