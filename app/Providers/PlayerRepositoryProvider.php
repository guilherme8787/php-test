<?php

namespace App\Providers;

use App\Repositories\Player\PlayerRepository;
use App\Repositories\Player\PlayerRepositoryContract;
use Illuminate\Support\ServiceProvider;

class PlayerRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            PlayerRepositoryContract::class,
            PlayerRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): array
    {
        return [
            PlayerRepositoryContract::class,
        ];
    }
}
