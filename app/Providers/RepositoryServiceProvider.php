<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            \App\Repositories\UserRepository::class,
            \App\Repositories\UserRepositoryEloquent::class
        );
        $this->app->bind(
            \App\Repositories\WalletRepository::class,
            \App\Repositories\WalletRepositoryEloquent::class
        );
        $this->app->bind(
            \App\Repositories\TransactionRepository::class,
            \App\Repositories\TransactionRepositoryEloquent::class
        );
    }
}
