# An easy to use Fractal wrapper built for Laravel and Lumen applications

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)
[![run-tests](https://github.com/spatie/laravel-fractal/actions/workflows/run-tests.yml/badge.svg)](https://github.com/spatie/laravel-fractal/actions/workflows/run-tests.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/laravel-fractal.svg?style=flat-square)](https://packagist.org/packages/spatie/laravel-fractal)

The package provides a nice and easy wrapper around [Fractal](http://fractal.thephpleague.com/)
for use in your Laravel applications. If you don't know what Fractal does, [take a peek at their intro](http://fractal.thephpleague.com/).
Shortly said, Fractal is very useful to transform data before using it in an API.

Using Fractal data can be transformed like this:

```php
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

$books = [
   ['id' => 1, 'title' => 'Hogfather', 'characters' => [...]],
   ['id' => 2, 'title' => 'Game Of Kill Everyone', 'characters' => [...]]
];

$manager = new Manager();

$resource = new Collection($books, new BookTransformer());

$manager->parseIncludes('characters');

$manager->createData($resource)->toArray();
```

This package makes that process a tad easier:

```php
fractal()
   ->collection($books)
   ->transformWith(new BookTransformer())
   ->includeCharacters()
   ->toArray();
```

Lovers of facades will be glad to know that a facade is provided:
```php
Fractal::collection($books)->transformWith(new BookTransformer())->toArray();
```

There's also a very short syntax available to quickly transform data:

```php
fractal($books, new BookTransformer())->toArray();
```

You can transform directly from a Laravel collection as well:

```php
collect($books)->transformWith(new BookTransformer());
```

Transforming right from a Laravel collection is particularly useful for Eloquent results:

```php
Users::all()->transformWith(new UserTransformer())->toArray();
```

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all
our open source projects [on our website](https://spatie.be/opensource).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/laravel-fractal.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/laravel-fractal)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Installation in Laravel 5.5 and up

You can pull in the package via composer:
``` bash
composer require spatie/laravel-fractal
```

The package will automatically register itself.

If you want to [change the default serializer](https://github.com/spatie/fractalistic#changing-the-default-serializer),
the [default paginator](https://github.com/spatie/fractalistic#using-pagination),
or the default fractal class `Spatie\Fractal\Fractal`
you must publish the config file:

```bash
php artisan vendor:publish --provider="Spatie\Fractal\FractalServiceProvider"
```

> If you're upgrading to Laravel 5.5, the existing config file should be renamed from _laravel-fractal.php_ to _fractal.php_

This is the contents of the published file:

```php
return [
    /*
     * The default serializer to be used when performing a transformation. It
     * may be left empty to use Fractal's default one. This can either be a
     * string or a League\Fractal\Serializer\SerializerAbstract subclass.
     */
    'default_serializer' => '',

    /* The default paginator to be used when performing a transformation. It
     * may be left empty to use Fractal's default one. This can either be a
     * string or a League\Fractal\Paginator\PaginatorInterface subclass.
     */
    'default_paginator' => '',

    /*
     * League\Fractal\Serializer\JsonApiSerializer will use this value
     * as a prefix for generated links. Set to `null` to disable this.
     */
    'base_url' => null,

    /*
     * If you wish to override or extend the default Spatie\Fractal\Fractal
     * instance provide the name of the class you want to use.
     */
    'fractal_class' => Spatie\Fractal\Fractal::class,

    'auto_includes' => [

        /*
         * If enabled Fractal will automatically add the includes who's
         * names are present in the `include` request parameter.
         */
        'enabled' => true,

        /*
         * The name of key in the request to where we should look for the includes to include.
         */
        'request_key' => 'include',
    ],

    'auto_excludes' => [

        /*
         * If enabled Fractal will automatically add the excludes who's
         * names are present in the `exclude` request parameter.
         */
        'enabled' => true,

        /*
         * The name of key in the request to where we should look for the excludes to exclude.
         */
        'request_key' => 'exclude',
    ],

    'auto_fieldsets' => [

        /*
         * If enabled Fractal will automatically add the fieldsets who's
         * names are present in the `fields` request parameter.
         */
        'enabled' => true,

        /*
         * The name of key in the request, where we should look for the fieldsets to parse.
         */
        'request_key' => 'fields',
    ],
];
```

## Usage

Refer to [the documentation of `spatie/fractalistic`](https://github.com/spatie/fractalistic) to learn all the methods this package provides.

In all code examples you may use `fractal()` instead of `Fractal::create()`.

## Send a response with transformed data

To return a response with json data you can do this in a Laravel app.

```php
$books = fractal($books, new BookTransformer())->toArray();

return response()->json($books);
```

The `respond()` method on the Fractal class can make this process a bit more streamlined.

```php
return fractal($books, new BookTransformer())->respond();
```

You can pass a response code as the first parameter and optionally some headers as the second

```php
return fractal($books, new BookTransformer())->respond(403, [
    'a-header' => 'a value',
    'another-header' => 'another value',
]);
```

You can pass json encoding options as the third parameter:

```php
return fractal($books, new BookTransformer())->respond(200, [], JSON_PRETTY_PRINT);
```

You can also set the status code and the headers using a callback:

```php
use Illuminate\Http\JsonResponse;

return fractal($books, new BookTransformer())->respond(function(JsonResponse $response) {
    $response
        ->setStatusCode(403)
        ->header('a-header', 'a value')
        ->withHeaders([
            'another-header' => 'another value',
            'yet-another-header' => 'yet another value',
        ]);
});
```

You can add methods to the Fractal class using Laravel's Macroable trait. Imagine you want to add some stats to the metadata of your request, you can do so without cluttering your code:

```php
use Spatie\Fractal\Fractal;

Fractal::macro('stats', function ($stats) {
    // transform the passed stats as necessary here
    return $this->addMeta(['stats' => $stats]);
});

fractal($books, new BookTransformer())->stats(['runtime' => 100])->respond();
```

## Quickly creating a transformer

You can run the `make:transformer` command to quickly generate a dummy transformer. By default it will be stored in the `app\Transformers` directory.

## Upgrading

## From v4 to v5

Rename your config file from `laravel-fractal` to `fractal`

### From v2 to v3

`v3` was introduced to swap out the `league/fractal` with `spatie/fractalistic`. Support for Lumen was dropped. You should be able to upgrade a Laravel application from `v2` to `v3` without any code changes.
### From v1 to v2

In most cases you can just upgrade to `v2` with making none or only minor changes to your code:

- `resourceName` has been renamed to `withResourceName`.

The main reason why `v2` of this package was tagged is because v0.14 of the underlying [Fractal](http://fractal.thephpleague.com/) by the League contains breaking change. If you use the `League\Fractal\Serializer\JsonApiSerializer` in v2 the `links` key will contain `self`, `first`, `next` and `last`.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security

If you've found a bug regarding security please mail [security@spatie.be](mailto:security@spatie.be) instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://twitter.com/freekmurze)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
