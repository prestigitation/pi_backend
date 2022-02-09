<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teachers\StoreTeacherAvatarRequest;
use App\Http\Requests\Users\UserRequest;
use App\Http\Resources\TeacherResource;
use App\Models\User;
use Illuminate\Http\Request;

use App\Repositories\TeacherRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;

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
    public function store(Request $request)
    {
        //
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
    public function update(UserRequest $request, $id)
    {
        $this->userRepository->update($request, $id);

        return $this->sendResponse(null, 'Информация о пользователе была успешно обновлена!');
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
           // DB::delete('DELETE FROM `teachers` WHERE user_id = ?', [$id]);
            $this->sendResponse(null, 'Пользователь был успешно удален!');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return $this->sendError(null,'Не удалось удалить пользователя');
        }
    }

    public function changeAvatar(int $id, StoreTeacherAvatarRequest $request) {
        try {
            $this->teacherRepository->setAvatar($id, $request->validated());
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
