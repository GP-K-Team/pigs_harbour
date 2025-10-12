<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Attributes\RouteSlug;
use App\Traits\HasCallableAttribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 * @mixin RouteSlug
 */
trait IsIdentifiedBySlug
{
    use HasCallableAttribute;

    public function getRouteKeyName(): string
    {
        return $this->getRouteSlug();
    }
}
