<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Events\PurchaseSuccess;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class PurchaseSuccessListener implements ShouldQueue, ShouldBeEncrypted
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PurchaseSuccess $event): void
    {
        $user = $event->user;
        Log::alert('Handling PurchaseSuccess event for user ID: ' . $user->id);

        // Perform actions upon successful purchase
        // For example, increase the user's total purchases
        $user->incrementNumberOfPurchases();

        $user->refresh();

        // if current number is equal to an achievement threshold, award achievement
        if ($user->isEligibleForAnAchievement()) {
            //publish achievement unlocked event
            AchievementUnlocked::dispatch($user, $user->isEligibleForAnAchievement());
        }
    }
}
