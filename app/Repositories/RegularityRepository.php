<?php
namespace App\Repositories;

use App\Models\Regularity;
use Prettus\Repository\Eloquent\BaseRepository;

class RegularityRepository extends BaseRepository {
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Regularity::class;
    }
}
