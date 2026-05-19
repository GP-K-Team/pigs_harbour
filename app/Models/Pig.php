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
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

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
class Pig extends Model implements Sitemapable
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
        'stopped_looking_date' => 'date:Y-m-d',
        'status' => PigStatus::class,
    ];

    protected array $ageCast = [
        [
            'maxAge' => 76,
            'stringAge' => '2 месяца'
        ],
        [
            'maxAge' => 105,
            'stringAge' => '3 месяца'
        ],
        [
            'maxAge' => 135,
            'stringAge' => '4 месяца'
        ],
        [
            'maxAge' => 166,
            'stringAge' => '5 месяцев'
        ],
        [
            'maxAge' => 227,
            'stringAge' => '7 месяцев'
        ],
        [
            'maxAge' => 257,
            'stringAge' => '8 месяцев'
        ],
        [
            'maxAge' => 288,
            'stringAge' => '9 месяцев'
        ],
        [
            'maxAge' => 318,
            'stringAge' => '10 месяцев'
        ],
        [
            'maxAge' => 365,
            'stringAge' => '11 месяцев'
        ],
        [
            'maxAge' => 548,
            'stringAge' => '1 год'
        ],
        [
            'maxAge' => 685,
            'stringAge' => '1,5 года'
        ],
        [
            'maxAge' => 900,
            'stringAge' => '2 года'
        ],
        [
            'maxAge' => 1050,
            'stringAge' => '2,5 года'
        ],
        [
            'maxAge' => 1460,
            'stringAge' => '3 года'
        ],
        [
            'maxAge' => 1825,
            'stringAge' => '4 года'
        ],
        [
            'maxAge' => 2190,
            'stringAge' => '5 лет'
        ],
        [
            'maxAge' => 2555,
            'stringAge' => '6 лет'
        ],
        [
            'maxAge' => 2920,
            'stringAge' => '7 лет'
        ],
        [
            'maxAge' => 3285,
            'stringAge' => '8 лет'
        ],
    ];

    public function isActive(): bool
    {
        return $this->status === PigStatus::ACTIVE;
    }

    public function getAgeString(): string
    {
        $ageString = '';

        if ($this->birthday) {
            $daysDifference = $this->status === PigStatus::FOUND_HOME ? $this->birthday->diffInDays($this->stopped_looking_date) : $this->birthday->diffInDays(today());

            foreach ($this->ageCast as $ageCast) {
                if ($daysDifference <= $ageCast['maxAge']) {
                    $ageString = $ageCast['stringAge'];
                    break;
                }
            }
        }

        return $ageString;
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function companion(): BelongsTo
    {
        return $this->belongsTo(Pig::class, 'companion_pig_id', 'id');
    }

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

    /**
     * Outline the URL pattern for sitemap.
     */
    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('catalog.one', $this))
            ->setLastModificationDate($this->updated_at)
            ->setPriority(0.25);
    }
}
