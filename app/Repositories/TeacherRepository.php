<?php

namespace App\Repositories;

use App\Models\User;
use App\Helpers\Enums\DashboardRoles;
use App\Helpers\Enums\TeacherPositions;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class TeacherRepository
{
    private $fileRepository;

    public function __construct(FileRepository $fileRepository) {
        $this->fileRepository = $fileRepository;
    }

    public function loadAll() {
        return User::ofRole(DashboardRoles::ROLE_TEACHER->value)
                            ->leftJoin('teachers', 'users.id', '=', 'teachers.user_id')
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
                            ]);
    }

    public function getAll()
    {
        return $this->loadAll()->paginate(10);
    }

    public function getRoleId(string $name): int {
        return Role::where('name', $name)->first()->id;
    }

    public function setAvatar(int $id, mixed $file)
    {
        $avatarPath = $file['avatar']->store('public/teachers');
        $avatarLink = $this->fileRepository->getFileLink($avatarPath); // cсылка на файл относительно сервера
        DB::update('UPDATE teachers SET avatar_path = ? WHERE id = ?', [$avatarLink, $id]);
    }


    /**
     * @return int
     * id роли, которая будет привязана преподавателю
     */
    public function switchRoles(?string $roleName)
    {
        switch($roleName) {
            case TeacherPositions::POSITION_SENIOR_LABORANT->value: {
                return $this->getRoleId(DashboardRoles::ROLE_LABORANT->value);
            }
            case TeacherPositions::POSITION_ENGINEER->value: {
                return $this->getRoleId(DashboardRoles::ROLE_ENGINEER->value);
            }
            case DashboardRoles::ROLE_OWNER->value: {
                return $this->getRoleId(DashboardRoles::ROLE_OWNER->value);
            }
            default: {
                return $this->getRoleId(DashboardRoles::ROLE_TEACHER->value);
            }
        }
    }
}

