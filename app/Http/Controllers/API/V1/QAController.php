<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Repositories\QARepository;

class QAController extends Controller
{
    private $QARepository;
    public function __construct(QARepository $QARepository) {
        $this->QARepository = $QARepository;
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
}
