<?php
App::before(function () {
    /*
     * Register Admin app routes
     *
     * The Admin app intercepts all URLs
     * prefixed with /admin.
     */
    Route::group(['middleware' => 'web'], function () {
        Route::group(['prefix' => config('system.adminUri', '/admin')], function () {
            // Register Assets Combiner routes
            Route::group(['prefix' => config('system.assetsCombinerUri', '/_assets')], function () {
                Route::any('{asset}', 'System\Classes\Controller@combineAssets');
            });

            Route::any('{slug}', 'System\Classes\Controller@runAdmin')->where('slug', '(.*)?');
        });

        // Admin entry point
        Route::any(config('system.adminUri', '/admin'), 'System\Classes\Controller@runAdmin');
    });
});
