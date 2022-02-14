<?php

namespace App\Repositories;

use App\Models\TimeForm;

class TimeFormRepository
{
    public function getAll()
    {
        return TimeForm::all();
    }
}
