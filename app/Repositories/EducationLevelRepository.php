<?php

namespace App\Repositories;

use App\Models\EducationLevel;

class EducationLevelRepository {
    public function loadAll() {
        return EducationLevel::query();
    }

    public function getAll()
    {
        return $this->loadAll()->get();
    }
}
