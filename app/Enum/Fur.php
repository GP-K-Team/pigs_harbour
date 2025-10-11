<?php

namespace App\Enum;

enum Fur: string
{
    case Rough = 'rough_coated';
    case Long = 'long_haired';
    case Smooth = 'smooth_haired';
    case Hairless = 'hairless';
    case Rosette = 'rosette';
}
