<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Helpers\Functions\FilterRolesNames;
use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Repositories\UserRepository;
use App\Http\Requests\Users\SearchUserRequest;
use App\Http\Requests\Users\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Auth\RegisterController;


class UserController extends BaseController
{

    private $userRepository;
    private $filterRolesNames;
    private $registerController;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository, FilterRolesNames $filterRolesNames, RegisterController $registerController)
    {
        $this->middleware('auth:api');

        $this->userRepository = $userRepository;
        $this->filterRolesNames = $filterRolesNames;
        $this->registerController = $registerController;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::allows('isAdmin')) {
            return $this->unauthorizedResponse();
        }
        // $this->authorize('isAdmin');

        return $this->userRepository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     *
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(UserRequest $request)
    {
        return $this->registerController->create($request->validated());
    }

    /**
     * Update the resource in storage
     *
     * @param  \App\Http\Requests\Users\UserRequest  $request
     * @param $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(UserRequest $request, int $id)
    {
        return $this->userRepository->update($request, $id);

        return $this->sendResponse(null, 'Информация о пользователе была успешно обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $this->authorize('isAdmin');

        $this->userRepository->delete($id);

        return $this->sendResponse(null, 'Пользователь был удален');
    }

    public function search(SearchUserRequest $request)
    {
        $users = $this->userRepository->search($request->validated());
        if($users) return response()->json($users);
        else return $this->sendError('Не удалось найти ни одного пользователя');
    }

    public function attachRole(int $userId, int $roleId)
    {
        if(Gate::allows('setRole')) {
            $userRoles = User::find($userId)->roles->toArray();
            if(!$this->filterRolesNames->duplicateRole($roleId, $userRoles)) { // проверка, если роль не дублируется
                $this->userRepository->setRole($userId, $roleId);
                return $this->sendResponse(['message' => 'Роль была успешно добавлена']);
            } else {
                return $this->sendError(null,'Такая роль у пользователя уже существует. Выберите другую.');
            }
        } else return $this->sendError(null, 'Не удалось добавить роль. Возможно, у вас недостаточно прав редактирования ролей пользователя');
    }

    public function detachRole(int $userId, int $roleId)
    {
        if(Gate::allows('setRole')) {
            try {
                $this->userRepository->detachRole($userId, $roleId);
                return $this->sendResponse(['message' => 'Роль была успешно отвязана']);
            } catch (\Exception $e) {
                return $this->sendError(null, 'Не удалось отвязать роль у пользователя');
            }
        } else return $this->sendError(null, 'Недостаточно прав для отвязки роли пользователя');
    }
}
