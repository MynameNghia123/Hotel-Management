<?php

namespace App\Providers;

use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Implementations\EloquentAuthRepository;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Implementations\AuthService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Authentication Repository
        $this->app->bind(
            AuthRepositoryInterface::class,
            EloquentAuthRepository::class
        );

        // Register Authentication Service
        $this->app->bind(
            AuthServiceInterface::class,
            AuthService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
