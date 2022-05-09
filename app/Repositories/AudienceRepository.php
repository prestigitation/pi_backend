<?php
namespace App\Repositories;

use App\Models\Audience;
use App\Models\AudienceBorrow;
use App\Models\PairNumber;
use Prettus\Repository\Eloquent\BaseRepository;

class AudienceRepository extends BaseRepository {
    private $scheduleRepository;
    private $audienceBorrowsRepository;
    public function __construct(ScheduleRepository $scheduleRepository, AudienceBorrowsRepository $audienceBorrowsRepository)
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->audienceBorrowsRepository = $audienceBorrowsRepository;
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
                //$regularity->audience_id PLUCK all borrow audiences by id
                $isBorrowing = AudienceBorrow::query()->each(function ($q) use ($audiences, $scheduleEntry, $regularity) {
                    $q->whereIn('audience_id', $audiences->where('id', '<>', $regularity->audience_id)->pluck('id')->toArray())
                    ->where('pair_number_id', $scheduleEntry->pair_number_id);
                });

                if(!in_array($regularity->audience, $emptyAudienceList[$scheduleEntry->pairNumber->number]['busy'])) {
                    array_push($emptyAudienceList[$scheduleEntry->pairNumber->number]['busy'], $regularity->audience);
                }
            }
        }

        foreach($emptyAudienceList as $key => $audienceList) {
            foreach($audiences as $audience) {
                $inBusy = array_filter($audienceList['busy'], function($aud) use ($audience) {
                    return $audience->name === $aud->name;
                });

                if(!count($inBusy)) {
                    array_push($emptyAudienceList[$key]['empty'], $audience);
                }
            }
        }

        return $emptyAudienceList;
    }

    public function borrowAudience(int $audienceId, int $pairNumberId, array $borrowingData) {
        $borrowEntry = $this->audienceBorrowsRepository->create($borrowingData);
        $borrowEntry->audience()->associate($audienceId);
        $borrowEntry->pairNumber()->associate($pairNumberId);
        $borrowEntry->save();
    }
}
