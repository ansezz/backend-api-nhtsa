<?php

namespace App\Http\Controllers\Nhtsa;

use App\Services\Nhtsa\SafetyRatingsService;

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
    public function vehicles($model_year, $manufacturer, $model)
    {
        return response()->json($this->service->modelYear($model_year, $manufacturer, $model));
    }
}
