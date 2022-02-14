<?php

namespace App\Repositories;

use App\Models\Profile;
use App\Models\Speciality;

class SpecialityRepository
{
    public function getAll()
    {
        return Speciality::all();
    }
}
