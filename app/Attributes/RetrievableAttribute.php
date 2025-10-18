<?php

declare(strict_types=1);

namespace App\Attributes;

readonly class RetrievableAttribute
{
    function __construct(private string $value)
    {

    }

    public function value(): string
    {
        return $this->value;
    }
}
