<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\HashtagType;
use App\Helpers\LinguisticsHelper;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $tag
 * @property string $slug
 * @property HashtagType $type
 * @property Collection|iterable<Article> $articles
 * @property Collection|iterable<FoodProduct> $foodProducts
 *
 * @method static Builder|static activeOnly(HashtagType $type)
 * @method static Builder|static ofType(HashtagType $type)
 */
class Hashtag extends Model
{
    protected $fillable = [
        'tag',
        'slug',
        'type',
    ];

    public $timestamps = false;

    private array $relationTypes = [
        HashtagType::ARTICLE->value => 'articles',
        HashtagType::PRODUCT->value => 'foodProducts',
    ];

    protected function casts(): array
    {
        return [
            'type' => HashtagType::class,
        ];
    }

    /**
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    /**
     * @return BelongsToMany
     */
    public function foodProducts(): BelongsToMany
    {
        return $this->belongsToMany(FoodProduct::class);
    }

    /**
     * @param array{string} $hashtagsToProcess
     * @return array{int}
     */
    public static function getOrCreateIds(array $hashtagsToProcess, HashtagType $type): array
    {
        $hashtags = Hashtag::ofType($type)->whereIn('tag', $hashtagsToProcess)->get();

        $newHashtags = array_diff($hashtagsToProcess, $hashtags->pluck('tag')->toArray());
        $hashtagIDs = $hashtags->pluck('id')->toArray();

        foreach ($newHashtags as $hashtagsToProcess) {
            $newHashtag = new Hashtag();
            $newHashtag->tag = $hashtagsToProcess;
            $newHashtag->slug = LinguisticsHelper::transliterate($hashtagsToProcess);
            $newHashtag->type = $type;
            $newHashtag->save();
            $hashtagIDs[] = $newHashtag->id;
        }

        return $hashtagIDs;
    }

    /**
     * Limits hashtags to the given type
     *
     * @param Builder $query
     * @param HashtagType $type
     * @return void
     */
    public function scopeOfType(Builder $query, HashtagType $type): void
    {
        $query->where('type', $type->value);
    }

    /**
     * Returns hashtags of the given type that have related entities only.
     *
     * @param Builder $query
     * @param HashtagType $type
     * @return void
     */
    public function scopeActiveOnly(Builder $query, HashtagType $type): void
    {
        $query->ofType($type)->whereHas($this->relationTypes[$type->value]);
    }
}
