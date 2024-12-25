<?php

namespace App\Providers;

use App\Services\ViewIntegrationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(ViewIntegrationService::class, fn ($app) => new ViewIntegrationService);
    }

    public function boot()
    {
        $this->app->make(ViewIntegrationService::class)->registerBladeDirectives();
    }
}
