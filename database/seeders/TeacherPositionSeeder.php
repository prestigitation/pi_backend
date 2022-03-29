<?php

namespace Database\Seeders;

use App\Models\TeacherPosition;
use Illuminate\Database\Seeder;

class TeacherPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            [
                'name' => 'Преподаватель',
                'abbreviated' => 'преп.'
            ],
            [
                'name' => 'Старший преподаватель',
                'abbreviated' => 'ст. преп.'
            ],
            [
                'name' => 'Доцент',
                'abbreviated' => 'доцент'
            ],
            [
                'name' => 'Инженер-программист',
            ],
            [
                'name' => 'Cтарший лаборант',
            ]
        ];

        foreach($positions as $position) {
            $pos = new TeacherPosition;
            $pos->name = $position['name'];
            if(isset($position['abbreviated'])) {
                $pos->abbreviated = $position['abbreviated'];
            }
            $pos->save();
        }
    }
}
