<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        // The root route now serves the public shop landing page.
        $response->assertStatus(200);
        $response->assertSee('Everything your pet needs is here');
    }
}
