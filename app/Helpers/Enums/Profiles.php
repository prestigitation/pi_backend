<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum Profiles: string {
    use EnumHelper;

    case PROFILE_PI = 'Программная инженерия';
    case PROFILE_IITO = 'Педагогическое образование';
}
