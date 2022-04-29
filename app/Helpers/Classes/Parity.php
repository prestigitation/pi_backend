<?php
namespace App\Helpers\Classes;
use Jenssegers\Date\Date;

class Parity {

    private $startDates;
    public function __construct() {

        $this->startDates = [
            new Date('second day February 2021'),
            new Date('first day September 2021'),
            new Date('second day February 2022')
        ];
    }
    /**
     * Получить дату начала семестра
     */
    public function getSemesterStart() {
        $nearestDate = new Date($this->getNearestStartDate());
        $diff = $nearestDate->diffInWeeks(new Date());
        if($diff % 2 === 0) {
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
        $newDates = array();
        foreach($this->startDates as $date)
        {
            $newDates[] = strtotime($date);
        }
        sort($newDates);
        foreach ($newDates as $index => $time)
        {
            if ($time >= strtotime(new Date)) //текущая дата
            return $newDates[$index - 1];
        }
        return $newDates[count($newDates) - 1];
    }
}
