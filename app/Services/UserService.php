<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Store a new user in the database.
     *
     * @param array $data The data for creating the user.
     *
     * @return User The created user instance.
     */
    public function store($data): User
    {
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }
}
