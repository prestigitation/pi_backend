<?php

namespace App\Repositories;

use App\Models\Schedule;

class ScheduleRepository {
    public function loadAll()
    {
        return Schedule::query();
    }

    public function getPaginated() {
        return $this->loadAll()->paginate(10);
    }

    public function getAll() {
        return $this->loadAll()->get();
    }

}
