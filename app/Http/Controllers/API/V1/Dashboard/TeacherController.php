<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;

use App\Http\Requests\Teachers\StoreTeacherAvatarRequest;
use App\Http\Requests\Teachers\StoreTeacherRequest;
use App\Http\Requests\Teachers\UpdateTeacherRequest;

use App\Http\Resources\TeacherResource;
use App\Models\ForeignTeacher;
use App\Repositories\TeacherRepository;
use App\Repositories\UserRepository;

class TeacherController extends BaseController
{
    private $teacherRepository;
    private $userRepository;

    public function __construct(TeacherRepository $teacherRepository, UserRepository $userRepository)
    {
        $this->teacherRepository = $teacherRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = $this->teacherRepository->getAll();
        return new TeacherResource($teachers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeacherRequest $request)
    {
        try {
            $this->teacherRepository->create($request->validated());
            return $this->sendResponse(null, 'Преподаватель был успешно добавлен!');
        } catch(\Exception $e) {
            return $this->sendError('Не удалось добавить преподавателя');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeacherRequest $request, $id)
    {
        $this->teacherRepository->update($request->validated(), $id);

        return $this->sendResponse(null, 'Информация о преподавателе была успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $this->userRepository->delete($id);
            $this->sendResponse(null, 'Преподаватель был успешно удален!');
            //TODO: rework
        } catch (\Exception $e) {
            return $this->sendError(null,'Не удалось удалить преподавателя');
        }
    }

    public function changeAvatar(int $id, StoreTeacherAvatarRequest $request) {
        try {
            $this->teacherRepository->setAvatar($id, $request->validated());
        } catch (\Exception $e) {
            return $this->sendError(null,'Не удалось добавить изображение');
        }
    }

    public function getAllIncludingForeign() {
        return $this->teacherRepository->getAllIncludingForeign();
    }
}
