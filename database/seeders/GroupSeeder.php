<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [[
            'name' => 'РФ21ДР62ПИ1',
            'headman_id' => 1,
            'curator_id' => 2,
            'study_variant_id' => 1,
            'is_active' => true,
            'direction_id' => 3
        ]];
        foreach($groups as $group) {
            $newGroup = new Group;
            $newGroup->fill($group);
            $newGroup->save();
        }
    }
}
