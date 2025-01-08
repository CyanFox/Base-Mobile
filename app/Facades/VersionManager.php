<?php

namespace App\Facades;

use App\Services\VersionService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getCurrentBaseVersion()
 * @method static string getCurrentProjectVersion()
 * @method static bool|null isDevVersion()
 * @method static string getRemoteTemplateVersion()
 * @method static string getRemoteProjectVersion()
 * @method static bool isBaseUpToDate()
 * @method static bool isProjectUpToDate()
 *
 * @see \App\Services\VersionService
 */
class VersionManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return VersionService::class;
    }
}
