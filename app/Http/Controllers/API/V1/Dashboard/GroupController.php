<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Requests\Groups\StoreGroupRequest;
use App\Http\Requests\Groups\UpdateGroupRequest;
use App\Http\Resources\GroupResource;
use App\Repositories\GroupRepository;

class GroupController extends BaseController
{
    private $groupRepository;
    public function __construct(GroupRepository $groupRepository) {
        $this->middleware('auth:api');

        $this->groupRepository = $groupRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new GroupResource($this->groupRepository->getPaginated());
    }

    public function getAll() {
        return new GroupResource($this->groupRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        try {
            $this->groupRepository->create($request->validated());
            return $this->sendResponse(null, 'Группа была успешно добавлена!');
        } catch(\Exception $e) {
            return $this->sendError('Не удалось добавить группу');
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
    public function update(UpdateGroupRequest $request, $id)
    {
        try {
            $this->groupRepository->update($request->validated(), $id);

            return $this->sendResponse(null, 'Информация о группе была успешно обновлена!');
        } catch (\Exception $e) {
            return $this->sendError('Не удалось изменить информацию о группе');
        }
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
}
