<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    use HasFactory;

    protected $with = ['teacher', 'subject', 'type'];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function type() {
        return $this->belongsTo(Type::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function schedule() {
        return $this->belongsToMany(Schedule::class);
    }
}
