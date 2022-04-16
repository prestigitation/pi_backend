<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regularity extends Model
{
    use HasFactory;

    protected $fillable = ['audience_id', 'subject_id', 'type_id', 'pair_format_id', 'study_process_id', 'additional_info', 'start_date_info'];
    protected $with = ['teachers', 'foreignTeachers'];

    public function audience() {
        return $this->belongsTo(Audience::class);
    }
    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    public function type() {
        return $this->belongsTo(Type::class);
    }
    public function format() {
        return $this->belongsTo(PairFormat::class);
    }

    public function studyProcess() {
        return $this->belongsTo(StudyProcess::class);
    }

    public function schedule() {
        return $this->belongsToMany(Schedule::class);
    }

    public function foreignTeachers() {
        return $this->morphedByMany(ForeignTeacher::class, 'teachable');
    }

    public function teachers() {
        return $this->morphedByMany(Teacher::class, 'teachable');
    }
}
