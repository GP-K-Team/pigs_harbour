<?php

declare(strict_types=1);

namespace App\Enum;

use App\Attributes\RelationValue;
use App\Traits\HasCallableAttribute;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @mixin RelationValue
 */
enum HashtagType: string
{

    use HasCallableAttribute;

    #[RelationValue('articles')]
    case ARTICLE = 'article';

    #[RelationValue('foodProducts')]
    case PRODUCT = 'product';
}
