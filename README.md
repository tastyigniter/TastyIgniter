Composer Merge Plugin
=====================

Merge one or more additional composer.json files at runtime.

This plugin will look for a "merge-patterns" key in the composer
configuration's "extra" section. The value of this setting can be either
a single value or an array of values. Each value is treated as a glob()
pattern identifying additional composer.json style configuration files to
merge into the configuration for the current compser execution.

The "require", "require-dev", "repositories" and "suggest" sections of the
found configuration files will be merged into the root package configuration
as though they were directly included in the top-level composer.json file.

Usage
-----

```
{
    "require": {
        "wikimedia/composer-merge-plugin": "dev-master"
    },
    "extra": {
        "merge-plugin": {
            "merge-patterns": [
                "composer.local.json",
                "extensions/*/composer.json"
            ]
        }
    }
}
```

Running tests
-------------
```
$ composer install
$ composer test
```
