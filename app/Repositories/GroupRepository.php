<?php

namespace App\Repositories;

use App\Models\Group;

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
