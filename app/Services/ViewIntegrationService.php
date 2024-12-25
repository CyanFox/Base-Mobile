<?php

namespace App\Services;

use Illuminate\Support\Facades\Blade;

class ViewIntegrationService
{
    protected array $sections = [];

    protected ?string $currentSection = null;

    public function registerBladeDirectives()
    {
        Blade::directive('cfSection', function ($expression) {
            return "<?php app('".ViewIntegrationService::class."')->startSection($expression); ob_start(); ?>";
        });

        Blade::directive('cfEndSection', function () {
            return "<?php \$content = ob_get_clean(); app('".ViewIntegrationService::class."')->endSection(\$content); ?>";
        });

        Blade::directive('cfOverwriteSection', function ($expression) {
            return "<?php app('".ViewIntegrationService::class."')->startSection($expression); ob_start(); ?>";
        });

        Blade::directive('cfEndOverwriteSection', function () {
            return "<?php \$content = ob_get_clean(); app('".ViewIntegrationService::class."')->endOverwriteSection(\$content); ?>";
        });

        Blade::directive('cfRenderSection', function ($expression) {
            return "<?php echo app('".ViewIntegrationService::class."')->renderSection($expression); ?>";
        });
    }

    public function startSection(string $name)
    {
        $this->currentSection = $name;
    }

    public function endSection(string $content)
    {
        if ($this->currentSection) {
            $this->addSection($this->currentSection, $content);
            $this->currentSection = null;
        }
    }

    public function endOverwriteSection(string $content)
    {
        if ($this->currentSection) {
            $this->overwriteSection($this->currentSection, $content);
            $this->currentSection = null;
        }
    }

    public function addSection(string $name, string $content)
    {
        $this->sections[$name][] = $content;
    }

    public function overwriteSection(string $name, string $content)
    {
        $this->sections[$name] = [$content];
    }

    public function renderSection(string $name): ?string
    {
        if (! isset($this->sections[$name])) {
            return null;
        }

        return implode('', $this->sections[$name]);
    }
}
