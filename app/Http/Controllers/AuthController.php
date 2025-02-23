<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoginRequest;
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

    public function login(StoreLoginRequest $request)
    {
        $user = $this->authService->login($request->validated());

        return ApiResponse::success($user, '登入成功');
    }
}
