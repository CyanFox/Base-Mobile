<?php

namespace App\Http;

use App\Services\ViewIntegrationService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void add(string $name, ...$params)
 * @method static void addView(string $name, string $view)
 * @method static void get(string|null $name = null)
 * @method static array getAll()
 * @method static string|null render(string $name, \Closure $callback)
 *
 * @see ViewIntegrationService
 */
class ViewIntegrationManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ViewIntegrationService::class;
    }
}
