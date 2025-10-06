<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\confirm;

class UpdateSettingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bulk update application settings';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settings = multiselect(
            'Settings',
            Setting::all()->pluck('key', 'id')->toArray(),
        );

        $lockSettings = confirm('Lock selected settings?');
        $textareaSettings = confirm('Make selected settings textarea?');
        $publicSettings = confirm('Make selected settings public?');

        Setting::whereIn('id', $settings)->update([
            'is_locked' => $lockSettings,
            'is_textarea' => $textareaSettings,
            'is_public' => $publicSettings,
        ]);

        $this->info('Settings updated successfully.');
    }
}
