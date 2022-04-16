<?php

namespace App\Http\Controllers\API\V1\Dashboard;

use App\Http\Controllers\API\V1\Dashboard\BaseController;
use App\Http\Requests\Regularity\StoreRegularityRequest;
use App\Http\Resources\PairNumberResource;
use App\Repositories\PairNumberRepository;
use App\Repositories\RegularityRepository;
use Illuminate\Http\Request;

class RegularityController extends BaseController
{
    private $regularityRepository;
    public function __construct(RegularityRepository $regularityRepository) {
        $this->regularityRepository = $regularityRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(StoreRegularityRequest $request)
    {
        return $this->regularityRepository->create($request->validated());
    }
}
