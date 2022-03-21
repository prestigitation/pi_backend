<?php

namespace App\Repositories;

use App\Models\PairFormat;
use Prettus\Repository\Eloquent\BaseRepository;

class PairFormatRepository extends BaseRepository {
    function model()
    {
        return PairFormat::class;
    }
}
