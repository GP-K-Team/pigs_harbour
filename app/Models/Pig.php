<?php

namespace App\Models;

use App\Enum\Fur;
use App\Enum\Sex;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pig extends Model
{
    protected $fillable = [
        'name',
        'slug_name',
        'sex',
        'age',
        'description',
        'fur',
        'birthday',
        'available_for_other_cities',
        'is_active',
        'stopped_looking_date'
    ];

    protected $casts = [
        'fur' => Fur::class,
        'sex' => Sex::class,
    ];

    /**
     * @return Image|null
     */
    public function mainImage(): Image|null
    {
        return $this->belongsToMany(Image::class)
            ->wherePivot('is_main', true)
            ->one();
    }

    /**
     * @return BelongsToMany
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class);
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo
     */
    public function companion(): BelongsTo
    {
        return $this->belongsTo(Pig::class, 'companion_pig_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function companionOf(): HasOne
    {
        return $this->hasOne(Pig::class, 'companion_pig_id', 'id');
    }
}
