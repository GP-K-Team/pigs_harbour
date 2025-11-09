<?php

declare(strict_types=1);

namespace App\Enum;

use App\Attributes\FilterValue;
use App\Attributes\Label;
use App\Traits\HasCallableAttribute;

/**
 * @mixin Label
 * @mixin FilterValue
 */
enum Sex: string
{
    use HasCallableAttribute;

    #[Label('Девочка')]
    #[FilterValue('devochki')]
    case F = 'female';

    #[Label('Мальчик')]
    #[FilterValue('malchiki')]
    case M = 'male';

    #[Label('Кастрированный')]
    #[FilterValue('kastrirovannie')]
    case K = 'neutered';
}
