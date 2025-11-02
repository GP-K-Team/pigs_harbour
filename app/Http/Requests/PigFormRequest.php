<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enum\Fur;
use App\Enum\Sex;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class PigFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /** @inheritDoc */
    public function validated($key = null, $default = null)
    {
        $formData = parent::validated($key, $default);
        $formData['birthday'] = Carbon::parseFromLocale($formData['birthday']);
        $formData['sex'] = Sex::from($formData['sex']);
        $formData['fur'] = Fur::from($formData['fur']);

        return $formData;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'age' => 'nullable|string',
            'slug_name' => 'required|string|unique:pigs,slug_name',
            'birthday' => 'required|string',
            'is_active' => 'required',
            'description' => 'nullable|string',
            'sex' => ['required', Rule::enum(Sex::class)],
            'fur' => ['required', Rule::enum(Fur::class)],
            'city' => 'required|int|exists:cities,id',
            'companion' => 'nullable|int|exists:pigs,id',
            'files' => 'nullable',
        ];
    }

    /** @inheritDoc */
    public function messages(): array
    {
        return [
            'required' => 'Это обязательное поле',
            'slug_name.unique' => 'Адрес уже занят!',
            'city.exists' => 'Город не найден - убедитесь в правильности данных',
            'companion.exists' => 'Свинка не найдена - убедитесь в правильности данных',
        ];
    }
}
