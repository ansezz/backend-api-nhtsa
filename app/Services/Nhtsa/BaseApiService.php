<?php

namespace App\Services\Nhtsa;


use GuzzleHttp\Client;

class BaseApiService
{

    const API_BASE_URL = 'https://one.nhtsa.gov/webapi/api/';

    protected $apiClient;
    protected $format;

    /**
     * BaseApiService constructor.
     */
    public function __construct()
    {
        $this->apiClient = new Client([
            'base_uri' => self::API_BASE_URL
        ]);

        $this->format = 'json';
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }


}
