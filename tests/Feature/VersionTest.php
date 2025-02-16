<?php

namespace Tests\Feature;

use App\Facades\VersionManager;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VersionTest extends TestCase
{
    private const MISSING_VERSION = ' This can be due to a missing version.json file.';

    #[Test]
    public function can_get_base_version(): void
    {
        $version = VersionManager::getCurrentBaseVersion();

        if ($version === 'N/A') {
            $this->markTestSkipped('Template version is not available.' . self::MISSING_VERSION);
        }

        $this->assertIsString($version);
    }

    #[Test]
    public function can_get_remote_base_version(): void
    {
        $version = VersionManager::getRemoteBaseVersion();

        if ($version === 'N/A') {
            $this->markTestSkipped('Remote template version is not available. This can be due to a missing version.json file or an invalid URL.');
        }

        $this->assertIsString($version);
    }

    #[Test]
    public function can_get_dev_version(): void
    {
        $isDev = VersionManager::isDevVersion();

        if ($isDev === null) {
            $this->markTestSkipped('Dev version is not available.' . self::MISSING_VERSION);
        }

        $this->assertIsBool($isDev);
    }
}
