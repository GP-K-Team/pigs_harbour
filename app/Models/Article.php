<?php

declare(strict_types=1);

namespace App\Models;

use App\Attributes\RouteSlug;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasTimestamps;
use App\Models\Traits\IsIdentifiedBySlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

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
 */
#[RouteSlug('slug_title')]
class Article extends Model
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
}
