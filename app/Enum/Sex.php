<?php

declare(strict_types=1);

namespace App\Enum;

use App\Attributes\Label;
use App\Traits\HasCallableAttribute;

/**
 * @mixin Label
 */
enum Sex: string
{
    use HasCallableAttribute;

    #[Label('Девочка')]
    case F = 'female';

    #[Label('Мальчик')]
    case M = 'male';

    #[Label('Кастрированный')]
    case K = 'neutered';
}
