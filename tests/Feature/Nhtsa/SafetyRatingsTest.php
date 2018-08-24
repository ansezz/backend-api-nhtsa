<?php

namespace Tests\Feature\Nhtsa;

use Tests\TestCase;

class SafetyRatingsTest extends TestCase
{
    /**
     * A vehicles With GET test.
     *
     * @return void
     */
    public function testVehiclesWithGet()
    {
        $response = $this->get('/vehicles/2015/Audi/A3');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'Count',
                'Results'
            ]);

    }

    /**
     * A vehicles With POST test .
     *
     * @return void
     */
    public function testVehiclesWithPost()
    {
        $payload = [
            'modelYear' => 2015,
            'manufacturer' => 'Audi',
            'model' => 'A3'
        ];

        $response = $this->json('POST', '/vehicles', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'Count',
                'Results'
            ]);

    }


    /**
     * A vehicles With POST validation test .
     *
     * @return void
     */
    public function testVehiclesWithPostValidation()
    {
        $payload = [
            'modelYear' => 2015
        ];

        $response = $this->json('POST', '/vehicles', $payload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);

    }
}
