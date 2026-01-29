<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Service\IWalletService;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;

class AchievementUnlockedListener implements ShouldQueue, ShouldBeEncrypted
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

        //create the achievement record
        $user->achievements()->create([
            'achievement_id' => $achievement->id,
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
