<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\Dashboard\QAController as DashboardQAController;
use App\Http\Controllers\Controller;
use App\Http\Requests\QA\StoreQuestionRequest;
use App\Models\Question;
use App\Repositories\QARepository;

class QAController extends Controller
{
    private $QARepository;
    private $QADashboardController;
    public function __construct(QARepository $QARepository, DashboardQAController $dc) {
        $this->QARepository = $QARepository;
        $this->QADashboardController = $dc;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->QARepository->scopeQuery(function(Question $question) {
            return $question->answered();
        })->get(['question', 'answer']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        return $this->QADashboardController->store($request);
    }
}
