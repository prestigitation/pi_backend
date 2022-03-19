<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['group', 'day', 'pairNumber'];

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function day() {
        return $this->belongsTo(Day::class);
    }

    public function pairNumber() {
        return $this->belongsTo(PairNumber::class);
    }

}
