<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Helpers\Classes\Parity;
use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Models\Direction;
use App\Models\ForeignTeacher;
use App\Models\Group;
use App\Models\News;
use App\Models\Question;
use App\Models\Teacher;
use App\Repositories\AudienceRepository;
use App\Repositories\ScheduleRepository;

class DashboardController extends BaseController {
    private $scheduleRepository;
    private $audienceRepository;
    private $parity;
    public function __construct(
        ScheduleRepository $scheduleRepository,
        AudienceRepository $audienceRepository,
        Parity $parity
        )
    {
        $this->scheduleRepository = $scheduleRepository;
        $this->audienceRepository = $audienceRepository;
        $this->parity = $parity;
    }

    public function getHeaderInfo() {

        return [
            'groups_count' => Group::all()->count(),
            'teachers_count' => [
                'department' => Teacher::all()->count(),
                'foreign' => ForeignTeacher::all()->count()
            ],
            'questions_count' => [
                'all' => Question::all()->count(),
                'answered' => Question::answered()->count()
            ],
            'directions_count' => Direction::all()->count(),
            'today_schedule' => $this->scheduleRepository->getDashboardSchedule(null, false),
            'last_news' => News::orderBy('id', 'desc')->limit(3)->get(),
            'empty_audiences' => $this->audienceRepository->getEmptyAudiences(),
            'parity' => $this->parity->getSemesterStart()
        ];
    }
}
