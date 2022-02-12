<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    use HasFactory;

    public function group() {
        return $this->hasOne(Group::class);
    }

    public function day() {
        return $this->hasOne(Day::class);
    }
}
