<?php

namespace Database\Seeders;

use App\Models\PairNumber;
use Illuminate\Database\Seeder;

class PairNumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pairs = [
            [
                'number' => 1,
                'start' => '8:30',
                'end' => '10:00'
            ],
            [
                'number' => 2,
                'start' => '10:10',
                'end' => '11:30'
            ],
            [
                'number' => 3,
                'start' => '11:50',
                'end' => '13:10'
            ],
            [
                'number' => 4,
                'start' => '13:30',
                'end' => '14:50'
            ],
            [
                'number' => 5,
                'start' => '15:10',
                'end' => '16:40'
            ],
            [
                'number' => 6,
                'start' => '17:00',
                'end' => '18:30'
            ],
        ];

        foreach($pairs as $pair) {
            PairNumber::create([
                'number' => $pair['number'],
                'start' => $pair['start'],
                'end' => $pair['end']
            ]);
        }
    }
}
