<?php

namespace App\Attributes;

use App\Attributes\RetrievableAttribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class RichContentColumnName extends RetrievableAttribute
{

}
