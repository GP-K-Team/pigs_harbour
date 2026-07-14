<?php

declare(strict_types=1);

namespace App\Models;

use App\Attributes\RouteSlug;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasTimestamps;
use App\Models\Traits\IsIdentifiedBySlug;
use App\Models\Traits\IsSearchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

/**
 * @property int $id
 * @property string $title
 * @property string $slug_title
 * @property string $synonyms
 * @property string $description
 * @property string $text
 * @property string $meta_description
 * @property string $meta_title
 * @property bool $has_page
 * @property Collection|iterable<Image> $images
 * @property Image|null $mainImage
 * @mixin HasTimestamps
 *
 * @method static Builder|static published();
 * @method static Builder|static unpublished();
 * @method static Builder|static withPage();
 * @method static Builder|static withoutPage();
 */
#[RouteSlug('slug_title')]
class FoodProduct extends Model implements Sitemapable
{
    use HasImages, HasTimestamps, IsIdentifiedBySlug, IsSearchable;

    public const SEARCH_TYPE = 'food_products';

    public const DEFAULT_IMAGE = 'default.png';

    public const IMAGE_PATH = 'food_products';

    public const PAGINATE_ITEMS_COUNT = '6';

    protected $fillable = [
        'title',
        'slug_title',
        'synonyms',
        'description',
        'text',
        'meta_title',
        'meta_description',
        'has_page',
        'created_at',
    ];

    protected $casts = [
        'has_page' => 'boolean',
    ];

    /**
     * @return BelongsToMany
     */
    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class);
    }

    public function scopeWithoutPage(Builder $query): Builder
    {
        return $query->where('has_page', false);
    }

    public function scopeWithPage(Builder $query): Builder
    {
        return $query->where('has_page', true);
    }

    /**
     * Outline the URL pattern for sitemap.
     */
    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('products.one', $this))
            ->setLastModificationDate($this->updated_at)
            ->setPriority(0.75);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'synonyms' => $this->synonyms,
            'hashtags' => $this->hashtags()->pluck('tag')->toArray(),
            'created_at' => $this->created_at->timestamp,
        ];
    }
}
