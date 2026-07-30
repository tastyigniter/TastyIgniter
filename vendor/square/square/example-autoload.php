<?php
/**
 * An example of an autoload register for manual installation
 * 
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Square\Baz class
 * from /path/to/project/src/Baz.php:
 * 
 *      new \Square\Baz;
 *      
 * @param string $class The fully-qualified class name.
 * @return void
 */
spl_autoload_register(function ($class) {

    /**
     * An array with project-specific namespace prefix as keys and location relative to this autoloader.php file as values
     * You can find this information in each of the package's composer.json file on the  "autoload" field
     * 
     * NOTE: The key of the autoload object denotes the format used.
     * If the key is "psr-4" then there is no need to append the namespace to the path.
     * if the key is "psr-0" then the namespace needs to be appended. Unirest is an example of the psr-0 format.
     */
    $prefixToLocation = [
        "Square\\" => "/square-php-sdk/src/",
        "apimatic\\jsonmapper\\" => "/jsonmapper/src/",
        // This is the Namespace and location from Apimatic/Unirest's composer.json
        "Unirest\\" => "/unirest-php/src/",
    ];

    $matchingPrefix;
    foreach ($prefixToLocation as $prefix => $location) {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            // no, move to the next registered autoloader
            continue;
        } else {
            $matchingPrefix = $prefix;
        }
    }

    if (!$matchingPrefix) return; // ClassPrefix was not found return

    // base directory for the namespace prefix
    $base_dir = (__DIR__ . $prefixToLocation[$matchingPrefix]);

    // get the relative class name
    $relative_class = substr($class, strlen($matchingPrefix));

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }else {
        echo("Error loading: " . $file . "\r\n");
    }
});