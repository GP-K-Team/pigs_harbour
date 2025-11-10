<?php

declare(strict_types=1);

namespace App\Models;

use App\Helpers\LinguisticsHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $tag
 * @property string $slug
 * @property Collection|iterable<Article> $articles
 */
class Hashtag extends Model
{
    protected $fillable = [
        'tag',
        'slug',
    ];

    public $timestamps = false;

    /**
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }

    /**
     * @param array{string} $hashtagsToProcess
     * @return array{int}
     */
    public static function getOrCreatedIds(array $hashtagsToProcess): array
    {
        $hashtags = Hashtag::whereIn('tag', $hashtagsToProcess)->get();

        $newHashtags = array_diff($hashtagsToProcess, $hashtags->pluck('tag')->toArray());
        $hashtagIDs = $hashtags->pluck('id')->toArray();

        foreach ($newHashtags as $hashtagsToProcess) {
            $newHashtag = new Hashtag();
            $newHashtag->tag = $hashtagsToProcess;
            $newHashtag->slug = LinguisticsHelper::transliterate($hashtagsToProcess);
            $newHashtag->save();
            $hashtagIDs[] = $newHashtag->id;
        }

        return $hashtagIDs;
    }
}
