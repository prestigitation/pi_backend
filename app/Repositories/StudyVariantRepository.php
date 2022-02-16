<?php

namespace App\Repositories;

use App\Models\StudyVariant;
use Illuminate\Support\Facades\Storage;

class StudyVariantRepository
{
    public function getAll()
    {
        return StudyVariant::all();
    }

    public function create(array $data)
    {
        $studyVariant = new StudyVariant();
        if($data['months']) {
            $studyVariant->months = $data['months'];
        }
        $studyVariant->years = $data['years'];
        $studyVariant->time_form_id = $data['time_form'];
        $studyVariant->save();
    }

    public function getByData(int $years, ?int $months, ?int $timeFormId) {
        $query = StudyVariant::query();
        if(isset($months)) {
            $query->where('months', $months);
        }
        if(isset($timeFormId)) {
            $query->where('time_form_id', $timeFormId);
        }
        $query->where('years', $years);
        return $query->first()->id;
    }
}
