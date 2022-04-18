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
use App\Http\Requests\Schedule\DownloadScheduleRequest;
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
        return $this->scheduleRepository->getPaginated();
    }

    /**
     * Фильтр расписания по критериям
     * Например, http://127.0.0.1:8000/api/schedule/filter/?pair_audiences[]=205&pair_numbers[]=1
     * @param \Illuminate\Http\Request $request
     * @return Schedule[] | \Illuminate\Http\Response
     */
    public function filter(Request $request, array $data = null) {
            try {
                $filterScheduleRequest = new FilterScheduleRequest;
                $validated = Validator::validate($data ?? json_decode($request->request->get('filter_string'), true), $filterScheduleRequest->rules());
                if(!count($validated)) {
                    return new Response('Вы не указали ни одного параметра фильтрации', 400);
                }
                return $this->scheduleRepository->filter($validated);
            } catch(\Exception $e) {
                dd($e->getMessage());
                return new Response('Не удалось получить расписание', 400);
            }
    }

    /**
     * Скачать расписание. По умолчанию, затрагиваются все столбцы расписания
     * @return resource
     */
    public function downloadSchedule(DownloadScheduleRequest $request) {
        $savedSchedulePath = $this->scheduleRepository->saveSchedule($request);
        return response()->download($savedSchedulePath)->deleteFileAfterSend(true);
    }
}
