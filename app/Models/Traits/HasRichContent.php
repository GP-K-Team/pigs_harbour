<?php

namespace App\Models\Traits;

use App\Attributes\RichContentColumn;
use ReflectionClass;

trait HasRichContent
{

    /**
     * @throws \Exception
     */
    public static function getRichContentColumn(): string
    {
        $attribute = (new ReflectionClass(static::class))
            ->getAttributes(RichContentColumn::class)[0] ?? throw new \Exception('Атрибут не существует!');

        return $attribute->newInstance()->columnName;
    }
}
