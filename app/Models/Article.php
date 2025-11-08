<?php

declare(strict_types=1);

namespace App\Models;

use App\Attributes\RouteSlug;
use App\Models\Traits\HasTimestamps;
use App\Models\Traits\IsIdentifiedBySlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $title
 * @property string $slug_title
 * @property string $meta_description
 * @property string $meta_title
 * @property string $description
 * @property string $author
 * @property string $origin_link
 * @mixin HasTimestamps
 */
#[RouteSlug('slug_title')]
class Article extends Model
{
    use HasTimestamps, IsIdentifiedBySlug;

    public const DEFAULT_IMAGE = 'PEEG.jpg';
    public const DEFAULT_IMAGE_PATH = 'articles';

    protected $fillable = [
        'title',
        'slug_title',
        'meta_title',
        'meta_description',
        'description',
        'author',
        'origin_link',
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
     * @return BelongsToMany
     */
    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class);
    }
}
