<?php

namespace Database\Seeders;

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
        $profiles = [
            [
                'name' => 'Педагогическое образование'
            ],
            [
                'name' => 'Программная инженерия'
            ]
        ];

        foreach($profiles as $profile) {
            Profile::create([
                'name' => $profile['name'],
            ]);
        }
    }
}
