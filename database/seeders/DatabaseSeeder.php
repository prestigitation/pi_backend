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
            QASeeder::class,
            StudyProcessSeeder::class,
            PairFormatSeeder::class,
            AudienceSeeder::class,
            SpecialitySeeder::class,
            TypeSeeder::class,
            SubjectSeeder::class,
            CategorySeeder::class,
            ProfileSeeder::class,
            StudyFormSeeder::class,
            TimeFormSeeder::class,
            StudyVariantSeeder::class,
            PaymentFormSeeder::class,
            RoleSeeder::class,
            UsersTableSeeder::class,
            RegaliaSeeder::class,
            EducationLevelSeeder::class,
            TeacherSeeder::class,
            DaySeeder::class,
            PairNumberSeeder::class,
            PreparationExamSeeder::class,
            DirectionSeeder::class,
            GroupSeeder::class,
        ]);
    }
}
