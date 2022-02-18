<?php

require __DIR__.'/../bootstrap/autoload.php';

$loader = new Igniter\Flame\Support\ClassLoader(
    new Igniter\Flame\Filesystem\Filesystem,
    __DIR__.'/../',
    __DIR__.'/../storage/framework/classes.php'
);

$loader->register();

$loader->addDirectories([
    'app',
    'extensions',
]);
