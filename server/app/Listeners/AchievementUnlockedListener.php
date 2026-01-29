<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;

class AchievementUnlockedListener implements ShouldQueue, ShouldBeEncrypted
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
    public function handle(AchievementUnlocked $event): void
    {
        $user = $event->user;
        $achievement = $event->achievement;

        //create the achievement record
        $user->achievements()->create([
            'achievement_id' => $achievement->id,
            'unlocked_at' => Carbon::now(),
        ]);

        //implement cashback or reward logic here
    }
}
