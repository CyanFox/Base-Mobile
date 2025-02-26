<?php

return [
    'base_url' => env('BASE_VERSION_URL', 'https://raw.githubusercontent.com/CyanFox-Projects/CyanFox-Base/v4/version.json'),
    'logo_path' => '/img/Logo.svg',
    'disable_db_settings' => env('DISABLE_DB_SETTINGS', false),
    'settings.force_https' => env('FORCE_HTTPS', false),
];
