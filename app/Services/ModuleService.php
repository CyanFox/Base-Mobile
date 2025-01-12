<?php

namespace App\Services;

use App\Facades\VersionManager;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nwidart\Modules\Facades\Module;

class ModuleService
{
    public function getRequirements(string $module): ?array
    {
        $module = Module::find($module);

        if ($module->get('require') !== null) {
            return $module->get('require');
        }

        return null;
    }

    public function checkRequirements(string $module): bool
    {
        $requirements = $this->getRequirements($module);

        if ($requirements === null) {
            return true;
        }

        foreach ($requirements as $requirement) {
            $module = Module::find($requirement);

            if ($module === null) {
                return false;
            }

            if ($module->isDisabled()) {
                return false;
            }

            if ($module->isEnabled() && !$this->checkRequirements($module->getName())) {
                return false;
            }
        }

        return true;
    }

    public function getVersion(string $module): ?string
    {
        $module = Module::find($module);

        return $module->get('version');
    }

    public function getBaseVersion(string $module): ?string
    {
        $module = Module::find($module);

        return $module->get('version');
    }

    public function checkBaseVersion(string $module): bool
    {
        $module = Module::find($module);

        if ($module->get('base_version') !== null) {
            return version_compare(VersionManager::getCurrentBaseVersion(), $module->get('base_version'), '>=');
        }

        return true;
    }

    public function getAuthors(string $module): ?array
    {
        $module = Module::find($module);

        return $module->get('authors');
    }

    public function getKeywords(string $module): ?array
    {
        $module = Module::find($module);

        return $module->get('keywords');
    }

    public function getDescription(string $module): ?string
    {
        $module = Module::find($module);

        return $module->get('description');
    }


    public function getSettingsPage(string $module): ?string
    {
        $module = Module::find($module);

        if ($module->get('settings_page') !== null && Route::has($module->get('settings_page'))) {
            return route($module->get('settings_page'));
        }

        return null;
    }

    public function getRemoteVersion(string $module): ?string
    {
        $module = Module::find($module);

        if ($module->get('remote_version') !== null) {
            if (Cache::has($module->getName() . '_version')) {
                return Cache::get($module->getName() . '_version');
            }

            $response = Http::get($module->get('remote_version'));
            $response = json_decode($response->body(), true);

            if (!isset($response['version'])) {
                return null;
            }

            Cache::put($module->getName() . '_version', $response['version'], now()->addMinutes(60));

            return $response['version'];
        }

        return null;
    }
}
