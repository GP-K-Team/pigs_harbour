<?php

namespace App\Enum;

use App\Attributes\Label;
use App\Traits\HasCallableAttribute;

enum PigStatus: string
{
    use HasCallableAttribute;

    #[Label('Ищет дом')]
    case ACTIVE = 'active';
    #[Label('В новом доме')]
    case FOUND_HOME = 'found_home';
    #[Label('На Пристани')]
    case IN_HARBOUR = 'in_harbour';
}
