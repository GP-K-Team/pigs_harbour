<?php

declare(strict_types=1);

namespace App\Enum;

enum Sex: string
{
    case F = 'female';

    case M = 'male';

    case K = 'neutered';
}
