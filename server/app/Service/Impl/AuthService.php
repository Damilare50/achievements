<?php

namespace App\Service\Impl;

use App\Models\User;
use App\Service\IAuthService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements IAuthService
{
  public function createUser(array $data): array
  {
    $user = User::create([
      'name' => $data['name'] ?? '',
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return [
      'user' => $user,
      'access_token' => $token,
    ];
  }

  public function login(array $data): array
  {
    $user = User::where('email', $data['email'])->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['The provided credentials are incorrect.'],
      ]);
    }

    $user->tokens()->delete();
    $token = $user->createToken('auth_token')->plainTextToken;

    return [
      'user' => $user,
      'access_token' => $token,
      'token_type' => 'Bearer',
    ];
  }

  public function logout(User $user): array
  {
    $user->tokens()->delete();

    return [
      'message' => 'Successfully logged out',
    ];
  }
}
