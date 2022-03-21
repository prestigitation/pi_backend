<?php
namespace App\Repositories;

use App\Models\Audience;
use Prettus\Repository\Eloquent\BaseRepository;

class AudienceRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Audience::class;
    }

}
