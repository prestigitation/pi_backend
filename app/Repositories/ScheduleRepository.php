<?php

namespace App\Repositories;

use App\Helpers\Classes\BasicQueryHelper;
use App\Helpers\Classes\NestedRelationQueryHelper;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;


class ScheduleRepository {
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

    public function fillPairs(Schedule $schedule, array $pairs) {
        foreach($pairs as $pair) {
            $schedule->pairs()->attach($pair['id']);
        }
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
        $this->fillPairs($schedule, $data['pairs']);
    }

    public function update(array $data, int $id)
    {
        $schedule = Schedule::find($id);
        $this->addScheduleInfo($schedule, $data);
        $schedule->save();
        $schedule->pairs()->detach();
        $this->fillPairs($schedule, $data['pairs']);
    }

    public function delete(int $id) {
        $schedule = Schedule::find($id);
        $schedule->pairs()->detach();
        // идентифицируем id пользователя, удалившего расписание, записываем в базу
        $schedule->deletion_author_id = Auth::id();
        $schedule->save();
        $schedule->delete();
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


        $nestedRelationHelper = new NestedRelationQueryHelper($query, $data);
        $nestedRelationHelper->query('pair_subjects')
                            ->query('pair_types')
                            ->query('pair_teachers')
                            ->query('pair_audiences')
                            ->query('pair_numbers');
        $query = $nestedRelationHelper->getBuilder();


        return $query->get();
    }
}
