<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository
{
    public function getAll()
    {
        return Profile::all();
    }
}
