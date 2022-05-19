<?php
namespace App\Repositories;

use App\Models\Day;
use Illuminate\Support\Facades\DB;
use Jenssegers\Date\Date;

class DateRepository {
    public function getDates() {
        return [
            'semester_start_date' => DB::table('semester_start')->first()->date
        ];
    }

    public function setDates(array $data) {
        if(isset($data['semester_start_date'])) {
            DB::table('semester_start')->where('id', 1)->update(['date' => $data['semester_start_date']]);
        }
    }

    public function getCurrentDay() {
        return Day::where('id', Date::now()->dayOfWeek)->first();
    }
}
