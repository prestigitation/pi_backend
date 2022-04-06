<?php

namespace App\Repositories;



use App\Models\Day;
use Prettus\Repository\Eloquent\BaseRepository;

class DayRepository extends BaseRepository {
    public function model() {
        return Day::class;
    }
}
