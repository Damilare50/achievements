<?php

namespace App\Service\Impl;

use App\Events\PurchaseSuccess;
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
    PurchaseSuccess::dispatchIf($response['success'], $user);

    return $response + [
      'message' => $response['success'] ? 'Purchase completed successfully.' : 'Purchase failed.',
    ];
  }

  public function processPurchase(array $data): array
  {
    Log::alert('Processing purchases...');

    return [
      'success' => true,
    ];
  }
}
