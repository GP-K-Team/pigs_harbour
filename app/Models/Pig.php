<?php

declare(strict_types=1);

namespace App\Models;

use App\Attributes\RouteSlug;
use App\Enum\Fur;
use App\Enum\Sex;
use App\Models\Traits\HasTimestamps;
use App\Models\Traits\IsIdentifiedBySlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property string $slug_name
 * @property string $description
 * @property Sex $sex
 * @property Fur $fur
 * @property string $age
 * @property Carbon $birthday
 * @property bool $available_for_other_cities
 * @property bool $is_active
 * @property City $city
 * @property Pig $companion
 * @property Pig $companionOf
 * @property Collection|iterable<Image> $images
 * @property Image|null $mainImage
 * @mixin HasTimestamps
 */
#[RouteSlug('slug_name')]
class Pig extends Model
{
    use HasTimestamps, IsIdentifiedBySlug;

    public const DEFAULT_IMAGE = 'PELICAN.jpg';

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
        'birthday' => 'datetime',
    ];

    /**
     * @return Image|null
     */
    public function getMainImageAttribute(): Image|null
    {
        return $this->images()->wherePivot('is_main', true)->first();
    }

    /**
     * @return BelongsToMany
     */
    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class)->withPivot('is_main');
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
