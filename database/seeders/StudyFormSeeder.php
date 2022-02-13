<?php

namespace Database\Seeders;

use App\Helpers\Enums\StudyForms;
use App\Models\StudyForm;
use Illuminate\Database\Seeder;

use App\Helpers\Traits\EnumHelper;

class StudyFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(EnumHelper::getValues(StudyForms::cases()) as $studyFormName) {
            StudyForm::create([
                'name' => $studyFormName
            ]);
        }
    }
}
