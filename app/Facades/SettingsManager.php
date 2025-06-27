<?php

namespace App\Facades;

use App\Services\SettingsService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string|null getSetting(string $key, void $default = null, void $isLocked = false, bool $isEncrypted = false)
 * @method static \App\Models\Setting setSetting(string $key, string|null $value = null, bool $isLocked = false, bool $isEncrypted = false, bool $updateIfExists = false)
 * @method static \App\Models\Setting updateSetting(string $key, string|null $value, bool $isLocked = false, bool $isEncrypted = false)
 * @method static void updateSettings(array $settings)
 * @method static bool deleteSetting(string $key)
 *
 * @see SettingsService
 */
class SettingsManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SettingsService::class;
    }
}
