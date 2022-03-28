<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\FilterScheduleRequest;
use App\Models\Schedule;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Classes\ScheduleFiller;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
     * Скачать расписание. По умолчанию, затрагиваются все столбцы расписания
     * @return resource
     */
    public function downloadSchedule(Request $request) {
        $fileName = $request->file_name ?? 'Расписание';
        $file = public_path("sch/$fileName.xlsx");
        if(isset($request->filter)) {
            $schedule = $this->scheduleRepository->filter(json_decode($request->filter));
        } else $schedule = Schedule::all();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $scheduleFiller = new ScheduleFiller($sheet, $schedule->toArray());
        $scheduleFiller->fillSchedule();
        try {
            $writer = new Xlsx($spreadsheet);
            $writer->save($file);
            return response()->download($file)->deleteFileAfterSend(true);
        } catch (\Exception $e) {
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
