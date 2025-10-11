<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
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
     * @return BelongsToMany
     */
    public function hashtags(): BelongsToMany
    {
        return $this->belongsToMany(Hashtag::class);
    }
}
