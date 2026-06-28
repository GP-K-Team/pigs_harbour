<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

/**
 * @method string getRelationValue
 */
#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
readonly class RelationValue extends RetrievableAttribute
{

}
