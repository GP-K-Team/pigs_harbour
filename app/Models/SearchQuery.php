<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $search_text
 * @property string $type
 * @property int $search_count
 * @property bool $failed
 * @mixin HasTimestamps
 *
 * @method static Builder|static ofType(string $type)
 */
class SearchQuery extends Model
{
    use HasTimestamps;

    protected $fillable = [
        'search_text',
        'type',
        'search_count',
        'failed',
    ];

    protected function casts(): array
    {
        return [
            'failed' => 'boolean',
        ];
    }

    public static function record(string $searchText, string $type, bool $failed): void
    {
        $query = static::firstOrNew([
            'search_text' => $searchText,
            'type' => $type,
        ]);

        $query->search_count = ($query->search_count ?? 0) + 1;
        $query->failed = $failed;
        $query->save();
    }

    /**
     * @param Builder $query
     * @param string $type
     * @return void
     */
    public function scopeOfType(Builder $query, string $type): void
    {
        $query->where('type', $type);
    }
}
