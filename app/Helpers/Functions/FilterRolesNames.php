<?php

namespace App\Helpers\Functions;

use App\Helpers\Traits\EnumHelper;

class FilterRolesNames
{
    use EnumHelper;
    public function getRolesNames(array $roles)
    {
        return EnumHelper::getValues($roles);
    }

    public function duplicateRole(int $roleId, array $roles)
    {
        $rolesId = array_map(function($role) {
            return $role['id'];
        }, $roles);

        return count(array_intersect($rolesId, [$roleId]));
    }

}
