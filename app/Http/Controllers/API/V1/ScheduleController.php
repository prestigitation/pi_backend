<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\FilterScheduleRequest;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    private $scheduleRepository;
    public function __construct(ScheduleRepository $scheduleRepository) {
        $this->scheduleRepository = $scheduleRepository;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->scheduleRepository->getAll();
    }

    /**
     * Фильтр расписания по критериям
     * Например, http://127.0.0.1:8000/api/schedule/filter/?pair_audiences[]=205&pair_numbers[]=1
     * @param \Illuminate\Http\Request $request
     * @return Schedule[] | \Illuminate\Http\Response
     */
    public function filter(Request $request) {
            try {
                $filterScheduleRequest = new FilterScheduleRequest;
                $validated = Validator::validate(json_decode($request->request->get('filter_string'), true), $filterScheduleRequest->rules());
                if(!count($validated)) {
                    return new Response('Вы не указали ни одного параметра фильтрации', 400);
                }
                return $this->scheduleRepository->filter($validated);
            } catch(\Exception $e) {
                dd($e->getMessage());
            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
