<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherResource;

use App\Repositories\TeacherRepository;

class TeacherController extends Controller
{
    private $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $teachers = $this->teacherRepository->loadAll()->get();
        return new TeacherResource($teachers);
    }

}
