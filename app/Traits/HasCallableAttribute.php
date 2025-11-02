<?php

declare(strict_types=1);

namespace App\Traits;

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
}
