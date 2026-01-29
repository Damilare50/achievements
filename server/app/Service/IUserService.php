<?php

namespace App\Http\Service;

interface IUserService
{
  public function fetchUserAchievements(string $userId): array;
}
