<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\SearchableType;
use App\Models\Traits\HasTimestamps;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $search_text
 * @property SearchableType $type
 * @property int $search_count
 * @property bool $failed
 * @mixin HasTimestamps
 *
 * @method static Builder|static ofType(SearchableType $type)
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
            'type' => SearchableType::class,
            'failed' => 'boolean',
        ];
    }

    public static function record(string $searchText, SearchableType $type, bool $failed): void
    {
        $query = static::firstOrNew([
            'search_text' => $searchText,
            'type' => $type->value,
        ]);

        $query->search_count = ($query->search_count ?? 0) + 1;
        $query->failed = $failed;
        $query->save();
    }

    /**
     * @param Builder $query
     * @param SearchableType $type
     * @return void
     */
    public function scopeOfType(Builder $query, SearchableType $type): void
    {
        $query->where('type', $type->value);
    }
}
