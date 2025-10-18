<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

/**
 * @method string getLabel
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
readonly class Label extends RetrievableAttribute
{

}
