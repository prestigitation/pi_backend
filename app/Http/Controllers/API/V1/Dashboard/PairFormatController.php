<?php


namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;

use App\Http\Controllers\Controller;
use App\Repositories\PairFormatRepository;
use Illuminate\Http\Request;

class PairFormatController extends BaseController
{
    private $pairFormatRepository;
    public function __construct(PairFormatRepository $pairFormatRepository) {
        $this->pairFormatRepository = $pairFormatRepository;
    }

    public function getAll() {
        return $this->pairFormatRepository->get();
    }
}
