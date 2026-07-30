<?php

namespace App\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class RichContentColumn
{
    public function __construct(public string $columnName)
    {
    }

    public function columnName(): string
    {
        return $this->columnName;
    }
}
