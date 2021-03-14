<?php

namespace App\Providers;

use App\Jobs\Contracts\NotificationJobInterface;
use App\Jobs\NotificationJob;
use App\Services\Contracts\NotificationServiceInterface;
use App\Services\Contracts\TransactionServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use App\Services\Contracts\WalletServiceInterface;
use App\Services\NotificationService;
use App\Services\TransactionService;
use App\Services\UserService;
use App\Services\WalletService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            NotificationJobInterface::class,
            NotificationJob::class,
        );

        $this->app->bind(
            NotificationServiceInterface::class,
            NotificationService::class,
        );
        
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class,
        );

        $this->app->bind(
            WalletServiceInterface::class,
            WalletService::class,
        );

        $this->app->bind(
            TransactionServiceInterface::class,
            TransactionService::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
