<?php

namespace App\Service\Impl;

use App\Models\User;
use App\Service\IPurchaseService;
use Illuminate\Support\Facades\Log;;

class PurchaseService implements IPurchaseService
{
  public function initiate(array $data, User $user): array
  {
    // do purchases
    $response = $this->processPurchase($data);
    // trigger PurchaseSuccessEvent

    throw new \Exception('Not implemented');
  }

  public function processPurchase(array $data): array
  {
    Log::alert('Processing purchases...');

    return [
      'success' => true,
    ];
  }
}
