<?php

namespace App\Helpers\Functions;

use App\Models\Role;

class FilterRolesNames
{
    public function getRolesNames(array $rolesData)
    {
        return array_map(function($role) {
            return $role['name'];
        }, $rolesData);
    }

    public function duplicateRole(int $roleId, array $roles)
    {
        $rolesId = array_map(function($role) {
            return $role['id'];
        }, $roles);

        return count(array_intersect($rolesId, [$roleId]));
    }

}
