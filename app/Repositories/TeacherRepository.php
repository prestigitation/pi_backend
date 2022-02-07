<?php

namespace App\Repositories;

use App\Models\User;
use App\Helpers\Enums\DashboardRoles;

class TeacherRepository
{
    public function getAll()
    {
        return User::ofRole(DashboardRoles::ROLE_TEACHER->value)
                            ->leftJoin('teachers', 'users.id', '=', 'teachers.id')
                            ->select([
                                'teachers.avatar_path',
                                'teachers.position',
                                'users.id',
                                'users.name',
                                'users.surname',
                                'users.patronymic',
                                'users.phone',
                                'users.email',
                                'users.created_at'
                            ])
                            ->paginate(10);
    }
}

