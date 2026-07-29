<?php

namespace App\Attributes;

use App\Attributes\RetrievableAttribute;

use Attribute;

/**
 * @method string getRichContentColumnName
 */
#[Attribute(Attribute::TARGET_CLASS)]
readonly class RichContentColumnName extends RetrievableAttribute
{

}
