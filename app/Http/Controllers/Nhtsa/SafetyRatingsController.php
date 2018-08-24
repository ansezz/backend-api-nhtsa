<?php

namespace App\Http\Controllers\Nhtsa;

use App\Http\Requests\Nhtsa\VehiclesPostRequest;
use App\Services\Nhtsa\SafetyRatingsService;
use Illuminate\Http\JsonResponse;

class SafetyRatingsController extends BaseController
{
    protected $service;

    /**
     * SafetyRatingsController constructor.
     * @param SafetyRatingsService $safetyRatingsService
     */
    public function __construct(SafetyRatingsService $safetyRatingsService)
    {
        $this->service = $safetyRatingsService;
        parent::__construct();
    }


    /**
     * @param $model_year
     * @param $manufacturer
     * @param $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function vehicles($model_year, $manufacturer, $model): JsonResponse
    {
        return response()->json($this->service->modelYear($model_year, $manufacturer, $model, (bool)\request()->get('withRating', false)));
    }

    /**
     * @param VehiclesPostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vehiclesWithPost(VehiclesPostRequest $request): JsonResponse
    {
        return response()->json($this->service->modelYear($request->modelYear, $request->manufacturer, $request->model));
    }

}
