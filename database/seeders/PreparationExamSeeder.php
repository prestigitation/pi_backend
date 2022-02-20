<?php

namespace Database\Seeders;

use App\Models\PreparationExam;
use Illuminate\Database\Seeder;

class PreparationExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exams = [
            [
                'subject_name' => 'Педагогическая информатика',
                'additional_info' => 'экзамен'
            ],
            [
                'subject_name' => 'Иностранный язык',
                'additional_info' => 'тестирование в Рыбницком Филиале ПГУ им.Т.Г.Шевченко'
            ]
        ];

        foreach($exams as $exam) {
            PreparationExam::create([
                'subject_name' => $exam['subject_name'],
                'additional_info' => $exam['additional_info']
            ]);
        }
    }
}
