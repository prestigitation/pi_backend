<?php

namespace Database\Seeders;

use App\Helpers\Enums\Profiles;
use App\Helpers\Traits\EnumHelper;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(EnumHelper::getValues(Profiles::cases()) as $profile) {
            Profile::create([
                'name' => $profile
            ]);
        }
    }
}
