<?php

namespace App\Services\Nhtsa;


use Illuminate\Support\Facades\Log;

class SafetyRatingsService extends BaseApiService
{

    private const URI_MODEL_YEAR_QUERY = 'SafetyRatings/modelyear/%d/make/%s/model/%s';
    private const URI_VEHICLE_ID_QUERY = 'SafetyRatings/VehicleId/%d';
    private const NOT_RATED_VALUE = 'Not Rated';

    /**
     * @param $model_year
     * @param $manufacturer
     * @param $model
     * @param bool $withRating
     * @return mixed
     */
    public function modelYear($model_year, $manufacturer, $model, $withRating = false): array
    {
        $data = [
            'Count' => 0,
            'Results' => []
        ];

        try {
            $uri = sprintf(self::URI_MODEL_YEAR_QUERY, $model_year, $manufacturer, $model);

            $response = $this->apiClient->get($uri, ['query' => ['format' => $this->format]]);

            if (200 === $response->getStatusCode()) {
                $result = \GuzzleHttp\json_decode($response->getBody());

                $data['Results'] = array_map(function ($item) use ($withRating) {
                    if ($item->VehicleDescription && $item->VehicleId) {
                        $vehicle = [
                            'Description' => $item->VehicleDescription,
                            'VehicleId' => $item->VehicleId,
                        ];

                        if ('true' === $withRating) {
                            $vehicle['CrashRating'] = $this->vehicleId($item->VehicleId);
                        }
                        return $vehicle;
                    }
                }, $result->Results);

                $data['Count'] = \count($data['Results']);
            }
        } catch (\Exception $exception) {
            Log::error(' API ERROR : ' . $exception->getMessage());
        }

        return $data;
    }

    /**
     * @param $id
     * @return string
     */
    protected function vehicleId($id): string
    {
        try {
            $uri = sprintf(self::URI_VEHICLE_ID_QUERY, $id);

            $response = $this->apiClient->get($uri, ['query' => ['format' => $this->format]]);

            if ($response->getStatusCode() === 200) {
                $result = \GuzzleHttp\json_decode($response->getBody());
                if ($result->Count > 0) {
                    return (string)$result->Results[0]->OverallRating;
                }
            }
        } catch (\Exception $exception) {
            Log::error(' API ERROR : ' . $exception->getMessage());
        }

        return self::NOT_RATED_VALUE;
    }
}
