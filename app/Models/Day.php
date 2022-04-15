<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    protected $with = ['studyProcess'];


    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

    public function studyProcess() {
        return $this->belongsTo(StudyProcess::class);
    }

    public function scopeActive(Day $day) {
        return $day->id !== Day::count();
    }
}
