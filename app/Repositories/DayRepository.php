<?php

namespace App\Repositories;



use App\Models\Day;
use Jenssegers\Date\Date;
use Prettus\Repository\Eloquent\BaseRepository;

class DayRepository extends BaseRepository {
    public function model() {
        return Day::class;
    }

    public function getCurrentDayId(): int {
        Date::setLocale('ru');
        $currentDay = Date::now()->format('l'); // Получаем сегодняшний день
        return $currentDayId = Day::where('name', mb_convert_case($currentDay, MB_CASE_TITLE))->first()->id;}
}
