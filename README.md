Composer Merge Plugin
=====================

Merge one or more additional composer.json files at runtime.

Installation
------------
```
$ composer require wikimedia/composer-merge-plugin
```

Usage
-----

```
{
    "require": {
        "wikimedia/composer-merge-plugin": "dev-master"
    },
    "extra": {
        "merge-plugin": {
            "include": [
                "composer.local.json",
                "extensions/*/composer.json"
            ]
        }
    }
}
```

The `include` key can specify either a single value or an array of values.
Each value is treated as a glob() pattern identifying additional composer.json
style configuration files to merge into the configuration for the current
Composer execution.

The "require", "require-dev", "repositories" and "suggest" sections of the
found configuration files will be merged into the root package configuration
as though they were directly included in the top-level composer.json file.

Running tests
-------------
```
$ composer install
$ composer test
```
