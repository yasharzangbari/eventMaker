<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->json('POST', 'api/login', [
            'email' => 'ramin2@gmail.com',
            'password' => '1234567' 
            ]);

        $response
            ->assertStatus(200);
        $this->assertTrue(true);
    }
}
