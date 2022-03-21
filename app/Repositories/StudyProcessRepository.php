<?php
namespace App\Repositories;

use App\Models\StudyProcess;
use Prettus\Repository\Eloquent\BaseRepository;

class StudyProcessRepository extends BaseRepository {

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return StudyProcess::class;
    }

}
