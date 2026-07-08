<?php

declare(strict_types=1);

namespace App\Http\Requests\FoodProduct;

class CreateFoodProductFormRequest extends FoodProductFormRequest
{
    public function rules(): array
    {
        return parent::rules() + [
            'slug_title' => 'required|string|unique:food_products,slug_title',
        ];
    }
}
