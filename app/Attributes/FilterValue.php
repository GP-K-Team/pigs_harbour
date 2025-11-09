<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

/**
 * @method string getFilterValue
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
readonly class FilterValue extends RetrievableAttribute
{

}
