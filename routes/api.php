<?php

use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1/settings', 'name' => 'api.'], function () {
    Route::get('{key}', [SettingsController::class, 'getSetting'])->name('settings.get')->middleware('throttle:100,1');
    Route::get('/', [SettingsController::class, 'getSettings'])->name('settings.all')->middleware('throttle:100,1');
});
