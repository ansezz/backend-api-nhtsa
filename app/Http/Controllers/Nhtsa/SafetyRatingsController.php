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
     * @OA\Info(title="Backend API NHTSA", version="0.1")
     */

    /**
     * @OA\Get(
     *   path="/vehicles/{model_year}/{manufacturer}/{model}",
     *   summary="Requirement 1 & 3",
     *   description="Get available vehicle variants for a selected Model Year, Make and Model",
     * @OA\Parameter(
     *         name="model_year",
     *         in="path",
     *         description="model year of vehicle",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64",
     *             example=2015
     *         )
     *     ),
     * @OA\Parameter(
     *         name="manufacturer",
     *         in="path",
     *         description="manufacturer of vehicle",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="Audi"
     *         )
     *     ),
     * @OA\Parameter(
     *         name="model",
     *         in="path",
     *         description="model of vehicle",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             example="A3"
     *         )
     *     ),
     * @OA\Response(
     *     response=200,
     *     description="A list with vehicles"
     *   )
     * )
     * @param $model_year
     * @param $manufacturer
     * @param $model
     * @return \Illuminate\Http\JsonResponse
     */
    public function vehicles($model_year, $manufacturer, $model): JsonResponse
    {
        return response()->json($this->service->modelYear($model_year, $manufacturer, $model, \request()->get('withRating', false)));
    }

    /**
     * @OA\Post(
     *   path="/vehicles",
     *   summary="Requirement 2",
     *   description="Get available vehicle variants for a selected Model Year, Make and Model",
     *   @OA\RequestBody(
     *       required=true,
     *       @OA\MediaType(
     *           mediaType="application/x-www-form-urlencoded",
     *           @OA\Schema(
     *               type="object",
     *               @OA\Property(
     *                   property="model",
     *                   description="model of vehicle",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="manufacturer",
     *                   description="manufacturer of vehicle",
     *                   type="string"
     *               ),
     *               @OA\Property(
     *                   property="model_year",
     *                   description="model year of vehicle",
     *                   type="integer"
     *               ),
     *           )
     *       )
     *   ),
     * @OA\Response(
     *     response=200,
     *     description="A list with vehicles"
     *   )
     * )
     * @param VehiclesPostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function vehiclesWithPost(VehiclesPostRequest $request): JsonResponse
    {
        return response()->json($this->service->modelYear($request->modelYear, $request->manufacturer, $request->model));
    }

}
