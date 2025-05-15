<?php

namespace App\Facades;

use App\Services\VersionService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static string getCurrentBaseVersion()
 * @method static bool|null isDevVersion()
 * @method static string getRemoteBaseVersion()
 * @method static bool isBaseUpToDate()
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
