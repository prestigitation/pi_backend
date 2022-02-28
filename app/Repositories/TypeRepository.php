<?php

namespace App\Repositories;

use App\Models\Type;

class TypeRepository {
    public function loadAll() {
        return Type::query();
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
