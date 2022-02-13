<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $with = ['profile', 'studyForm', 'timeForm', 'paymentForm'];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function studyForm()
    {
        return $this->hasOne(StudyForm::class);
    }

    public function paymentForm()
    {
        return $this->hasOne(PaymentForm::class);
    }

    public function timeForm()
    {
        return $this->hasOne(TimeForm::class);
    }
}
