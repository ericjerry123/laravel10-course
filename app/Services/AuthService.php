<?php

namespace App\Services;

use App\Http\Resources\ApiResponse;
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

    public function login(array $credentials)
    {
        if (! $token = auth()->attempt($credentials)) {
            return ApiResponse::error('登入失敗', 401);
        }

        return ApiResponse::success(
            $this->respondWithToken($token),
            '登入成功',
            200
        );
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }
}
