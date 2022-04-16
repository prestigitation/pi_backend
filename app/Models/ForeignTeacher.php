<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForeignTeacher extends Model
{
    use HasFactory;

    protected $with = ['subjects', 'teacherPosition'];

    public function educationLevel() {
        return $this->belongsTo(EducationLevel::class);
    }

    public function teacherPosition() {
        return $this->belongsTo(TeacherPosition::class);
    }

    public function subjects() {
        return $this->morphToMany(Subject::class, 'subjectable');
    }

    public function regularity() {
        return $this->morphToMany(Regularity::class, 'teachable');
    }
}
