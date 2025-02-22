<?php

namespace App\Repositories;

use App\Models\User;

class RegisterRepository
{
    public function create(array $credentials)
    {
        return User::create($credentials);
    }
}
