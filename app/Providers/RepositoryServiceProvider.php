<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Contracts\{
    NotificationRepositoryInterface,
    UserRepositoryInterface,
    TransactionRepositoryInterface,
    WalletRepositoryInterface
};

use App\Repositories\{
    NotificationRepository,
    UserRepository,
    TransactionRepository,
    WalletRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class,
        );

        $this->app->bind(
            TransactionRepositoryInterface::class,
            TransactionRepository::class,
        );

        $this->app->bind(
            WalletRepositoryInterface::class,
            WalletRepository::class,
        );

        $this->app->bind(
            NotificationRepositoryInterface::class,
            NotificationRepository::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
