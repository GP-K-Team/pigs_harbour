<?php

declare(strict_types=1);

namespace App\Enum;

use App\Attributes\FilterLabel;
use App\Traits\HasCallableAttribute;

/**
 * @mixin FilterLabel
 */
enum AgeFilter: int
{
    use HasCallableAttribute;

    #[FilterLabel('Неизвестен')]
    case Unknown = 0;

    #[FilterLabel('До 1 года')]
    case Young = 1;

    #[FilterLabel('До 3 лет')]
    case Mid = 2;

    #[FilterLabel('Старше 3 лет')]
    case Old = 3;
}
