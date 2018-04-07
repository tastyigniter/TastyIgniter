<?php
App::before(function () {
    /*
     * Register Main app routes
     *
     * The Main module intercepts all URLs that were not
     * handled by the admin modules.
     */

    Route::group(['middleware' => 'web'], function () {
        Route::any('{slug}', 'System\Classes\Controller@run')->where('slug', '(.*)?');
    });
});
