<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyVariant extends Model
{
    use HasFactory;

    public function timeForm() {
        return $this->hasOne(TimeForm::class);
    }

    public function groups() {
        return $this->belongsToMany(Group::class);
    }
}
