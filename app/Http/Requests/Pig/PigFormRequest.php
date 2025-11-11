<?php

declare(strict_types=1);

namespace App\Http\Requests\Pig;

use App\Enum\Fur;
use App\Enum\Sex;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
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
        $formData['city_id'] = (int) $formData['city'];
        $formData['companion_pig_id'] = $formData['companion'] ?? null;

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
            'birthday' => 'required|string',
            'is_active' => 'boolean',
            'has_delivery' => 'boolean',
            'description' => 'nullable|string',
            'sex' => ['required', Rule::enum(Sex::class)],
            'fur' => ['required', Rule::enum(Fur::class)],
            'city' => 'required|int|exists:cities,id',
            'companion' => 'nullable|int|exists:pigs,id',
            'files' => 'nullable|array',
            'files.*' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (is_string($value)) {
                        if (!filter_var($value, FILTER_VALIDATE_URL)) {
                            $fail('Некорректная ссылка на изображение.');
                        }
                    } elseif ($value instanceof UploadedFile) {
                        validator(['file' => $value], ['file' => 'image'])->validate();
                    }
                },
            ],
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
            'image' => 'Файл должен быть изображением',
        ];
    }

    /**
     * @return void
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'slug_name' => Str::afterLast($this->slug_name, '/'),
        ]);
    }
}
