<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepository {
    public function loadAll()
    {
        return Subject::query();
    }

    public function getPaginated() {
        return $this->loadAll()->paginate(10);
    }

    public function getAll() {
        return $this->loadAll()->get();
    }
}
