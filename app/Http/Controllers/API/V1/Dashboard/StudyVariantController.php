<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Requests\StoreStudyVariantRequest;
use App\Http\Resources\StudyVariantResource;
use App\Repositories\StudyVariantRepository;
use Illuminate\Http\Request;

class StudyVariantController extends BaseController
{
    private $studyVariantRepository;

    public function __construct(StudyVariantRepository $studyVariantRepository) {
        $this->studyVariantRepository = $studyVariantRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new StudyVariantResource($this->studyVariantRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStudyVariantRequest $request)
    {
        try {
            $this->studyVariantRepository->create($request->validated());
            return $this->sendResponse(null, 'Вариант обучения был добавлен!');
        } catch(\Exception $e) {
            return $this->sendError('Не удалось добавить вариант');
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
}
