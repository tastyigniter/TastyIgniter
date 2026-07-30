<?php

use Igniter\Flame\Currency\Converters\FixerIO;
use Igniter\Flame\Currency\Converters\OpenExchangeRates;
use Igniter\Flame\Currency\Formatters\PHPIntl;
use Igniter\System\Models\Currency;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Currency
    |--------------------------------------------------------------------------
    |
    | The application currency determines the default currency that will be
    | used by the currency service provider. You are free to set this value
    | to any of the currencies which will be supported by the application.
    |
    */

    'default' => 'USD',

    /*
    |--------------------------------------------------------------------------
    | Default Currency Converter
    |--------------------------------------------------------------------------
    |
    */

    'converter' => 'openexchangerates',

    /*
    |--------------------------------------------------------------------------
    | Converters Specific Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many converters as you wish.
    |
    */

    'converters' => [

        'fixerio' => [
            'class' => FixerIO::class,
            'apiKey' => '',
        ],

        'openexchangerates' => [
            'class' => OpenExchangeRates::class,
            'apiKey' => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Storage Model
    |--------------------------------------------------------------------------
    |
    | Here you may specify the model that should be used.
    |
    */

    'model' => Currency::class,

    /*
    |--------------------------------------------------------------------------
    | Default Storage Driver
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default cache driver that should be used
    | by the framework.
    |
    | Supported: all cache drivers supported by Laravel
    |
    */

    'cache_driver' => null,

    /*
    |-----------------------------------------------------------------------
    | Cache Duration
    |-----------------------------------------------------------------------
    |
    | Specify the exchange rates cache duration in hours.
    |
    | Default: 1 hour
    |
    */

    'ratesCacheDuration' => 4320,

    /*
    |--------------------------------------------------------------------------
    | Currency Formatter
    |--------------------------------------------------------------------------
    |
    | Here you may configure a custom formatting of currencies. The reason for
    | this is to help further internationalize the formatting past the basic
    | format column in the table. When set to `null` the package will use the
    | format from storage.
    |
    | More info:
    | http://lyften.com/projects/laravel-currency/doc/formatting.html
    |
    */

    'formatter' => null,

    /*
    |--------------------------------------------------------------------------
    | Currency Formatter Specific Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many currency formatters as you wish.
    |
    */

    'formatters' => [

        'php_intl' => [
            'class' => PHPIntl::class,
        ],

    ],
];
