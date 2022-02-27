<?php

namespace App\Repositories;

use App\Models\Day;

class DayRepository {
    public function loadAll() {
        return Day::query();
    }

    public function getAll()
    {
        return $this->loadAll()->get();
    }
}
