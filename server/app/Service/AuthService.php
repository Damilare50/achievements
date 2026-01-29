<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
  public function createUser(array $data)
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

  public function login(array $data)
  {
    $user = User::where('email', $data['email'])->first();

    if (!$user || !Hash::check($data['password'], $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['The provided credentials are incorrect.'],
      ]);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return [
      'user' => $user,
      'access_token' => $token,
      'token_type' => 'Bearer',
    ];
  }

  public function logout(User $user)
  {
    $user->tokens()->delete();

    return [
      'message' => 'Successfully logged out',
    ];
  }
}
