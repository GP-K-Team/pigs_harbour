<?php

declare(strict_types=1);

namespace App\Models\Traits;

trait HasRichContent
{
    abstract public static function getRichContentColumnName(): string;
}
