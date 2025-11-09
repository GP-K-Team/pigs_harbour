<?php

declare(strict_types=1);

namespace App\Attributes;

use App\Traits\Transliteratable;
use Attribute;

/**
 * @method string getFilterLabel
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
readonly class FilterLabel extends RetrievableAttribute
{
    use Transliteratable;
}
