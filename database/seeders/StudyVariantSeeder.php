<?php

namespace Database\Seeders;

use App\Helpers\Enums\TimeForms;
use Illuminate\Database\Seeder;

use App\Helpers\Traits\EnumHelper;
use App\Models\StudyVariant;
use App\Models\TimeForm;

class StudyVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $full = TimeForm::where('name', TimeForms::TIME_FULL->value)->first()->id;
        $dist = TimeForm::where('name', TimeForms::TIME_DISTANCE->value)->first()->id;
        $variants = [
            [
                'years' => 4,
                'time_form_id' => $full
            ],
            [
                'years' => 2,
                'time_form_id' => $full
            ],
            [
                'years' => 2,
                'months' => 3,
                'time_form_id' => $dist
            ],
            [
                'years' => 2,
                'months' => 4,
                'time_form_id' => $dist
            ],
            [
                'years' => 4,
                'months' => 8,
                'time_form_id' => $dist
            ],
            [
                'years' => 2,
                'months' => 6,
                'time_form_id' => $dist
            ]
        ];

        foreach($variants as $variant) {
            $newVariant = new StudyVariant();
            $newVariant->years = $variant['years'];
            $newVariant->time_form_id = $variant['time_form_id'];
            if(isset($variant['months'])) $newVariant->months = $variant['months'];
            $newVariant->save();
        }
    }
}
