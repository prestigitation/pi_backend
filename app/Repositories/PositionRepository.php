<?php
namespace App\Repositories;

use App\Helpers\Enums\TeacherPositions;
use App\Models\TeacherPosition;

class PositionRepository {
    public function getAll() {
        return TeacherPosition::all();
    }

}
