<?php

namespace App\Service;

use App\Models\User;

interface IAuthService
{
  public function createUser(array $data): array;

  public function login(array $data): array;

  public function logout(User $user): array;
}
