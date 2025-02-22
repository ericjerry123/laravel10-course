<?php

namespace App\Services;

use App\Repositories\RegisterRepository;

class AuthService
{
    private $registerRepository;

    public function __construct(RegisterRepository $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public function register(array $credentials)
    {
        return $this->registerRepository->create($credentials);
    }
}
