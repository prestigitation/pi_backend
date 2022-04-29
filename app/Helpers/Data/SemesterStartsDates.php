<?php
namespace App\Helpers\Data;

use Jenssegers\Date\Date;

function getSemesterStartDates() {
    $semesterStartDates = [
        new Date('third day of February 2021'),
        new Date('first day of September 2021'),
        new Date('third day of February 2022')
    ];
    return $semesterStartDates;
}
