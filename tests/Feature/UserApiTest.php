<?php

namespace Tests\Feature;

use App\Events\UserRegistered;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function testCreatUser()
    {
        Event::fake();
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];

        $response = $this->post('/api/register', $userData);
        Event::assertDispatched(UserRegistered::class);
        $response->assertStatus(201); // Created
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
    }
}
