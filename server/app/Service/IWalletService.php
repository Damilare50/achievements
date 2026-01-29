<?php

namespace App\Service;

interface IWalletService
{
  public function addFunds(string $userId, float $amount, string $narration): array;
}
