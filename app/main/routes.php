<?php
App::before(function () {
    /*
     * Register Main app routes
     *
     * The Main module intercepts all URLs that were not
     * handled by the admin modules.
     */

    Route::group(['middleware' => 'web'], function () {
        // Register Assets Combiner routes
        Route::group(['prefix' => config('system.assetsCombinerUri', '/_assets')], function () {
            Route::any('{asset}', 'System\Classes\Controller@combineAssets');
        });

        Route::any('{slug}', 'System\Classes\Controller@run')->where('slug', '(.*)?');
    });
});
