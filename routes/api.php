<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SpotlightController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1/settings', 'name' => 'api.'], function () {
    Route::get('{key}', [SettingsController::class, 'getSetting'])->name('settings.get')->middleware('throttle:100,1');
    Route::get('/', [SettingsController::class, 'getSettings'])->name('settings.all')->middleware('throttle:100,1');
});

Route::group(['prefix' => 'v1/spotlight', 'name' => 'api.'], function () {
    Route::get('search', [SpotlightController::class, 'searchSpotlight'])->name('spotlight.search')->middleware('throttle:100,1');
    Route::get('static', [SpotlightController::class, 'getStaticItems'])->name('spotlight.static')->middleware('throttle:100,1');
    Route::get('manual', [SpotlightController::class, 'getManualItems'])->name('spotlight.manual')->middleware('throttle:100,1');
});
