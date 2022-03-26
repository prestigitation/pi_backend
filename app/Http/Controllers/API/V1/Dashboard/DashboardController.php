<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Models\Direction;
use App\Models\ForeignTeacher;
use App\Models\Group;
use App\Models\Question;
use App\Models\Teacher;

class DashboardController extends BaseController {
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
            'directions_count' => Direction::all()->count()
        ];
    }
}
