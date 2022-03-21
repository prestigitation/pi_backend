<?php

namespace Database\Seeders;

use App\Models\PairFormat;
use Illuminate\Database\Seeder;

class PairFormatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pairFormats = [
            [
                'name' => 'лекция'
            ],
            [
                'name' => 'практика'
            ],
            [
                'name' => 'лаб'
            ],
            [
                'name' => 'лаб- 1 подгр.'
            ],
            [
                'name' => 'лаб- 2 подгр.'
            ]
        ];
        foreach($pairFormats as $format) {
            $pairFormat = new PairFormat;
            $pairFormat->name = $format['name'];
            $pairFormat->save();
        }
    }
}
