<?php

namespace App\Providers;

use App\Services\ViewIntegrationService;
use Filament\Notifications\Livewire\Notifications;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        $configValues = [
            'app.name' => settings('internal.app.name', config('app.name')),
            'app.url' => settings('internal.app.url', config('app.url')),
            'app.timezone' => settings('internal.app.timezone', config('app.timezone')),
            'app.locale' => settings('internal.app.lang', config('app.locale')),
            'settings.disable_db_settings' => settings('internal.app.disable_db_settings', config('settings.disable_db_settings')),
            'settings.force_https' => settings('internal.app.force_https', config('settings.force_https')),
            'settings.notifications.alignment' => settings('internal.app.notifications.alignment', config('settings.notifications.alignment')),
            'settings.notifications.vertical_alignment' => settings('internal.app.notifications.vertical_alignment', config('settings.notifications.vertical_alignment')),
        ];

        if (!config('settings.disable_db_settings') && config('app.env') !== 'testing') {
            foreach ($configValues as $key => $value) {
                Config::set($key, $value);
            }
        }

        Notifications::alignment(Alignment::tryFrom(settings('internal.app.notifications.alignment', 'center')));
        Notifications::verticalAlignment(VerticalAlignment::tryFrom(settings('internal.app.notifications.vertical_alignment', 'end')));
        Notification::configureUsing(function (Notification $notification): void {
            $notification->view('components.cf.notification');
        });

        if (Str::startsWith(config('app.url') ?? '', 'https://') || settings('internal.app.force_https')) {
            URL::forceScheme('https');
        }
    }
}
