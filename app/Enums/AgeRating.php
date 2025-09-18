<?php

namespace App\Enums;

enum AgeRating: string
{
    case G = 'FSK 0';
    case FSK6 = 'FSK 6';
    case FSK12 = 'FSK 12';
    case FSK16 = 'FSK 16';
    case FSK18 = 'FSK 18';
}
