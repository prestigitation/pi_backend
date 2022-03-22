<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $with = ['user', 'educationLevel', 'regalias', 'subjects'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function pair() {
        return $this->belongsTo(Pair::class);
    }

    public function educationLevel() {
        return $this->belongsTo(EducationLevel::class);
    }

    public function regalias() {
        return $this->belongsToMany(Regalia::class);
    }

    public function subjects() {
        return $this->morphToMany(Subject::class, 'subjectable');
    }
}
