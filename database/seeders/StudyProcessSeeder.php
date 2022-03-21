<?php

namespace Database\Seeders;

use App\Models\StudyProcess;
use Illuminate\Database\Seeder;

class StudyProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $processes = [
            [
                'name' => 'дистанционное обучение'
            ],
            [
                'name' => 'аудиторное обучение'
            ]
        ];

        foreach($processes as $process) {
            $newProcess = new StudyProcess;
            $newProcess->name = $process['name'];
            $newProcess->save();
        }
    }
}
