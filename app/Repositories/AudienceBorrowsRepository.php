<?php
namespace App\Repositories;

use App\Models\AudienceBorrow;
use Prettus\Repository\Eloquent\BaseRepository;

class AudienceBorrowsRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return AudienceBorrow::class;
    }

}
