<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Repositories\StudyProcessRepository;
use Illuminate\Http\Request;

class StudyProcessController extends BaseController
{
    private $studyProcessRepository;
    public function __construct(StudyProcessRepository $studyProcessRepository) {
        $this->studyProcessRepository = $studyProcessRepository;
    }

    public function getAll() {
        return $this->studyProcessRepository->get();
    }
}
