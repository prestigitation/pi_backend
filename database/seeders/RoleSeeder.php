<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Helpers\Enums\DashboardRoles;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(DashboardRoles::cases() as $index => $role) {
            Role::create([
                'id' => $index + 1,
                'name' => $role->value
            ]);
        }
    }
}
