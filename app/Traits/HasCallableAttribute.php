<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Str;
use ReflectionEnum;

trait HasCallableAttribute
{
    /**
     * Intercept a non-existent get-method call.
     */
    public function __call($method, $parameters): mixed
    {
        if (!str_starts_with($method, 'get')) {
            return parent::__call($method, $parameters);
        }

        $method = collect(Str::ucsplit($method))->except(0)->join('');

        if ($isEnum = is_a($this, \BackedEnum::class)) {
            try {
                $reflection = (new ReflectionEnum(static::class))->getCase($this->name);
            } catch (\ReflectionException) {
                return null;
            }
        } else {
            $reflection = new \ReflectionClass(static::class);
        }

        $attribute = $reflection->getAttributes('App\\Attributes\\' . $method)[0] ?? false;

        if (empty($attribute) && empty($parameters['default'])) {
            if ($isEnum) {
                throw new \BadMethodCallException("Call to undefined method `get$method()` in " . static::class);
            } else {
                return parent::__call($method, $parameters);
            }
        }

        return $attribute ? $attribute->newInstance()->value() : $parameters['default'];
    }
}
