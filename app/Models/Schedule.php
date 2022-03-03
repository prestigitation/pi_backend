<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{

    protected $with = ['pairs', 'group', 'day'];
    use HasFactory;

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function day() {
        return $this->belongsTo(Day::class);
    }

    public function pairNumber() {
        return $this->belongsTo(PairNumber::class);
    }

    public function pairs() {
        return $this->belongsToMany(Pair::class);
    }
}
