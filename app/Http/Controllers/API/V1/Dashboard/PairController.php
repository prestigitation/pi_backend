<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Requests\Pairs\StorePairRequest;
use App\Http\Requests\Pairs\UpdatePairRequest;
use App\Http\Resources\PairResource;
use App\Repositories\PairRepository;

class PairController extends BaseController
{
    private $pairRepository;
    public function __construct(PairRepository $pairRepository) {
        $this->pairRepository = $pairRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pairs = $this->pairRepository->getPaginated();
        return new PairResource($pairs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePairRequest $request)
    {
        try {
            $this->pairRepository->create($request->validated());
            return $this->sendResponse(null, 'Информация о паре была успешно добавлена!');
        } catch(\Exception $e) {
            dd($e->getMessage());
            return $this->sendError('Не удалось добавить информацию о паре');
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
    public function update(UpdatePairRequest $request, $id)
    {
        try {
            $this->pairRepository->update($request->validated(), $id);

            return $this->sendResponse(null, 'Информация о паре была успешно обновлена!');
        } catch (\Exception $e) {
            return $this->sendError('Не удалось изменить информацию о паре');
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
