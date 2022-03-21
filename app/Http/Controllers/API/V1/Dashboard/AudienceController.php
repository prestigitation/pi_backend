<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Requests\Audiences\StoreAudienceRequest;
use App\Http\Requests\Audiences\UpdateAudienceRequest;
use App\Repositories\AudienceRepository;
use Illuminate\Http\Request;

class AudienceController extends BaseController
{
    private $audienceRepository;
    public function __construct(AudienceRepository $audienceRepository) {
        $this->audienceRepository = $audienceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getAll() {
        return $this->audienceRepository->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAudienceRequest $request)
    {
        try {
            $this->audienceRepository->create($request->validated());
        } catch (\Exception $e) {
            $this->sendError('Не удалось добавить аудиторию');
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

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAudienceRequest $request, $id)
    {
        try {
            $this->audienceRepository->update($request->validated(), $id);
        } catch (\Exception $e) {
            $this->sendError('Не удалось изменить данные об аудитории');
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
        try {
            $this->audienceRepository->delete($id);
        } catch (\Exception $e) {
            $this->sendError('Не удалось удалить данные об аудитории');
        }
    }
}
