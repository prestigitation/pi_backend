<?php
namespace App\Repositories;

use App\Helpers\Enums\TeacherPositions;

class PositionRepository {
    public function getAll() {
        return TeacherPositions::getValues(TeacherPositions::cases());
    }

}
