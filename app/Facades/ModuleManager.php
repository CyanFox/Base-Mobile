<?php

namespace App\Facades;

use App\Services\ModuleService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array|null getRequirements(void $module)
 * @method static bool checkRequirements(void $module)
 * @method static string|null getVersion(void $module)
 * @method static string|null getBaseVersion(void $module)
 * @method static bool checkBaseVersion(void $module)
 * @method static array|null getAuthors(void $module)
 * @method static array|null getKeywords(void $module)
 * @method static string|null getDescription(void $module)
 * @method static string|null getSettingsPage(void $module)
 * @method static string|null getRemoteVersion(void $module)
 *
 * @see \App\Services\ModuleService
 */
class ModuleManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ModuleService::class;
    }
}
