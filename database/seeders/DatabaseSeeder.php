<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SpecialitySeeder::class,
            StudyVariantSeeder::class,
            ProfileSeeder::class,
            StudyFormSeeder::class,
            TimeFormSeeder::class,
            PaymentFormSeeder::class,
            RoleSeeder::class,
            UsersTableSeeder::class,
            TeacherSeeder::class,
            DaySeeder::class,
            PairNumberSeeder::class
        ]);
    }
}
