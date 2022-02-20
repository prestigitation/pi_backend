<?php

namespace Database\Seeders;

use App\Helpers\Enums\Regalias;
use App\Models\Regalia;
use Illuminate\Database\Seeder;

class RegaliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(Regalias::getValues(Regalias::cases()) as $regalia) {
            Regalia::create([
                'name' => $regalia
            ]);
        }
    }
}
