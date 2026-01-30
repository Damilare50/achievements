<?php

namespace App\Service\Impl;

use App\Service\IUserService;
use App\Models\Achievement;
use App\Models\User;

class UserService implements IUserService
{
  public function fetchUserAchievements(string $user_id): array
  {
    $user = User::with('achievements')->findOrFail($user_id);

    $allAchievements = Achievement::orderBy('threshold', 'asc')->get();

    $unlockedAchievements = $user->achievements->pluck('name')->toArray();

    $unlockedAchievementIds = $user->achievements->pluck('id')->toArray();

    $nextAvailableAchievements = $allAchievements
      ->whereNotIn('id', $unlockedAchievementIds)
      ->where('threshold', '>=', $user->no_of_purchases)
      ->pluck('name')
      ->toArray();

    $currentBadge = $user->achievements
      ->sortByDesc('threshold')
      ->first()
      ?->name ?? '';

    $nextAchievement = $allAchievements
      ->whereNotIn('id', $unlockedAchievementIds)
      ->sortBy('threshold')
      ->first();

    $nextBadge = $nextAchievement?->name ?? '';

    $remainingToUnlockNextBadge = $nextAchievement
      ? (int) max(0, $nextAchievement->threshold - $user->no_of_purchases)
      : 0;

    return [
      'unlocked_achievements' => $unlockedAchievements,
      'next_available_achievements' => $nextAvailableAchievements,
      'current_badge' => $currentBadge,
      'next_badge' => $nextBadge ?? '',
      'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
    ];
  }
}
