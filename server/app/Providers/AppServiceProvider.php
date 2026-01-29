<?php

namespace App\Providers;

use App\Service\IUserService;
use App\Service\IAuthService;
use App\Service\Impl\AuthService;
use App\Service\Impl\PurchaseService;
use App\Service\Impl\UserService;
use App\Service\Impl\WalletService;
use App\Service\IPurchaseService;
use App\Service\IWalletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            IAuthService::class,
            AuthService::class
        );

        $this->app->bind(
            IPurchaseService::class,
            PurchaseService::class
        );

        $this->app->bind(
            IWalletService::class,
            WalletService::class
        );

        $this->app->bind(
            IUserService::class,
            UserService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
