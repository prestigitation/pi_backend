<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Helpers\Traits\EnumHelper;
use App\Helpers\Enums\Days;
use App\Models\Day;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(EnumHelper::getValues(Days::cases()) as $day) {
            Day::create([
                'name' => $day
            ]);
        }
    }
}
