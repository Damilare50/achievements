<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\CreateUserRequest;
use App\Service\AuthService;

class AuthController extends Controller
{
    public function __construct(private readonly AuthService $authService) {}


    public function register(CreateUserRequest $request)
    {
        $data = $request->validated();

        $response = $this->authService->createUser($data);

        return response()->json($response, 200);
    }
}
