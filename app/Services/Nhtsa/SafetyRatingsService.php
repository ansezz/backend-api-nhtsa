<?php

namespace App\Services\Nhtsa;


class SafetyRatingsService extends BaseApiService
{

    const URI_MODEL_YEAR_QUERY = 'SafetyRatings/modelyear/%d/make/%s/model/%s';

    /**
     * @param $model_year
     * @param $manufacturer
     * @param $model
     * @return mixed
     */
    public function modelYear($model_year, $manufacturer, $model)
    {
        $uri = sprintf(self::URI_MODEL_YEAR_QUERY, $model_year, $manufacturer, $model);

        $response = $this->apiClient->get($uri, ['query' => ['format' => $this->format]]);

        $data = [
            'Count' => 0,
            'Results' => []
        ];

        if ($response->getStatusCode() === 200) {
            $result = \GuzzleHttp\json_decode($response->getBody());
            $data['Count'] = $result->Count;

            $data['Results'] = array_map(function ($item) {
                return [
                    'Description' => $item->VehicleDescription,
                    'VehicleId' => $item->VehicleId,
                ];
            }, $result->Results);
        }

        return $data;
    }

}
