<?php

declare(strict_types=1);

namespace App\Models;

use App\Attributes\RouteSlug;
use App\Models\Traits\HasTimestamps;
use App\Models\Traits\IsIdentifiedBySlug;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $slug_title
 * @property string $meta_description
 * @property string $meta_title
 * @property string $author
 * @property string $origin_link
 * @property Image|null $mainImage
 * @mixin HasTimestamps
 */
#[RouteSlug('slug_title')]
class Article extends Model
{
    use HasImages, HasTimestamps, IsIdentifiedBySlug;

    public const DEFAULT_IMAGE = 'default.png';

    public const IMAGE_PATH = 'articles';

    protected $fillable = [
        'title',
        'slug_title',
        'description',
        'text',
        'meta_title',
        'meta_description',
        'author',
        'origin_link',
    ];

    /**
     * @return BelongsToMany
     */
    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class);
    }
}
