<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     */
    public function test_create(){
        $repository = $this->app->make(UserRepository::class);
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ];
        $result = $repository->createUser($userData);
        $this->assertSame('john@example.com', $result->email, 'Post created successfully');
    }
  
}
