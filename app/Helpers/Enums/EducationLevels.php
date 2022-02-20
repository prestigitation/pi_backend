<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum EducationLevels: string {
    use EnumHelper;

    case LEVEL_HIGHER = 'Высшее';
    case LEVEL_MEDIUM = 'Среднее';
    case LEVEL_MEDIUM_SPECIAL = 'Средне-специальное';
}
