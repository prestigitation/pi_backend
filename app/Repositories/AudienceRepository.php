<?php
namespace App\Repositories;

use App\Models\Audience;
use App\Models\PairNumber;
use App\Models\Regularity;
use App\Models\Schedule;
use Prettus\Repository\Eloquent\BaseRepository;

class AudienceRepository extends BaseRepository {
    private $scheduleRepository;
    public function __construct(ScheduleRepository $scheduleRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Audience::class;
    }

    public function getEmptyAudiences() {
        $emptyAudienceList = [];
        $pairNumbers = PairNumber::all();
        $daySchedule = $this->scheduleRepository->getDashboardSchedule();
        return $emptyAudienceList;
    }
}
