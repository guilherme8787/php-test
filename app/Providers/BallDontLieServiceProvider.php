<?php

namespace App\Providers;

use App\Services\BallDontLie\BallDontLieService;
use App\Services\BallDontLie\Contracts\BallDontLieServiceContract;
use Illuminate\Support\ServiceProvider;

class BallDontLieServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            BallDontLieServiceContract::class,
            BallDontLieService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): array
    {
        return [
            BallDontLieServiceContract::class,
        ];
    }
}
