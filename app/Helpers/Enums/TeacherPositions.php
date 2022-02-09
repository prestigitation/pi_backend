<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum TeacherPositions: string {
    use EnumHelper;

    case POSITION_LECTURER = 'Преподаватель';
    case POSITION_SENIOR_LECTURER = 'Старший преподаватель';
    case POSITION_DOCENT = 'Доцент';
    case POSITION_ENGINEER = 'Инженер-программист';
    case POSITION_SENIOR_LABORANT = 'Cтарший лаборант';
}
