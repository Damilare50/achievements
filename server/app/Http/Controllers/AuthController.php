<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Service\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}


    public function register(CreateUserRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->createUser($data);

        return response()->json($response, 200);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->login($data);

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $response = $this->authService->logout($request->user('sanctum'));

        return response()->json($response, 200);
    }
}
