<?php

declare(strict_types=1);

namespace App\Enum;

use App\Attributes\FilterLabel;
use App\Attributes\Label;
use App\Traits\HasCallableAttribute;

/**
 * @mixin Label
 * @mixin FilterLabel
 */
enum Fur: string
{
    use HasCallableAttribute;

    #[Label('Гладкая')]
    #[FilterLabel('Гладкошерстные')]
    case Smooth = 'smooth';

    #[Label('Длинная')]
    #[FilterLabel('Длинношерстные')]
    case Long = 'long';

    #[Label('Жёсткая')]
    #[FilterLabel('Жесткошерстные')]
    case Rough = 'rough';

    #[Label('Скинни')]
    #[FilterLabel('Лысые')]
    case Hairless = 'bald';

    #[Label('Розетка')]
    #[FilterLabel('Розетчатые')]
    case Rosette = 'rosette';
}
