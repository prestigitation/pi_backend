<?php
namespace App\Helpers\Classes;

use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;

class Parity {
    /**
     * Получить дату начала семестра
     */
    public function getSemesterStart() {
        $nearestDate = new Date($this->getNearestStartDate());
        $diff = $nearestDate->diffInWeeks(new Date());
        if($diff + 1 % 2 == 0) {
            return [
                'week' => 'Четная',
                'value' => 'even',
            ];
        } else return [
            'week' => 'Нечетная',
            'value' => 'odd'
        ];
    }

    /**
     * Нахождение даты начала текущего семестра
     */
    private function getNearestStartDate() {
        return DB::table('semester_start')->first()->date;
    }
}
