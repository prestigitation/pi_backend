<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $with = [
        'profile',
        'studyForm',
        'timeForm',

        'paymentForms',
        'studyVariants'
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }


    public function paymentForms()
    {
        return $this->hasMany(PaymentForm::class);
    }

    public function timeForm()
    {
        return $this->hasMany(TimeForm::class);
    }

    public function studyVariants() {
        return $this->hasMany(StudyVariant::class);
    }
}
