<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Default Provider name
    |---------------------------------------------------------------------------
    |
    | The `chain` provider is special, in that it will run all configured
    | providers in the sequence listed, should the previous provider fail.
    |
    */
    'default' => 'chain',

    /*
    |---------------------------------------------------------------------------
    | Providers
    |---------------------------------------------------------------------------
    |
    | Here you may specify any number of providers that should be used to
    | perform geocoding operations.
    |
    | You can explicitly call subsequently listed providers by
    | alias: `resolve(Geocoder::class)->using('google')`.
    |
    */

    'providers' => [
        'google' => [
            'endpoints' => [
                'geocode' => 'https://maps.googleapis.com/maps/api/geocode/json?address=%s',
                'reverse' => 'https://maps.googleapis.com/maps/api/geocode/json?latlng=%F,%F',
                'distance' => 'https://maps.googleapis.com/maps/api/distancematrix/json?destinations=%F,%F&origins=%F,%F',
                'places' => 'https://places.googleapis.com/v1/places',
            ],
            'locale' => 'en-GB',
            'region' => 'GB',
            'apiKey' => null,
        ],
        'nominatim' => [
            'endpoints' => [
                'geocode' => 'https://nominatim.openstreetmap.org/search?q=%s&format=json&addressdetails=1&limit=%d',
                'reverse' => 'https://nominatim.openstreetmap.org/reverse?format=json&lat=%F&lon=%F&addressdetails=1&zoom=%d',
                'distance' => 'https://routing.openstreetmap.de/routed-%s/route/v1/driving/%F,%F;%F,%F',
                'places' => 'https://nominatim.openstreetmap.org/',
            ],
            'locale' => 'en-GB',
            'region' => 'GB',
        ],
    ],

    'cache' => [
        /*
        |-----------------------------------------------------------------------
        | Cache Store
        |-----------------------------------------------------------------------
        |
        | Specify the cache store to use for caching. The value "null" will use
        | the default cache store specified in /config/cache.php file.
        |
        | Default: null
        |
        */

        'store' => null,

        /*
        |-----------------------------------------------------------------------
        | Cache Duration
        |-----------------------------------------------------------------------
        |
        | Specify the cache duration in minutes.
        |
        | Default: 4320 (integer) 30 days
        |
        */

        'duration' => 43200,
    ],

    'precision' => 8,
];
