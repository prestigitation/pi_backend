<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Helpers\Classes\Parity;
use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Requests\Date\SetDatesRequest;
use App\Repositories\DateRepository;

class DateController extends BaseController {
    private $parity;
    private $dateRepository;
    public function __construct(Parity $parity, DateRepository $dateRepository) {
        $this->parity = $parity;
        $this->dateRepository = $dateRepository;
    }
    public function getParity(): mixed {
        return $this->parity->getSemesterStart();
    }

    public function getDates() {
        try {
            return $this->dateRepository->getDates();
        } catch (\Exception $e) {
            return $this->sendError('Не удалось получить даты');
        }
    }
    public function setDates(SetDatesRequest $request) {
        try {
            $this->dateRepository->setDates($request->validated());
            return $this->sendResponse(null, 'Даты были изменены!');
        } catch (\Exception $e) {
            return $this->sendError('Не удалось изменить даты');
        }
    }
}
