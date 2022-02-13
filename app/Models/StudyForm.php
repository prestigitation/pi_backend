<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyForm extends Model
{
    use HasFactory;

    protected $with = ['time_form'];

    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function paymentForms()
    {
        return $this->hasMany(PaymentForm::class);
    }

    public function timeForms()
    {
        return $this->hasMany(TimeForm::class);
    }
}
