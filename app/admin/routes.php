<?php
/*
 * Register Admin app routes
 *
 * The Admin app intercepts all URLs
 * prefixed with /admin.
 */
Route::group(['middleware' => 'web'], function () {
    Route::group(['prefix' => config('system.adminUri', '/admin')], function () {
        Route::any('{slug}', 'System\Classes\Controller@runAdmin')->where('slug', '(.*)?');
    });

    // Admin entry point
    Route::any(config('system.adminUri', '/admin'), 'System\Classes\Controller@runAdmin');
});
