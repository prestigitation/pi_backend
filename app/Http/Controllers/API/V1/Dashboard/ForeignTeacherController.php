<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Requests\Teachers\StoreForeignTeacherRequest;
use App\Http\Requests\Teachers\StoreTeacherAvatarRequest;
use App\Http\Resources\ForeignTeacherResource;
use App\Repositories\ForeignTeacherRepository;
use Illuminate\Http\Request;

class ForeignTeacherController extends BaseController
{
    private $teacherController;
    private $foreignTeacherRepository;

    public function __construct(ForeignTeacherRepository $foreignTeacherRepository, TeacherController $teacherController ) {
        $this->foreignTeacherRepository = $foreignTeacherRepository;
        $this->teacherController = $teacherController;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new ForeignTeacherResource($this->foreignTeacherRepository->paginate(10));
    }

    public function getAll() {
        return $this->foreignTeacherRepository->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreForeignTeacherRequest $request)
    {
        try {
            $this->foreignTeacherRepository->create($request->validated());
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function changeAvatar(int $id, StoreTeacherAvatarRequest $request) {
        return $this->teacherController->changeAvatar($id, $request);
    }
}
