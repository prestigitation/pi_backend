<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert(DB::raw("INSERT INTO `schedules` (`id`, `group_id`, `day_id`, `pair_number_id`, `regularity`, `deleted_at`, `deletion_author_id`, `created_at`, `updated_at`) VALUES
        (4, 2, 2, 2, '[{\"type\": {\"id\": 2, \"name\": \"Четная неделя\", \"value\": \"even\", \"created_at\": \"2022-03-25T19:16:48.000000Z\", \"updated_at\": \"2022-03-25T19:16:48.000000Z\", \"marker_color\": \"blue\"}, \"subject\": {\"id\": 1, \"name\": \"Математика\", \"created_at\": \"2022-03-25T19:16:48.000000Z\", \"updated_at\": \"2022-03-25T19:16:48.000000Z\"}, \"teacher\": {\"id\": 1, \"name\": \"Татьяна\", \"slug\": \"nikitina-tatyana-ivanovna\", \"surname\": \"Никитина\", \"position\": \"Старший преподаватель\", \"subjects\": [], \"created_at\": \"2022-03-25T19:16:51.000000Z\", \"patronymic\": \"Ивановна\", \"updated_at\": \"2022-03-25T19:16:51.000000Z\", \"avatar_path\": null}, \"audience\": {\"id\": 1, \"name\": \"30\", \"capacity\": 12, \"created_at\": \"2022-03-25T19:16:48.000000Z\", \"updated_at\": \"2022-03-25T19:16:48.000000Z\"}, \"study_process\": {\"id\": 1, \"name\": \"дистанционное обучение\", \"created_at\": \"2022-03-25T19:16:48.000000Z\", \"updated_at\": \"2022-03-25T19:16:48.000000Z\"}, \"additional_info\": \"(test)\", \"start_date_info\": \"(test)\"}]', NULL, NULL, '2022-03-26 06:55:19', '2022-03-26 06:55:19');"));
    }
}
