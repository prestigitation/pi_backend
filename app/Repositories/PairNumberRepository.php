<?php

namespace App\Repositories;

use App\Models\PairNumber;

class PairNumberRepository {
    public function loadAll() {
        return PairNumber::query();
    }

    public function getAll()
    {
        return $this->loadAll()->get();
    }

    public function getPaginated()
    {
        return $this->loadAll()->paginate(10);
    }

}
