<?php

namespace App\Services;

use Exception;

class VersionService
{
    public function getCurrentBaseVersion(): string
    {
        try {
            $file = base_path('version.json');
            $data = json_decode(file_get_contents($file), true);

            if (isset($data['version']['base'])) {
                return $data['version']['base'];
            }
        } catch (Exception) {
            return 'N/A';
        }

        return 'N/A';
    }

    public function getCurrentProjectVersion(): string
    {
        try {
            $file = base_path('version.json');
            $data = json_decode(file_get_contents($file), true);

            if (isset($data['version']['project'])) {
                return $data['version']['project'];
            }
        } catch (Exception) {
            return 'N/A';
        }

        return 'N/A';
    }

    public function isDevVersion(): ?bool
    {
        try {
            $file = base_path('version.json');
            $data = json_decode(file_get_contents($file), true);

            return $data['version']['dev'] ?? false;
        } catch (Exception) {
            return null;
        }
    }

    public function getRemoteTemplateVersion(): string
    {
        if (settings('internal.versions.base_url', config('settings.versions.base_url')) == null) {
            return 'N/A';
        }

        try {
            $url = settings('internal.versions.base_url', config('settings.versions.base_url'));
            $data = json_decode(file_get_contents($url), true);

            if ($data['version']['template'] == null) {
                return 'N/A';
            }

            return $data['version']['template'];
        } catch (Exception) {
            return 'N/A';
        }
    }

    public function getRemoteProjectVersion(): string
    {
        if (settings('internal.versions.project_url', config('settings.versions.project_url')) == null) {
            return 'N/A';
        }

        try {
            $url = settings('internal.versions.project_url', config('settings.versions.project_url'));
            $data = json_decode(file_get_contents($url), true);

            if ($data['version']['project'] == null) {
                return 'N/A';
            }

            return $data['version']['project'];
        } catch (Exception) {
            return 'N/A';
        }
    }

    public function isBaseUpToDate(): bool
    {
        $currentVersion = self::getCurrentTemplateVersion();
        $remoteVersion = self::getRemoteTemplateVersion();

        if ($currentVersion == null || $remoteVersion == null
            || $currentVersion == 'N/A' || $remoteVersion == 'N/A') {
            return true;
        }

        return $currentVersion == $remoteVersion;
    }

    public function isProjectUpToDate(): bool
    {
        $currentVersion = self::getCurrentProjectVersion();
        $remoteVersion = self::getRemoteProjectVersion();

        if ($currentVersion == null || $remoteVersion == null
            || $currentVersion == 'N/A' || $remoteVersion == 'N/A') {
            return true;
        }

        return $currentVersion == $remoteVersion;
    }
}
