<?php

namespace Database\Seeders;

use App\Helpers\Enums\TimeForms;
use App\Models\TimeForm;
use Illuminate\Database\Seeder;

use App\Helpers\Traits\EnumHelper;

class TimeFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(EnumHelper::getValues(TimeForms::cases()) as $studyFormName) {
            TimeForm::create([
                'name' => $studyFormName
            ]);
        }
    }
}
