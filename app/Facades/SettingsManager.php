<?php

namespace App\Facades;

use App\Services\SettingsService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null getSetting(string $key, void $isLocked = false, bool $isEncrypted = true)
 * @method static \App\Models\Setting setSetting(string $key, string|null $value = null, bool $isLocked = false, bool $isEncrypted = true, bool $updateIfExists = false)
 * @method static \App\Models\Setting updateSetting(string $key, string|null $value, bool $isLocked = false, bool $isEncrypted = true)
 * @method static void updateSettings(array $settings)
 * @method static bool deleteSetting(string $key)
 *
 * @see \App\Services\SettingsService
 */
class SettingsManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SettingsService::class;
    }
}
