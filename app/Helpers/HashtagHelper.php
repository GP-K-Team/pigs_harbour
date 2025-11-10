<?php

namespace App\Helpers;

use App\Models\Hashtag;

class HashtagHelper
{
    /**
     * Takes array of strings, returns array of actual ids
     * @param array{string} $hashtagsToProcess
     * @return array{int}
     */
    public function handleHashtags(array $hashtagsToProcess): array
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
