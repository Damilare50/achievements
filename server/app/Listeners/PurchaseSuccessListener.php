<?php

namespace App\Listeners;

use App\Events\PurchaseSuccess;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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
        //
    }
}
