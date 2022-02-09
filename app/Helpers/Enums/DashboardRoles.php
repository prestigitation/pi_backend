<?php
namespace App\Helpers\Enums;

use App\Helpers\Traits\EnumHelper;

enum DashboardRoles: string {
    use EnumHelper;

    case ROLE_USER = 'Пользователь';
    case ROLE_ADMIN = 'Администратор';
    case ROLE_LABORANT = 'Лаборант';
    case ROLE_TEACHER = 'Преподаватель';
    case ROLE_STUDENT = 'Студент';
    case ROLE_OWNER = 'Заведующий кафедрой';
    case ROLE_ENGINEER = 'Инженер-программист';
}
