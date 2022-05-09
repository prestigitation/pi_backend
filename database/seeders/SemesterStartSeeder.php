<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\DB;

class SemesterStartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semester_start')->insert(['date' => new Date('third day February 2022')]);
    }
}
