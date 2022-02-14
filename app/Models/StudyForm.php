<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyForm extends Model
{
    use HasFactory;


    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function paymentForms()
    {
        return $this->hasMany(PaymentForm::class);
    }
}
