<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PurchaseController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth_required');

Route::controller(AuthController::class)->group(function () {
    Route::post('/create', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth_required');
});

Route::controller(PurchaseController::class)->middleware('auth_required')->group(function () {
    Route::post('/', 'makePurchase');
});
