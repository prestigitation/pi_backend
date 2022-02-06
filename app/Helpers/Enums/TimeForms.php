<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum TimeForms: string {
    use EnumHelper;

    case TIME_FULL = 'очно';
    case TIME_DISTANCE = 'заочно';
}
