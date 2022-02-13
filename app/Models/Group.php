<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $with = ['directions'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function directions()
    {
        return $this->belongsToMany(Direction::class);
    }

    public function schedule() {
        return $this->belongsToMany(Schedule::class);
    }
}
