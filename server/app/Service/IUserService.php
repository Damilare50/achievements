<?php

namespace App\Service;

interface IUserService
{
  public function fetchUserAchievements(string $userId): array;
}
