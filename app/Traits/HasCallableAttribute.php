<?php

declare(strict_types=1);

namespace App\Traits;

use App\Helpers\LinguisticsHelper;
use Illuminate\Support\Str;
use ReflectionEnum;

trait HasCallableAttribute
{
    /**
     * Intercept a non-existent get-method call.
     *
     * @throws \ReflectionException
     */
    public function __call($method, $parameters): mixed
    {
        $attrName = Str::chopStart($method, 'get');
        $exception = new \BadMethodCallException("Call to undefined method `$method()` in " . static::class);
        $isEnum = is_a($this, \BackedEnum::class);

        $reflection = $isEnum
            ? (new ReflectionEnum(static::class))->getCase($this->name)
            : new \ReflectionClass(static::class);

        $attribute = $reflection->getAttributes('App\\Attributes\\' . ucfirst($attrName))[0] ?? false;

        if (empty($attribute) && empty($parameters['default'])) {
            return $isEnum ? throw $exception : parent::__call($method, $parameters);
        }

        return $attribute ? $attribute->newInstance()->value() : $parameters['default'];
    }

    /**
     * Get an enum case from an attribute value.
     *
     * @param \Attribute|string $attribute Attribute class name
     * @param string|int $value Value to match against
     */
    public static function tryFromAttribute(\Attribute|string $attribute, string|int $value): ?static
    {
        $method = 'get' . class_basename($attribute);

        try {
            $reflection = (new \ReflectionClass($attribute));
        } catch (\ReflectionException) {
            return null;
        }

        $isTransliteratable = collect($reflection->getTraitNames())->some(fn (string $name) => $name === Transliteratable::class);

        foreach (self::cases() as $case) {
            $attributeValue = $case->$method();
            $valueCheck = $value === $attributeValue
                || ($isTransliteratable && $value === LinguisticsHelper::transliterate($attributeValue));

            if ($valueCheck) {
                return $case;
            }
        }

        return null;
    }
}
