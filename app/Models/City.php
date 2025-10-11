<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * @return HasMany
     */
    public function pigs(): HasMany
    {
        return $this->hasMany(Pig::class);
    }
}
