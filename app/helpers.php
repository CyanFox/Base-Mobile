<?php

use App\Facades\SettingsManager;
use App\Services\ModuleService;
use App\Services\SettingsService;
use App\Services\ViewIntegrationService;

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
        $power = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $size = round($bytes / pow(1024, $power), 2);

        return $size.' '.$units[$power];
    }
}
