<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Create a new user
     * 
     * @param array $data
     * @return User
     */
    public function createUser(array $data)
    {
        $user = User::create($data);
        return $user;
    }

    public function findUserByEmail(string $email)
    {
        $user = User::where('email', $email)->first();
        return $user;
    }
}