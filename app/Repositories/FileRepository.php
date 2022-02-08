<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

class FileRepository
{
    public function getFileLink(string $path)
    {
        return asset(Storage::url($path));
    }
}
