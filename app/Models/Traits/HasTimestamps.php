<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Add this trait to a model to automatically cast the model's default timestamps to Carbon instances.
 *
 * @mixin Model
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
trait HasTimestamps
{
    public function getCasts(): array
    {
        $casts = $this->casts;

        if (self::CREATED_AT) {
            $casts['created_at'] = 'datetime';
        }

        if (self::UPDATED_AT) {
            $casts['updated_at'] = 'datetime';
        }

        return $casts;
    }
}
