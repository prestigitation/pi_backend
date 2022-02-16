<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyVariant extends Model
{
    use HasFactory;

    protected $with = ['timeForm'];

    protected $casts = [
        'months' => 'integer',
        'years' => 'integer',
        'time_form' => 'integer',
    ];

    public function timeForm() {
        return $this->belongsTo(TimeForm::class);
    }

    public function groups() {
        return $this->belongsToMany(Group::class);
    }
}
