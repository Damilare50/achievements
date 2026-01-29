<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Models\UserAchievement;
use App\Service\IWalletService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Support\Facades\Log;

class AchievementUnlockedListener implements ShouldBeEncrypted
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly IWalletService $walletService
    ) {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AchievementUnlocked $event): void
    {
        $user = $event->user;
        $achievement = $event->achievement;

        Log::alert('Handling AchievementUnlocked event for user ID: ' . $user->id . ' and achievement ID: ' . $achievement->id);

        //create the achievement record
        UserAchievement::create([
            'achievement_id' => $achievement->id,
            'user_id' => $user->id,
            'unlocked_at' => Carbon::now(),
        ]);

        //implement cashback
        $this->walletService->addFunds(
            $user->id,
            300.00,
            "Cashback Reward for unlocking $achievement->name"
        );
    }
}
