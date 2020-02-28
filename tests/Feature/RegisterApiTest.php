<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterApiTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->json('POST', 'api/register', [
            'phone_number' => '09120361547',
            'email' => 'ramin5@gmail.com',
            'password' => '1234567' 
            ]);

        $response
            ->assertStatus(201);
    }
}
