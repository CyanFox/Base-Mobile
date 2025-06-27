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

            if (isset($data['base'])) {
                return $data['base'];
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

            return $data['dev'] ?? false;
        } catch (Exception) {
            return null;
        }
    }

    public function getRemoteBaseVersion(): string
    {
        if (settings('internal.versions.base_url', config('settings.base_url')) === null) {
            return 'N/A';
        }

        try {
            $url = settings('internal.versions.base_url', config('settings.base_url'));
            $data = json_decode(file_get_contents($url), true);

            if ($data['base'] === null) {
                return 'N/A';
            }

            return $data['base'];
        } catch (Exception) {
            return 'N/A';
        }
    }

    public function isBaseUpToDate(): bool
    {
        $currentVersion = self::getCurrentBaseVersion();
        $remoteVersion = self::getRemoteBaseVersion();

        if ($currentVersion === 'N/A' || $remoteVersion === 'N/A') {
            return true;
        }

        return $currentVersion === $remoteVersion;
    }
}
