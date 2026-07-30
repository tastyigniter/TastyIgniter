<?php

return [

    /*
     * Here you can register fonts to call from the @googlefonts Blade directive.
     * The google-fonts:fetch command will prefetch these fonts.
     */
    'fonts' => [
        'default' => 'https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,400;0,700;1,400;1,700',
    ],

    /*
     * This disk will be used to store local Google Fonts. The public disk
     * is the default because it can be served over HTTP with storage:link.
     */
    'disk' => 'public',

    /*
     * Prepend all files that are written to the selected disk with this path.
     * This allows separating the fonts from other data in the public disk.
     */
    'path' => 'fonts',

    /*
     * By default, CSS will be inlined to reduce the amount of round trips
     * browsers need to make in order to load the requested font files.
     */
    'inline' => true,

    /*
     * When preload is set to true, preload meta tags will be generated
     * in the HTML output to instruct the browser to start fetching the
     * font files as early as possible, even before the CSS is fully parsed.
     */
    'preload' => false,

    /*
     * When something goes wrong fonts are loaded directly from Google.
     * With fallback disabled, this package will throw an exception.
     */
    'fallback' => ! env('APP_DEBUG'),

    /*
     * This user agent will be used to request the stylesheet from Google Fonts.
     * This is the Safari 14 user agent that only targets modern browsers. If
     * you want to target older browsers, use different user agent string.
     */
    'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Safari/605.1.15',

];
