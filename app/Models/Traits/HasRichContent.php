<?php

namespace App\Models\Traits;

use App\Attributes\RichContentColumn;
use ReflectionClass;

trait HasRichContent
{
    public static function getRichContentColumn(): string
    {
        $attribute = (new ReflectionClass(static::class))
            ->getAttributes(RichContentColumn::class)[0];

        return $attribute->newInstance()->value();
    }
}
