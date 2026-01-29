<?php

namespace App\Service\Impl;

use App\Service\IWalletService;
use Illuminate\Support\Facades\Log;

class WalletService implements IWalletService
{
  public function addFunds(string $userId, float $amount, string $narration = "Deposit"): array
  {
    // Dummy implementation
    Log::info("A payment of $amount has been made into your wallet with narration ($narration)");
    return [
      'userId' => $userId,
      'newBalance' => 100.0 + $amount
    ];
  }
}
