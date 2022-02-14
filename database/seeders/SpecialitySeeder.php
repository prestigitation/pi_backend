<?php

namespace Database\Seeders;

use App\Models\Speciality;
use App\Helpers\Enums\Specialities;
use Illuminate\Database\Seeder;

use App\Helpers\Traits\EnumHelper;

class SpecialitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(EnumHelper::getValues(Specialities::cases()) as $index => $role) {
            Speciality::create([
                'id' => $index + 1,
                'name' => $role
            ]);
        }
    }
}
