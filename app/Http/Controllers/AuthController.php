<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRegisterRequest;
use App\Http\Resources\ApiResponse;
use App\Services\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(StoreRegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return ApiResponse::success($user, '註冊成功');
    }
}
