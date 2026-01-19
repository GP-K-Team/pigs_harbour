<?php

declare(strict_types=1);

namespace App\Models;

use App\Attributes\RouteSlug;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasTimestamps;
use App\Models\Traits\IsIdentifiedBySlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $slug_title
 * @property string $meta_description
 * @property string $meta_title
 * @property string $author
 * @property string $translated_by
 * @property string $origin_link
 * @property Collection|iterable<Image> $images
 * @property Image|null $mainImage
 * @mixin HasTimestamps
 *
 * @method static Builder|static published();
 * @method static Builder|static unpublished();
 */
#[RouteSlug('slug_title')]
class Article extends Model implements Sitemapable
{
    use HasImages, HasTimestamps, IsIdentifiedBySlug;

    public const DEFAULT_IMAGE = 'default.png';

    public const IMAGE_PATH = 'articles';

    public const PAGINATE_ITEMS_COUNT = '6';

    protected $fillable = [
        'title',
        'slug_title',
        'description',
        'text',
        'meta_title',
        'meta_description',
        'author',
        'translated_by',
        'origin_link',
        'created_at',
    ];

    /**
     * @return BelongsToMany
     */
    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class);
    }

    /**
     * Returns articles with created_date that equals or is before today
     * @param Builder $query
     * @return void
     */
    public function scopePublished(Builder $query): void
    {
        $query->whereDate('created_at', '<=', today());
    }

    /**
     * Returns articles with created_date that is in the future
     * @param Builder $query
     * @return void
     */
    public function scopeUnpublished(Builder $query): void
    {
        $query->whereDate('created_at', '>', today());
    }

    /**
     * Outline the URL pattern for sitemap.
     */
    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('blog.one', $this))
            ->setLastModificationDate($this->updated_at)
            ->setPriority(0.75);
    }
}
