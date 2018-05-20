<?php
App::before(function () {
    /*
     * Register Assets Combiner routes
     *
     * The Admin app intercepts all URLs
     * prefixed with /_assets.
     */
    Route::group(['prefix' => config('system.assetsCombinerUri', '/_assets')], function () {
        Route::any('{asset}', 'System\Classes\Controller@combineAssets');
    });
});
