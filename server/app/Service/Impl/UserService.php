<?php

namespace App\Service\Impl;

use App\Http\Service\IUserService;

class UserService implements IUserService
{
  public function fetchUserAchievements(string $userId): array
  {
    return [];
  }
}
