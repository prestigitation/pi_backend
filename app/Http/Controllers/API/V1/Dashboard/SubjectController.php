<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Requests\Subjects\StoreSubjectRequest;
use App\Http\Requests\Subjects\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends BaseController
{
    private $subjectRepository;

    public function __construct(SubjectRepository $subjectRepository) {
        $this->subjectRepository = $subjectRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new SubjectResource($this->subjectRepository->getPaginated());
    }

    public function getAll() {
        return $this->subjectRepository->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubjectRequest $request)
    {
        try {
            $this->subjectRepository->create($request->validated());
        } catch(\Exception $e) {
            return $this->sendError('Не удалось добавить предмет');
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
    public function update(UpdateSubjectRequest $request, $id)
    {
        try {
            $this->subjectRepository->updateCustom($request->validated(), $id);
        } catch(\Exception $e) {
            return $this->sendError('Не удалось изменить данные о предмете');
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
