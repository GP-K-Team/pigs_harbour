<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $link
 * @property Collection|iterable<Pig> $pigs
 * @property Collection|iterable<Article> $articles
 * @mixin HasTimestamps
 */
class Image extends Model
{
    use HasTimestamps;

    protected $fillable = [
        'link',
    ];

    public function getFullUrl(): string
    {
        return storage_path("images/$this->link");
    }

    /**
     * @return BelongsToMany
     */
    public function pigs(): BelongsToMany
    {
        return $this->belongsToMany(Pig::class);
    }

    /**
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
