<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum Regalias: string {
    use EnumHelper;

    case REGALIA_ECONOMY_CANDIDAT = 'Кандидат экономических наук';
    case REGALIA_DEPARTMENT_OWNER = 'Заведующий кафедрой';
    case REGALIA_TECH_CANDIDAT = 'Кандидат технических наук';
    case REGALIA_TEACHER_CANDIDAT = 'Кандидат педагогических наук';
    case REGALIA_LEAD_SPECIALIST = 'Ведущий специалист';
}
