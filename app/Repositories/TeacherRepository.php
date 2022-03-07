<?php

namespace App\Repositories;

use App\Helpers\Enums\DashboardRoles;
use App\Helpers\Enums\TeacherPositions;
use App\Models\Role;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class TeacherRepository
{
    private $userRepository;
    private $fileRepository;

    public function __construct(FileRepository $fileRepository, UserRepository $userRepository) {
        $this->fileRepository = $fileRepository;
        $this->userRepository = $userRepository;
    }

    public function loadAll() {
        return Teacher::query();
    }

    public function getAll()
    {
        return $this->loadAll()->paginate(10);
    }

    public function getRoleId(string $name): int {
        return Role::where('name', $name)->first()->id;
    }


    /**
     * Заполняет данные о преподавателе, возвращая заполненную модель
     * @return App\Models\Teacher
     */
    public function fillTeacherData(Teacher $teacher, array $data): Teacher {
        $teacher->education_level_id = $data['education_level_id'];
        if(isset($data['user_id'])) {
            $teacher->user_id = $data['user_id'];
        }
        if(isset($teacher['position'])) {
            $teacher->position = $data['position'];
        }
        if(isset($teacher['avatar_path'])) {
            $teacher->avatar_path = $data['avatar_path'];
        }
        if(isset($teacher['education'])) {
            $teacher->education = $data['education'];
        }
        if(isset($data['dissertification_proof'])) {
            $teacher->dissertification_proof = $data['dissertification_proof'];
        }

        return $teacher;
    }

    public function create(array $data)
    {
        $teacherRole = $this->getRoleId(DashboardRoles::ROLE_TEACHER->value);
        $user = $this->userRepository->create($data);
        $this->userRepository->setRole($user->id, $teacherRole);
        $teacher = new Teacher;
        $teacher->user_id = $user->id;
        $this->fillTeacherData($teacher, $data);
        //TODO: добавить на фронте нужные поля, и записать сюда - fillTeacherData
        $teacher->save();
    }

    public function update(array $data, int $id)
    {
        $teacher = Teacher::find($id);
        $this->fillTeacherData($teacher, $data);
        $teacher->save();
    }

    /*public function update(array $data, int $id)
    {
        $teacher = Teacher::find($id);
    }*/

    public function setAvatar(int $id, mixed $file)
    {
        $avatarPath = $file['avatar']->store('public/teachers');
        $avatarLink = $this->fileRepository->getFileLink($avatarPath); // cсылка на файл относительно сервера
        DB::update('UPDATE teachers SET avatar_path = ? WHERE user_id = ?', [$avatarLink, $id]);
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

    public function findBySlug(string $slug): Teacher {
        return Teacher::where('slug', $slug)->first();
    }
}

