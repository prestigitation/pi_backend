<?php

namespace App\Repositories;

use App\Helpers\Enums\DashboardRoles;
use App\Models\Group;
use App\Models\Role;
use App\Models\User;

class GroupRepository
{
    public function loadAll() {
        return Group::query();
    }

    public function getAll()
    {
        return $this->loadAll()->get();
    }

    public function getPaginated() {
        return $this->loadAll()->paginate(10);
    }

    public function setGroupInfo(Group $group, array $data) {
        $group->name = $data['name'];
        $group->headman_id = $data['headman_id'];
        $group->direction_id = $data['direction_id'];
        $group->is_active = $data['is_active'];
        $group->curator_id = $data['curator_id'];
        $group->study_variant_id = $data['study_variant_id'];
        if(isset($data['users']) && count($data['users'])) {
            array_push($data['users'], ['id' => $data['headman_id']]); // т.к староста тоже является студентом, добавляем его в список пользователей
            foreach($data['users'] as $user) {
                $user = User::find($user['id']);
                if(!$user->isStudent()) { // если на момент привязки пользователь группы не является студентом
                    $studentRole = Role::where('name', DashboardRoles::ROLE_STUDENT->value)->first();
                    $user->roles()->attach($studentRole);
                }
                $group->users()->detach();
                $group->users()->attach($user);
            }
        }
    }

    public function create(array $data) {
        $group = new Group;
        $this->setGroupInfo($group, $data);
        $group->save();
    }

    public function update(array $data, int $id) {
        $group = Group::find($id);
        $this->setGroupInfo($group, $data);
        $group->save();
    }
}
