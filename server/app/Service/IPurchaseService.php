<?php

namespace App\Service;

use App\Models\User;

interface IPurchaseService
{
  public function initiate(array $data, User $user): array;

  public function processPurchase(array $data): array;
}
