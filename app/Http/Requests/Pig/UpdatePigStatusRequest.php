<?php

namespace App\Http\Requests\Pig;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePigStatusRequest extends FormRequest
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
            'is_active' => 'boolean',
        ];
    }
}
