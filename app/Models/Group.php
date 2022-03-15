<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $with = ['direction', 'curator', 'headman', 'studyVariant', 'users'];

    public function studyVariant() {
        return $this->belongsTo(StudyVariant::class);
    }

    public function curator() {
        return $this->belongsTo(User::class,'curator_id', 'id');
    }

    public function headman() {
        return $this->belongsTo(User::class,'headman_id', 'id');
    }

    public function direction() {
        return $this->belongsTo(Direction::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

}
