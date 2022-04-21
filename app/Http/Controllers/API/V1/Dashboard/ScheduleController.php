<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Events\ScheduleTableModified;
use App\Helpers\Enums\DashboardRoles;
use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Controllers\API\V1\ScheduleController as ApiScheduleController;
use App\Http\Requests\Schedule\StoreScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Http\Resources\ScheduleVersionResource;
use App\Models\ScheduleVersion;
use App\Models\Teacher;
use App\Models\User;
use App\Repositories\ScheduleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends BaseController
{
    private $scheduleRepository;
    private $apiScheduleController;

    public function __construct(ScheduleRepository $scheduleRepository, ApiScheduleController $apiScheduleController) {
        $this->scheduleRepository = $scheduleRepository;
        $this->apiScheduleController = $apiScheduleController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->scheduleRepository->getPaginated();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreScheduleRequest $request)
    {
        try {
            $this->scheduleRepository->create($request->validated());
            return $this->sendResponse(null, 'Запись в расписании была успешно добавлена!');
        } catch(\Exception $e) {
            dd($e->getMessage());
            return $this->sendError('Не удалось добавить новую запись в расписании');
        }
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
    public function update(UpdateScheduleRequest $request, $id)
    {
        try {
            $this->scheduleRepository->update($request->validated(), $id);
            event(new ScheduleTableModified);
            return $this->sendResponse(null, 'Информация о расписании была успешно обновлена!');
        } catch (\Exception $e) {
            return $this->sendError('Не удалось добавить новую запись в расписании');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, Request $request)
    {
        try {
            $this->scheduleRepository->delete($id);
            event(new ScheduleTableModified);
            return $this->sendResponse(null, 'Информация о части расписания была успешно удалена!');
        } catch (\Exception $e) {
            return $this->sendError('Запись в расписании не была удалена, возникла ошибка.');
        }
    }

    public function getMySchedule() {
        try {
            return $this->scheduleRepository->getMySchedule();
        } catch (\Exception $e) {
            return $this->sendError('Не удалось получить собственное расписание!');
        }
    }

    public function getVersions() {
        return new ScheduleVersionResource(ScheduleVersion::paginate(10));
    }

    public function makeSnapshot() {
        try {
            Artisan::call('schedule:snapshot');
            return $this->sendResponse(null, 'Расписание было успешно зафиксировано!');
        } catch (\Exception $e) {
            return $this->sendError('Не удалось зафиксировать расписание!');
        }
    }
}
