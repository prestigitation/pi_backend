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
        $groups = [
            [
                'name' => 'РФ21ДР62ПИ1',
                'headman_id' => 1,
                'curator_id' => 2,
                'study_variant_id' => 1,
                'is_active' => true,
                'direction_id' => 3
            ],
            [
                'name' => 'РФ21ДР62ИиИТО1',
                'headman_id' => 1,
                'curator_id' => 11,
                'study_variant_id' => 1,
                'is_active' => true,
                'direction_id' => 1
            ],
            [
                'name' => 'РФ20ДР62ПИ1',
                'headman_id' => 1,
                'curator_id' => 5,
                'study_variant_id' => 1,
                'is_active' => true,
                'direction_id' => 3
            ],
            [
                'name' => 'РФ20ДР62ИиИТО1',
                'headman_id' => 1,
                'curator_id' => 9,
                'study_variant_id' => 1,
                'is_active' => true,
                'direction_id' => 1
            ],
            [
                'name' => 'РФ19ДР62ПИ1',
                'headman_id' => 1,
                'curator_id' => 13,
                'study_variant_id' => 1,
                'is_active' => true,
                'direction_id' => 3
            ],
            [
                'name' => 'РФ19ДР62ИиИТО1',
                'headman_id' => 1,
                'curator_id' => 3,
                'study_variant_id' => 1,
                'is_active' => true,
                'direction_id' => 1
            ],
            [
                'name' => 'РФ18ДР62ПИ1',
                'headman_id' => 1,
                'curator_id' => 8,
                'study_variant_id' => 1,
                'is_active' => true,
                'direction_id' => 3
            ],
            [
                'name' => 'РФ18ДР62ИиИТО1',
                'headman_id' => 1,
                'curator_id' => 6,
                'study_variant_id' => 1,
                'is_active' => true,
                'direction_id' => 1
            ]
    ];
        foreach($groups as $group) {
            $newGroup = new Group;
            $newGroup->fill($group);
            $newGroup->save();
        }
    }
}
