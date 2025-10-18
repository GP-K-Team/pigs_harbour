<?php

declare(strict_types=1);

namespace App\Enum;

use App\Attributes\Label;
use App\Traits\HasCallableAttribute;

enum Fur: string
{
    use HasCallableAttribute;

    #[Label('Жесткоошерстные')]
    case Rough = 'rough';

    #[Label('Длинношерстные')]
    case Long = 'long';

    #[Label('Гладкошерстные')]
    case Smooth = 'smooth';

    #[Label('Лысые')]
    case Hairless = 'bald';

    #[Label('Розетчатые')]
    case Rosette = 'rosette';
}
