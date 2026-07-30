<?php

/**
 * Load the composer's autoload file so that we don't have to require files
 * manually in our code. Also load helper classes for tests.
 */

$vendor_dir = getenv('COMPOSER_VENDOR_DIR') ?: 'vendor';

require __DIR__ . '/../' . $vendor_dir . '/autoload.php';
