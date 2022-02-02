<?php
namespace App\Helpers\Enums;

enum DashboardRoles: string {
    case ROLE_USER = 'user';
    case ROLE_ADMIN = 'admin';

    case ROLE_LABORANT = 'laborant';

    case ROLE_TEACHER = 'teacher';
    case ROLE_STUDENT = 'student';

    //зав.кафедры
    case ROLE_OWNER = 'owner';

}
