<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Без привязки к неделе',
                'marker_color' => null,
                'value' => 'regular'
            ],
            [
                'name' => 'Четная неделя',
                'marker_color' => 'blue',
                'value' => 'even'
            ],
            [
                'name' => 'Нечетная неделя',
                'marker_color' => 'red',
                'value' => 'odd'
            ]
        ];

        foreach($types as $type) {
            Type::create([
                'name' => $type['name'],
                'marker_color' => $type['marker_color'],
                'value' => $type['value']
            ]);
        }
    }
}
