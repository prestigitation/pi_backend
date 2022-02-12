<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum Days: string {
    use EnumHelper;

    case DAY_MONDAY = 'Понедельник';
    case DAY_TUESDAY = 'Вторник';
    case DAY_WEDNESDAY = 'Среда';
    case DAY_THURSDAY = 'Четверг';
    case DAY_FRIDAY = 'Пятница';
    case DAY_SATURDAY = 'Суббота';
    case DAY_SUNDAY = 'Воскресенье';
}
