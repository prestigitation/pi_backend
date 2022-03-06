<?php

namespace App\Repositories;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleRepository {
    public function loadAll()
    {
        return Schedule::query();
    }

    public function getPaginated() {
        return $this->loadAll()->paginate(10);
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
        $schedule->deletion_author_id = Auth::id();
        $schedule->save();
        $schedule->delete();
    }
}
