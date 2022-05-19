<?php

namespace App\Repositories;

use App\Helpers\Classes\BasicQueryHelper;
use App\Helpers\Classes\Parity;
use App\Helpers\Classes\ScheduleFiller;
use App\Helpers\Enums\DashboardRoles;
use App\Http\Controllers\API\V1\Dashboard\RegularityController;
use App\Http\Requests\Regularity\StoreRegularityRequest;
use App\Http\Requests\Schedule\DownloadScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Audience;
use App\Models\Day;
use App\Models\ForeignTeacher;
use App\Models\PairFormat;
use App\Models\Regularity;
use App\Models\Schedule;
use App\Models\StudyProcess;
use App\Models\Subject;
use App\Models\Teachable;
use App\Models\Teacher;
use App\Models\Type;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Date\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as WriterXlsx;
use Stevebauman\Purify\Purify;

class ScheduleRepository {
    private $purifier;
    private $fileRepository;
    private $regularityRepository;
    private $dayRepository;
    private $parity;
    public function __construct(
        Purify $purifier,
        FileRepository $fileRepository,
        RegularityRepository $regularityRepository,
        DayRepository $dayRepository,
        Parity $parity
        )
    {
        $this->purifier = $purifier;
        $this->fileRepository = $fileRepository;
        $this->regularityRepository = $regularityRepository;
        $this->dayRepository = $dayRepository;
        $this->parity = $parity;
    }
    public function loadAll()
    {
        return Schedule::query();
    }

    public function getPaginated($schedule = null) {
        $scheduleQuery = $schedule ?? $this->loadAll();
        return new ScheduleResource($scheduleQuery->paginate(10));
    }

    public function getAll() {
        return $this->loadAll()
        ->orderBy('group_id', 'asc')
        ->orderBy('day_id', 'asc')
        ->get();
    }

    public function fillPairs(array $pairs): array {
        $result = [];
        foreach($pairs as $index => $pair) {
            $newRegularityRequest = new StoreRegularityRequest();
            $validatedRegularity = Validator::validate($pair, $newRegularityRequest->rules());
            $regularity = $this->regularityRepository->create($validatedRegularity);
            $regularity->save();
            if($pair['is_foreign_teacher']) {
                $regularity->foreignTeachers()->attach(ForeignTeacher::find($pair['teacher']));
            } else $regularity->teachers()->attach(Teacher::find($pair['teacher']));
            array_push($result, $regularity->id);
        }
        return $result;
    }

    public function addScheduleInfo(Schedule $schedule, array $data) {
        $schedule->day_id = $data['day_id'];
        $schedule->group_id = $data['group_id'];
        $schedule->pair_number_id = $data['pair_number_id'];
    }

    public function create(array $data)
    {
        $schedule = new Schedule;
        $this->addScheduleInfo($schedule, $data);
        $schedule->save();
        if(isset($data['pairs'])) {
            $regularities = $this->fillPairs($data['pairs']);
            foreach($regularities as $reg) {
                $schedule->regularity()->attach($reg);
            }
        }
    }

    public function update(array $data, int $id)
    {
        $schedule = Schedule::find($id);
        $this->addScheduleInfo($schedule, $data);
        $schedule->save();
    }

    public function delete(int $id) {
        $schedule = Schedule::find($id);
        // идентифицируем id пользователя, удалившего расписание, записываем в базу
        $schedule->deletion_author_id = Auth::id();
        $schedule->save();
        $schedule->delete();
    }

    /**
     * @param array $data
     * @param Builder $query
     * @return Builder $query
     */
    private function filterRegularity(array $regularityInfo, Builder $query) {
        $allowedFields = [
            'audience' => ['id', 'name'],
            'subject' => ['id', 'name'],
            'teacher' => ['id'],
            'foreign_teacher' => ['id'],
            'type' => ['id'],
            'study_process' => ['id']
        ];


        foreach($regularityInfo as $name => $params) {
            if(is_array($params)) {
                foreach($params as $key => $criteria) {

                    if(isset($allowedFields[$name])) {
                        if(in_array(0, $criteria)) {
                            $query->where('regularity', []);
                            break;
                        } else {
                            $models = DB::table(Str::plural($name))->whereIn($key, $criteria)->select($key)->get();
                            foreach($models as $i => $model) {
                                if($name === 'foreign_teacher') {
                                    $query->whereHas('regularity', function (Builder $q) use ($model) {
                                        $q->whereHas('foreignTeachers', function ($q) use ($model) {
                                            foreach((array) $model as $key => $value) {
                                                $q->where('foreign_teachers.'.$key, $value);
                                            }
                                        });
                                    });
                                } else {
                                    if($name === 'teacher') {
                                        $query->whereHas('regularity', function (Builder $q) use ($model) {
                                            $q->whereHas('teachers', function ($q) use ($model) {
                                                foreach((array) $model as $key => $value) {
                                                    $q->where('teachers.'.$key, $value);
                                                }
                                            });
                                        });
                                    } else if ($name === 'type') {
                                            // Поскольку в модели Schedule может быть regularity с разным отношением type(even, odd или regular)
                                            // выбираем только те пункты type, которые удовлетворяют условию в фильтре
                                            foreach((array) $model as $k => $value) {
                                                if(count(array_values($criteria)) > 1) {
                                                    $query->whereHas('regularity.type', function (Builder $q) use ($key, $criteria, $value) {
                                                        $q->whereIn($key, $criteria)
                                                            ->where($key, '<>', $value);
                                                    });
                                                } else {
                                                    $query->whereHas('regularity.type', function ($q) use ($k, $value) {
                                                        $q->where($k, '=', $value);
                                                    })->whereDoesntHave('regularity.type', function ($q) use ($k, $value) {
                                                        $q->where($k, '<>', $value);
                                                    });
                                                }
                                            }
                                    }
                                    else {
                                        $query->whereHas('regularity', function ($q) use ($model, $name) {
                                            $q->whereHas($name, function ($q) use ($model, $name) {
                                                foreach((array) $model as $key => $value) {
                                                    $q->where(Str::plural($name).'.'.$key, $value);
                                                }
                                            });
                                        });
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return $query;
    }

    private function filterPairNumber(array $data, Builder $query) {
        $allowedFields = ['start', 'end', 'number'];
        if(isset($data['pair_number']) && count($data['pair_number'])) {
            foreach($data['pair_number'] as $criteria => $values) {
                $query->whereRelation('pairNumber', function (Builder $q) use ($criteria, $values, $allowedFields) {
                    if(in_array($criteria, $allowedFields)) {
                        $q->whereIn($criteria, $values);
                    } else throw new \Exception("Фильтрация по полю $criteria невозможна");
                });
            }
        }
        return $query;
    }


    public function filter(mixed $data) {
        $query =
        isset($data['deleted']) && $data['deleted'] === true
        ? Schedule::withTrashed()
        : Schedule::query();

        $basicHelper = new BasicQueryHelper($query, $data);
        $basicHelper->query('groups')
                    ->query('days');

        $query = $basicHelper->getBuilder();

        $query = $this->filterPairNumber($data, $query);
        $query = $this->filterRegularity($data, $query);

        return $query->orderBy('day_id', 'asc')->orderBy('pair_number_id')->get();
    }

    public function saveSchedule(DownloadScheduleRequest $request) {
        $fileName = $request->file_name ?? 'Расписание';
        $file = 'sch/'.$fileName.'.xlsx';

        if(isset($request->filter)) {
            $schedule = $this->filter(json_decode($request->filter, true));
        } else $schedule = $this->getAll();
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $scheduleFiller = new ScheduleFiller($sheet, $schedule);
        $scheduleFiller->fillSchedule();
        try {
            $writer = new WriterXlsx($spreadsheet);
            \PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);
            $writer->save($file);
            return $file;
        } catch (\Exception $e) {
            return;
        }
    }

    /**
     * Получить расписание, основанное на текущем пользователе
     * @param array | null $additionalInfo
     * return mixed
     */
    public function getMySchedule(array | null $additionalInfo = null, bool $getByParity = false) {
        if(FacadesGate::allows('watchSelfSchedule')) {
            $teacher = DashboardRoles::ROLE_TEACHER->value;
            $student = DashboardRoles::ROLE_STUDENT->value;
            $filter = [];
            $user = User::where('id', Auth::id())->with('groups')->first();
            $allowedRoles = [
                $teacher,
                $student
            ];
            foreach($user->roles as $role) {
                if(in_array($role->name, $allowedRoles)) {
                    switch($role->name) {
                        case $teacher: {
                            if($getByParity == false) {
                                $teacher = Teacher::where('user_id', Auth::id())->first();
                                $filter['teacher']['id'] = [$teacher['id']];
                            }
                        }
                        case $student: {
                            foreach($user->groups as $group) {
                                if(!array_key_exists('group', $filter)) {
                                    $filter['groups'] = ['id' => $group->id];
                                } else {
                                    array_push($filter['groups'], ['id' => $group->id]);
                                }
                            }
                        }
                    }
                }
            }

            if(isset($additionalInfo) && count($additionalInfo)) {
                foreach($additionalInfo as $key => $value) {
                    $filter[$key] = $value;
                }
            }

            return $this->filter($filter);
        } else return [];
    }

    public function getDashboardSchedule($date = null, bool $getByParity = false) {
        if(isset($date)) {
            $currentDayId = $this->dayRepository->getCurrentDayId();
        } else {
            $currentDay = new Date;
            $currentDayId = $currentDay->dayOfWeek;
        }

        $additionalScheduleFilter = [
            'days' => ['id' => $currentDayId]
        ]; // добавляем фильтрацию на сегодняшний день

        if($getByParity === true) {
            $parity = $this->parity->getSemesterStart();
            $typeByParity = Type::where('value', $parity['value'])->first()->id;
            $regularType = Type::where('value', 'regular')->first()->id;
            $additionalScheduleFilter['types'] = ['id' => [$typeByParity, $regularType]];
        }
        return $this->getMySchedule($additionalScheduleFilter, $getByParity);
    }
}
