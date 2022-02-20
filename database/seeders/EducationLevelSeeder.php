<?php

namespace Database\Seeders;

use App\Helpers\Enums\EducationLevels;
use App\Models\EducationLevel;
use Illuminate\Database\Seeder;

class EducationLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(EducationLevels::getValues(EducationLevels::cases()) as $level) {
            EducationLevel::create([
                'name' => $level
            ]);
        }
    }
}
