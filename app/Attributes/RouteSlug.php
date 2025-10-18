<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

/**
 * @method string getRouteSlug
 */
#[Attribute(Attribute::TARGET_CLASS)]
readonly class RouteSlug extends RetrievableAttribute
{

}
