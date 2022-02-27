<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';

    protected $with = ['pairs', 'group', 'day'];
    use HasFactory;

    public function group() {
        return $this->hasOne(Group::class);
    }

    public function day() {
        return $this->hasOne(Day::class);
    }

    public function pairNumber() {
        return $this->hasOne(PairNumber::class);
    }

    public function pairs() {
        return $this->hasMany(Pair::class);
    }
}
