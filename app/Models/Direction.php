<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'profile_id', 'speciality_id', 'study_form_id'
    ];

    protected $with = [
        'profile',
        'studyForm',
        'speciality',

        'paymentForms',
        'studyVariants',
        'groups'
    ];

    public function studyForm() {
        return $this->belongsTo(StudyForm::class);
    }

    public function speciality() {
        return $this->belongsTo(Speciality::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }


    public function paymentForms()
    {
        return $this->belongsToMany(PaymentForm::class);
    }

    public function studyVariants() {
        return $this->belongsToMany(StudyVariant::class);
    }
}
