<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\CreatePurchaseRequest;
use App\Service\IPurchaseService;

class PurchaseController extends Controller
{
    public function __construct(
        private readonly IPurchaseService $purchaseService
    ) {}

    public function makePurchase(CreatePurchaseRequest $request)
    {
        $data = $request->validated();
        $user = $request->user('sanctum');

        $response = $this->purchaseService->initiate($data, $user);

        return response()->json([], 200);
    }
}
