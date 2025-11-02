<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

/**
 * @method string getFilterLabel
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
readonly class FilterLabel extends RetrievableAttribute
{

}
