<?php

declare(strict_types=1);

namespace App\Models;

use App\Attributes\RouteSlug;
use App\Enum\AgeFilter;
use App\Enum\Fur;
use App\Enum\PigStatus;
use App\Enum\Sex;
use App\Helpers\LinguisticsHelper;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasTimestamps;
use App\Models\Traits\IsIdentifiedBySlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 * @property Carbon $stopped_looking_date
 * @property bool $has_delivery
 * @property PigStatus $status
 * @property City $city
 * @property Pig $companion
 * @property Pig $companionOf
 * @property Collection|iterable<Image> $images
 * @property Image|null $mainImage
 * @property int $city_id
 * @property int $companion_pig_id
 *
 * @method static Builder|static activeDesc()
 * @method static Builder|static activeAsc()
 * @method static Builder|static notActiveAsc()
 * @method static Builder|static notActiveDesc()
 * @method static Builder|static filter(array $params)
 *
 * @mixin HasTimestamps
 */
#[RouteSlug('slug_name')]
class Pig extends Model
{
    use HasImages, HasTimestamps, IsIdentifiedBySlug;

    public const DEFAULT_IMAGE = 'default.png';

    public const IMAGE_PATH = 'pigs';

    public const PAGINATE_ITEMS_COUNT = '6';

    private const DELIVERY_LABEL = 'Доставка';

    protected $fillable = [
        'name',
        'slug_name',
        'sex',
        'age',
        'description',
        'fur',
        'birthday',
        'has_delivery',
        'status',
        'stopped_looking_date',
        'companion_pig_id',
        'city_id',
    ];

    protected $casts = [
        'fur' => Fur::class,
        'sex' => Sex::class,
        'birthday' => 'date:Y-m-d',
        'stopped_looking_date' => 'date',
        'status' => PigStatus::class,
    ];

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === PigStatus::ACTIVE;
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

    public static function getDeliveryLabel(): string
    {
        return LinguisticsHelper::transliterate(static::DELIVERY_LABEL);
    }

    /**
     * Currently active in desc order by created_at
     */
    public function scopeActiveDesc(Builder $query): void
    {
        $query->where('status', '=', PigStatus::ACTIVE)->orderByDesc('created_at');
    }

    /**
     * Currently active in asc order by created_at
     */
    public function scopeActiveAsc(Builder $query): void
    {
        $query->where('status', '=', PigStatus::ACTIVE)->orderBy('created_at');
    }

    /**
     * Currently not active in asc order by created_at
     */
    public function scopeNotActiveAsc(Builder $query): void
    {
        $query->where('status', '!=', PigStatus::ACTIVE)->orderBy('created_at');
    }

    /**
     * Currently not active in desc order by created_at
     */
    public function scopeNotActiveDesc(Builder $query): void
    {
        $query->where('status', '!=', PigStatus::ACTIVE)->orderByDesc('created_at');
    }

    /**
     * @param Builder $query Pig query
     * @param array{
     *     city: string,
     *     age: AgeFilter,
     *     sex: Sex|string,
     *     fur: Fur|string,
     * } $params
     */
    public function scopeFilter(Builder $query, array $params = []): void
    {
        $params = array_filter($params);

        foreach ($params as $key => $value) {
            match ($key) {
                default => $query->where($key, $value),
                'city' => $query->whereHas('city', fn (Builder $cities) => $cities->where('name', $value)),
                'age' => match ($value) {
                    AgeFilter::Young => $query->where('birthday', '>', today()->subYear()),
                    AgeFilter::Mid => $query->where('birthday', '>', today()->subYears(3)),
                    AgeFilter::Old => $query->where('birthday', '<=', today()->subYears(3)),
                    default => $query->whereNull('birthday'),
                },
            };
        }
    }
}
