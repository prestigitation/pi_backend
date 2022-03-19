<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Repositories\PositionRepository;

class PositionController extends BaseController {
    private $positionRepository;
    public function __construct(PositionRepository $positionRepository) {
        $this->positionRepository = $positionRepository;
    }

    public function getAll() {
        return $this->positionRepository->getAll();
    }
}
