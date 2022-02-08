<?php

namespace App\Repositories;

use App\Models\User;
use App\Helpers\Enums\DashboardRoles;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeacherRepository
{
    private $fileRepository;

    public function __construct(FileRepository $fileRepository) {
        $this->fileRepository = $fileRepository;
    }

    public function loadAll() {
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
                            ]);
    }

    public function getAll()
    {
        return $this->loadAll()->paginate(10);
    }


    public function setAvatar(int $id, mixed $file) {
        $avatarPath = $file['avatar']->store('public/teachers');
        $avatarLink = $this->fileRepository->getFileLink($avatarPath); // cсылка на файл относительно сервера
        DB::update('UPDATE teachers SET avatar_path = ? WHERE id = ?', [$avatarLink, $id]);
    }
}

