<?php

declare(strict_types=1);

namespace App\Enum;

use App\Attributes\FilterLabel;
use App\Attributes\Label;
use App\Traits\HasCallableAttribute;

enum Fur: string
{
    use HasCallableAttribute;

    #[Label('Жёсткая')]
    #[FilterLabel('Жесткоошерстные')]
    case Rough = 'rough';

    #[Label('Длинная')]
    #[FilterLabel('Длинношерстные')]
    case Long = 'long';

    #[Label('Гладкая')]
    #[FilterLabel('Гладкошерстные')]
    case Smooth = 'smooth';

    #[Label('Скинни')]
    #[FilterLabel('Лысые')]
    case Hairless = 'bald';

    #[Label('Розетка')]
    #[FilterLabel('Розетчатые')]
    case Rosette = 'rosette';
}
