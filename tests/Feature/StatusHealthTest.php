<?php

namespace Tests\Feature;

use Tests\TestCase;

class StatusHealthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_status_health_liveness_should_return_200()
    {
        $response = $this->get('/status-health/live');
        $response->assertStatus(200);
    }
}
