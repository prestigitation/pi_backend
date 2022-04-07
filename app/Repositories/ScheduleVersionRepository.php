<?php
namespace App\Repositories;

use App\Models\ScheduleVersion;
use Prettus\Repository\Eloquent\BaseRepository;

class ScheduleVersionRepository extends BaseRepository {
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return ScheduleVersion::class;
    }
}
