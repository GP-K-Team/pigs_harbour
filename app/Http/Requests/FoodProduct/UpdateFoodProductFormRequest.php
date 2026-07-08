<?php

declare(strict_types=1);

namespace App\Http\Requests\FoodProduct;

use Illuminate\Validation\Rule;

class UpdateFoodProductFormRequest extends FoodProductFormRequest
{
    public function rules(): array
    {
        return parent::rules() + [
            'slug_title' => [
                'required',
                'string',
                Rule::unique('food_products', 'slug_title')->ignore($this->route('foodProduct'))
            ]
        ];
    }
}
