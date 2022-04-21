<?php

namespace Database\Seeders;

use App\Models\Audience;
use Illuminate\Database\Seeder;

class AudienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $audiences = [
            [
                'name' => '30',
                'capacity' => 12
            ],
            [
                'name' => '29',
                'capacity' => 12
            ],
            [
                'name' => '26',
                'capacity' => 10
            ],
            [
                'name' => '25',
                'capacity' => 25
            ]
        ];

        foreach($audiences as $audience) {
            Audience::create([
                'name' => $audience['name'],
                'capacity' => $audience['capacity']
            ]);
        }
    }
}
