<?php

namespace App\Http\Controllers;

use App\Http\Service\IUserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(
        private readonly IUserService $userService
    ) {}

    public function getUserAchievements(Request $request, string $user_id)
    {
        $response = $this->userService->fetchUserAchievements($user_id);

        return response()->json($response, 200);
    }
}
