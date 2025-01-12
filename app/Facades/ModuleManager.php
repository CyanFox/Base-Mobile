<?php

namespace App\Facades;

use App\Services\ModuleService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array|null getRequirements(string $module)
 * @method static bool checkRequirements(string $module)
 * @method static string|null getVersion(string $module)
 * @method static string|null getBaseVersion(string $module)
 * @method static bool checkBaseVersion(string $module)
 * @method static array|null getAuthors(string $module)
 * @method static array|null getKeywords(string $module)
 * @method static string|null getDescription(string $module)
 * @method static string|null getSettingsPage(string $module)
 * @method static string|null getRemoteVersion(string $module)
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
