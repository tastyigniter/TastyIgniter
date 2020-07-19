<?php

define('LARAVEL_START', microtime(TRUE));

/*
|--------------------------------------------------------------------------
| Register Core Helpers
|--------------------------------------------------------------------------
|
| This line ensures that the core global helpers are
| always given priority one status and that dependencies are installed.
|
*/

$helperPath = __DIR__.'/../vendor/tastyigniter/flame/src/Support/helpers.php';

if (!file_exists($helperPath)) {
    echo 'Setup required, missing foundation files.'.PHP_EOL;
    echo 'Please run composer install && php artisan igniter:install'.PHP_EOL;
    exit(1);
}

require $helperPath;

/*
|--------------------------------------------------------------------------
| Register The Composer Auto ClassLoader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';
