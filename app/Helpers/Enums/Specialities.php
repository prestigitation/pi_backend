<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum Specialities: string {
    use EnumHelper;

    case SPECIALITY_PI = 'Разработка программно-информационных систем';
    case SPECIALITY_IITO = 'Информационные технологии в образовании';
}
