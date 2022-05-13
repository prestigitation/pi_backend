<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

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
}
