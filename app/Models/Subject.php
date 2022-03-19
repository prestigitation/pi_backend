<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function pair() {
        return $this->belongsTo(Pair::class);
    }

    public function foreignTeachers() {
        return $this->morphedByMany(ForeignTeacher::class, 'subjectable');
    }

    public function teachers() {
        return $this->morphedByMany(ForeignTeacher::class, 'subjectable');
    }

    public function schedules() {
        return $this->belongsToMany(Schedule::class);
    }
}
