<?php

namespace App\Http\Requests;

use App\Http\Requests\PigFormRequest;

class CreatePigFormRequest extends PigFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return parent::rules() + [
                'slug_name' => 'required|string|unique:pigs,slug_name'];
    }
}
