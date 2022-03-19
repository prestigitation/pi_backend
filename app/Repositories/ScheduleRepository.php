<?php

namespace App\Repositories;

use App\Helpers\Classes\BasicQueryHelper;
use App\Helpers\Classes\NestedRelationQueryHelper;
use App\Models\Audience;
use App\Models\ForeignTeacher;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Type;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Stevebauman\Purify\Purify;

class ScheduleRepository {
    private $purifier;
    public function __construct(Purify $purifier) {
        $this->purifier = $purifier;
    }
    public function loadAll()
    {
        return Schedule::query();
    }

    public function getPaginated($schedule = null) {
        $scheduleQuery = $schedule ?? $this->loadAll();
        return $scheduleQuery->paginate(10);
    }

    public function getAll() {
        return $this->loadAll()->get();
    }

    public function fillPairs(array $pairs) {
        $result = [];
        foreach($pairs as $index => $pair) {
            if($pair['is_foreign'] === true) {
                $result[$index]['teacher'] = ForeignTeacher::findOrFail($pair['teacher_id']);
            } else {
                $result[$index]['teacher'] = Teacher::findOrFail($pair['teacher_id']);
            }

            $result[$index]['audience'] = Audience::findOrFail($pair['audience_id']);
            $result[$index]['subject'] = Subject::findOrFail($pair['subject_id']);
            $result[$index]['type'] = Type::findOrFail($pair['type_id']);
            if($pair['additional_info']) {
                $result[$index]['additional_info'] = $this->purifier->clean($pair['additional_info']);
            }
        }
        return $result;
    }

    public function addScheduleInfo(Schedule $schedule, array $data) {
        $schedule->day_id = $data['day_id'];
        $schedule->group_id = $data['group_id'];
        $schedule->pair_number_id = $data['pair_number_id'];
        $schedule->regularity = collect($this->fillPairs($data['pairs']))->toJson(); //json_encode($this->fillPairs($data['pairs']));
    }

    public function create(array $data)
    {
        $schedule = new Schedule;
        $this->addScheduleInfo($schedule, $data);
        $schedule->save();
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
            'type' => ['id']
        ];


        foreach($regularityInfo as $name => $params) {
            if(is_array($params)) {
                foreach($params as $key => $criteria) {
                    if(isset($allowedFields[$name])) {
                        $models = DB::table($name.'s')->whereIn($key, $criteria)->select($key)->get();
                        foreach($models as $i => $model) {
                            $queryString = '';
                            $queryString .= "json_contains(`regularity`,'".json_encode([[$name => $model]])."')";
                            if($i === 0) {
                                $query->whereRaw($queryString);
                            } else {
                                $query->orWhereRaw($queryString);
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


    public function filter(array $data) {
        $query = null;
        if(isset($data['deleted']) && $data['deleted'] === true) {
            $query = Schedule::withTrashed();
        } else {
            $query = Schedule::query();
        }
        $basicHelper = new BasicQueryHelper($query, $data);
        $basicHelper->query('groups')
                    ->query('days');
        $query = $basicHelper->getBuilder();

        $query = $this->filterPairNumber($data, $query);
        $query = $this->filterRegularity($data, $query);


        return $query->get();
    }
}
