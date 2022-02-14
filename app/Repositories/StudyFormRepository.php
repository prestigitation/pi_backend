<?php

namespace App\Repositories;

use App\Models\StudyForm;

class StudyFormRepository
{
    public function getAll()
    {
        return StudyForm::all();
    }
}
