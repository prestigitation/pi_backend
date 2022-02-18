<?php

namespace App\Repositories;

use App\Models\Direction;

class DirectionRepository {
    public function getAll() {
        return Direction::all();
    }
}
