<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\PathParameter;
use Exception;
use Illuminate\Http\Request;

#[Group('Settings')]
class SettingsController
{

    #[PathParameter('key', description: 'The key of the setting to retrieve', required: true, example: 'internal.app.name')]
    public function getSetting(Request $request, $key)
    {
        $setting = Setting::where(['key' => $key, 'is_public' => true])->first();

        if (!$setting) {
            return apiResponse('Setting not found', null, false, 404);
        }

        try {
            $setting->value = decrypt($setting->value);
        } catch (Exception) {
        }

        return apiResponse('Setting retrieved successfully', $setting);
    }

    public function getSettings()
    {
        $settings = Setting::where('is_public', true)->get();

        foreach ($settings as $setting) {
            try {
                $setting->value = decrypt($setting->value);
            } catch (Exception) {
            }
        }

        return apiResponse('Settings retrieved successfully', $settings);
    }
}
