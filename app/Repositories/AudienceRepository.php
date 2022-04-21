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
        $audiences = Audience::all();
        $pairNumbers = PairNumber::all();
        $daySchedule = $this->scheduleRepository->getDashboardSchedule();

        foreach($pairNumbers as $pairNumber) {
            $emptyAudienceList[$pairNumber->number] = [
                'busy' => [],
                'empty' => []
            ];
        }

        foreach($daySchedule as $scheduleEntry) {
            foreach($scheduleEntry->regularity as $regularity) {
                if(!in_array($regularity->audience, $emptyAudienceList[$scheduleEntry->pairNumber->number]['busy'])) {
                    array_push($emptyAudienceList[$scheduleEntry->pairNumber->number]['busy'], $regularity->audience);
                }
            }

            foreach($audiences as $audience) {
                if(!in_array($audience, $emptyAudienceList[$scheduleEntry->pairNumber->number]['empty'])) {
                    array_push($emptyAudienceList[$scheduleEntry->pairNumber->number]['empty'], $audience);
                }
            }
        }

        return $emptyAudienceList;
    }
}
