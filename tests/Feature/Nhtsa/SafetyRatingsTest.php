<?php

namespace Tests\Feature\Nhtsa;

use Tests\TestCase;

class SafetyRatingsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function modelYear()
    {
        $response = $this->get('/vehicles/2015/Audi/A3');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'Count',
                'Results'
            ]);

    }
}
