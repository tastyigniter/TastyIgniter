<?php
App::before(function () {
    /*
     * Register Main app routes
     *
     * The Main module intercepts all URLs that were not
     * handled by the admin modules.
     */

    Route::group([
        'middleware' => ['web'],
    ], function () {
        // Register Assets Combiner routes
        Route::any(config('system.assetsCombinerUri', '_assets').'/{asset}', 'System\Classes\Controller@combineAssets');

        Route::any('{slug}', 'System\Classes\Controller@run')
            ->where('slug', '(.*)?');
    });
});
