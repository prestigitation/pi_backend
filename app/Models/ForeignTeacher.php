<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForeignTeacher extends Model
{
    use HasFactory;

    public function educationLevel() {
        return $this->belongsTo(EducationLevel::class);
    }

    public function subjects() {
        return $this->morphToMany(Subject::class, 'subjectable');
    }
}
