<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Helpers\Classes\Parity;
use App\Http\Controllers\API\V1\Dashboard\BaseController;

class DateController extends BaseController {
    private $parity;
    public function __construct(Parity $parity) {
        $this->parity = $parity;
    }
    public function getParity(): mixed {
        return $this->parity->getSemesterStart();
    }
}
