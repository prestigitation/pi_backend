<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentForm extends Model
{
    use HasFactory;

    public function directions() {
        return $this->belongsToMany(Direction::class);
    }

    public function studyForms()
    {
        return $this->belongsToMany(StudyForm::class);
    }
}
