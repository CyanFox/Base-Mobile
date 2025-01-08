<?php

namespace App\Providers;

use App\Services\ViewIntegrationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ViewIntegrationService::class, function () {
            return new ViewIntegrationService;
        });
    }

    public function boot(): void
    {
        //
    }
}
