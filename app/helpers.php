<?php

use App\Facades\SettingsManager;
use App\Services\ModuleService;
use App\Services\SettingsService;
use App\Services\ViewIntegrationService;
use Illuminate\Support\Carbon;

if (! function_exists('viewIntegration')) {
    function viewIntegration(): ViewIntegrationService
    {
        return app(ViewIntegrationService::class);
    }
}

if (! function_exists('settings')) {
    function settings($key = null, $default = null, $isLocked = false)
    {
        if ($key === null) {
            return new SettingsService;
        }

        return SettingsManager::getSetting($key, $default, $isLocked);
    }
}

if (! function_exists('modules')) {
    function modules()
    {
        return new ModuleService;
    }
}

if (! function_exists('formatFileSize')) {
    function formatFileSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $bytes > 0 ? min(floor(log($bytes, 1024)), count($units) - 1) : 0;
        $size = round($bytes / pow(1024, $power), 2);

        return $size.' '.$units[$power];
    }
}

if (! function_exists('formatDateTime')) {
    function formatDateTime($date, $format = null): string
    {
        if (blank($date)) {
            return '';
        }

        if ($format) {
            return Carbon::parse($date)->format($format);
        }

        return Carbon::parse($date)->format(settings('internal.app.date_format', 'Y-m-d').' '.settings('internal.app.time_format', 'H:i'));
    }
}

if (! function_exists('formatDate')) {
    function formatDate($date, $format = null): string
    {
        if (blank($date)) {
            return '';
        }

        if ($format) {
            return Carbon::parse($date)->format($format);
        }

        return Carbon::parse($date)->format(settings('internal.app.date_format', 'Y-m-d'));
    }
}

if (! function_exists('formatTime')) {
    function formatTime(string $time, $format = null): string
    {
        if (blank($time)) {
            return '';
        }

        if ($format) {
            return Carbon::parse($time)->format($format);
        }

        return Carbon::parse($time)->format(settings('internal.app.time_format', 'H:i'));
    }
}

if (! function_exists('carbon')) {
    function carbon($time = null, $tz = null): Carbon
    {
        return new Carbon($time, $tz);
    }
}
