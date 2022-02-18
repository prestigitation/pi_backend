<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDirectionRequest;
use App\Http\Resources\DirectionResource;
use App\Repositories\DirectionRepository;
use Illuminate\Http\Request;

class DirectionController extends BaseController
{
    private $directionRepository;
    public function __construct(DirectionRepository $directionRepository) {
        $this->directionRepository = $directionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new DirectionResource($this->directionRepository->getAll());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDirectionRequest $request)
    {
        try {
            $this->directionRepository->create($request->validated());
            return $this->sendResponse(null, 'Направление было добавлено!');
        } catch(\Exception $e) {
            dd($e->getMessage());
            return $this->sendError('Не удалось добавить направление');
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
