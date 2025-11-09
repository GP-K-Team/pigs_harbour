<?php

declare(strict_types=1);

namespace App\Models;

use App\Attributes\RouteSlug;
use App\Enum\AgeFilter;
use App\Enum\Fur;
use App\Enum\Sex;
use App\Models\Traits\HasTimestamps;
use App\Models\Traits\IsIdentifiedBySlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
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
 * @property int $city_id
 * @property int $companion_pig_id
 *
 * @method static Builder|static activeDesc()
 * @method static Builder|static filter(array $params)
 *
 * @mixin HasTimestamps
 */
#[RouteSlug('slug_name')]
class Pig extends Model
{
    use HasTimestamps, IsIdentifiedBySlug;

    public const DEFAULT_IMAGE = 'default.png';

    public const IMAGE_PATH = 'pigs';

    public const PAGINATE_ITEMS_COUNT = '3';

    protected $fillable = [
        'name',
        'slug_name',
        'sex',
        'age',
        'description',
        'fur',
        'birthday',
        'has_delivery',
        'is_active',
        'stopped_looking_date'
    ];

    protected $casts = [
        'fur' => Fur::class,
        'sex' => Sex::class,
        'birthday' => 'date:Y-m-d',
        'is_active' => 'boolean',
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

    /**
     * Currently active in desc order by created_at
     */
    public function scopeActiveDesc(Builder $query): void
    {
        $query->where('is_active', true)->orderByDesc('created_at');
    }

    public function scopeFilter(Builder $query, array $params = []): void
    {
        $params = array_filter($params);

        foreach ($params as $key => $value) {
            match ($key) {
                default => $query->where($key, $value),
                'city' => $query->whereHas('city', fn (Builder $cities) => $cities->where('name', $value)),
                'age' => match ($value) {
                    AgeFilter::Young => $query->where('birthday', '<', today()->subYear()),
                    AgeFilter::Mid => $query->where('birthday', '<', today()->subYears(3)),
                    AgeFilter::Old => $query->where('birthday', '>=', today()->subYears(3)),
                    default => $query->whereNull('birthday'),
                },
            };
        }
    }
}
