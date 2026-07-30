# A developer friendly wrapper around Fractal

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/fractalistic.svg?style=flat-square)](https://packagist.org/packages/spatie/fractalistic)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/spatie/fractalistic/run-tests.yml?branch=main&label=tests&style=flat-square)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/fractalistic.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/fractalistic)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/fractalistic.svg?style=flat-square)](https://packagist.org/packages/spatie/fractalistic)

[Fractal](http://fractal.thephpleague.com/) is an amazing package to transform data before using it in an API. Unfortunately working with Fractal can be a bit verbose.

Using Fractal data can be transformed like this:

```php
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

$books = [
   ['id'=>1, 'title'=>'Hogfather', 'characters' => [...]], 
   ['id'=>2, 'title'=>'Game Of Thrones', 'characters' => [...]]
];

$manager = new Manager();

$resource = new Collection($books, new BookTransformer());

$manager->parseIncludes('characters');

$manager->createData($resource)->toArray();
```

This package makes that process a tad easier:

```php
Fractal::create()
   ->collection($books)
   ->transformWith(new BookTransformer())
   ->includeCharacters()
   ->toArray();
```

There's also a very short syntax available to quickly transform data:

```php
Fractal::create($books, new BookTransformer())->toArray();
```

If you want to use this package inside Laravel, it's recommend to use [laravel-fractal](https://github.com/spatie/laravel-fractal) instead. That package contains a few more whistles and bells specifically targetted at Laravel users.


Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all 
our open source projects [on our website](https://spatie.be/opensource).

## Support us

[<img src="https://github-ads.s3.eu-central-1.amazonaws.com/fractalistic.jpg?t=1" width="419px" />](https://spatie.be/github-ad-click/fractalistic)

We invest a lot of resources into creating [best in class open source packages](https://spatie.be/open-source). You can support us by [buying one of our paid products](https://spatie.be/open-source/support-us).

We highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using. You'll find our address on [our contact page](https://spatie.be/about-us). We publish all received postcards on [our virtual postcard wall](https://spatie.be/open-source/postcards).

## Install

You can pull in the package via composer:

``` bash
composer require spatie/fractalistic
```

## Usage

In the following examples were going to use the following array as example input:

```php
$books = [['id'=>1, 'title'=>'Hogfather'], ['id'=>2, 'title'=>'Game Of Kill Everyone']];
```

But know that any structure that can be looped (for instance a collection) can be used.

Let's start with a simple transformation.

```php
Spatie\Fractalistic\Fractal::create()
   ->collection($books)
   ->transformWith(function($book) { return ['id' => $book['id']];})
   ->toArray();
``` 

This will return:
```php
['data' => [['id' => 1], ['id' => 2]]
```

In all following examples it's assumed that you imported the `Spatie\Fractalistic\Fractal` at the top of your php file.

Instead of using a closure you can also pass [a Transformer](http://fractal.thephpleague.com/transformers/):

```php
Fractal::create()
   ->collection($books)
   ->transformWith(new BookTransformer())
   ->toArray();
```

You can also pass the classname of the Transformer:

```php
Fractal::create()
   ->collection($books)
   ->transformWith(BookTransformer::class)
   ->toArray();
```

To make your code a bit shorter you could also pass the transform closure, class, or classname as a 
second parameter of the `collection`-method:

```php
Fractal::create()->collection($books, new BookTransformer())->toArray();
```

Want to get some sweet json output instead of an array? No problem!
```php
Fractal::create()->collection($books, new BookTransformer())->toJson();
```

A single item can also be transformed:
```php
Fractal::create()->item($books[0], new BookTransformer())->toArray();
```

## Using a serializer

Let's take a look again at the output of the first example:

```php
['data' => [['id' => 1], ['id' => 2]];
```

Notice that `data`-key? That's part of Fractal's default behaviour. Take a look at
[Fractals's documentation on serializers](http://fractal.thephpleague.com/serializers/) to find out why that happens.

If you want to use another serializer you can specify one with the `serializeWith`-method.
The `Spatie\Fractalistic\ArraySerializer` comes out of the box. It removes the `data` namespace for
both collections and items.

```php
Fractal::create()
   ->collection($books)
   ->transformWith(function($book) { return ['id' => $book['id']];})
   ->serializeWith(new \Spatie\Fractalistic\ArraySerializer())
   ->toArray();

//returns [['id' => 1], ['id' => 2]]
```

You can also pass the serializer classname instead of an instantiation:

```php
Fractal::create()
   ->collection($books)
   ->transformWith(BookTransformer::class)
   ->serializeWith(MySerializer::class)
   ->toArray();
```

### Changing the default serializer

You can change the default serializer by providing the classname or an instantiation of your favorite serializer in
the config file.

## Using includes

Fractal provides support for [optionally including data](http://fractal.thephpleague.com/transformers/) on the relationships for
the data you're exporting. You can use Fractal's `parseIncludes` which accepts a string or an array:

```php
Fractal::create()
   ->collection($this->testBooks, new TestTransformer())
   ->parseIncludes(['characters', 'publisher'])
   ->toArray();
```

To improve readablity you can also use a function named `include` followed by the name
of the include you want to... include:

```php
Fractal::create()
   ->collection($this->testBooks, new TestTransformer())
   ->includeCharacters()
   ->includePublisher()
   ->toArray();
```

## Using excludes

Similar to includes Fractal also provides support for [optionally excluding data](http://fractal.thephpleague.com/transformers/) on the relationships for
the data you're exporting. You can use Fractal's `parseExcludes` which accepts a string or an array:

```php
Fractal::create()
   ->collection($this->testBooks, new TestTransformer())
   ->parseExcludes(['characters', 'publisher'])
   ->toArray();
```

To improve readability you can also use a function named `exclude` followed by the name
of the include you want to... exclude:

```php
Fractal::create()
   ->collection($this->testBooks, new TestTransformer())
   ->excludeCharacters()
   ->excludePublisher()
   ->toArray();
```

## Including meta data

Fractal has support for including meta data. You can use `addMeta` which accepts 
one or more arrays:

```php
Fractal::create()
   ->collection($this->testBooks, function($book) { return ['name' => $book['name']];})
   ->addMeta(['key1' => 'value1'], ['key2' => 'value2'])
   ->toArray();
```

This will return the following array:

```php
[
   'data' => [
        ['title' => 'Hogfather'],
        ['title' => 'Game Of Thrones'],
    ],
   'meta' => [
        ['key1' => 'value1'], 
        ['key2' => 'value2'],
    ]
];
```

## Using pagination

Fractal provides a Laravel-specific paginator, `IlluminatePaginatorAdapter`, which accepts an instance of Laravel's `LengthAwarePaginator`
and works with paginated Eloquent results. When using some serializers, such as the `JsonApiSerializer`, pagination data can be
automatically generated and included in the result set:

```php
$paginator = Book::paginate(5);
$books = $paginator->getCollection();

Fractal::create()
    ->collection($books, new TestTransformer())
    ->serializeWith(new JsonApiSerializer())
    ->paginateWith(new IlluminatePaginatorAdapter($paginator))
    ->toArray();
```

## Using a cursor

Fractal provides a simple cursor class, `League\Fractal\Pagination\Cursor`. You can use any other cursor class as long as it implements the `League\Fractal\Pagination\CursorInterface` interface. When using it, the cursor information will be automatically included in the result metadata:

```php
$books = $paginator->getCollection();

$currentCursor = 0;
$previousCursor = null;
$count = count($books);
$newCursor = $currentCursor + $count;

Fractal::create()
  ->collection($books, new TestTransformer())
  ->serializeWith(new JsonApiSerializer())
  ->withCursor(new Cursor($currentCursor, $previousCursor, $newCursor, $count))
  ->toArray();
```

## Setting a custom resource name

Certain serializers wrap the array output with a `data` element. The name of this element can be customized:

```php
Fractal::create()
    ->collection($this->testBooks, new TestTransformer())
    ->serializeWith(new ArraySerializer())
    ->withResourceName('books')
    ->toArray();
```

```php
Fractal::create()
    ->item($this->testBooks[0], new TestTransformer(), 'book')
    ->serializeWith(new ArraySerializer())
    ->toArray();
```

## Limit recursion

 To increase or decrease the level of embedded includes you can use `limitRecursion`. 
 
 ```php
 Fractal::create()
     ->collection($this->testBooks, new TestTransformer())
     ->includesDataThatHasALotOfRecursion
     ->limitRecursion(5);
 ```

If you do not call `limitRecursion` a default value of 10 is used.

## Quickly transform data with the short function syntax

You can also pass arguments to the `fractal`-function itself. The first arguments should be the data you which to transform. The second one should be a transformer or a `closure` that will be used to transform the data. The third one should be a serializer.

Here are some examples

```php
Fractal::create($books, new BookTransformer())->toArray();

Fractal::create($books, new BookTransformer(), new ArraySerializer())->toArray();

Fractal::create($books, BookTransformer::class, ArraySerializer::class)->toArray();

Fractal::create(['item1', 'item2'], function ($item) {
   return $item . '-transformed';
})->toArray();
```

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

## Postcardware

You're free to use this package, but if it makes it to your production environment we highly appreciate you sending us a postcard from your hometown, mentioning which of our package(s) you are using.

Our address is: Spatie, Kruikstraat 22, 2018 Antwerp, Belgium.

We publish all received postcards [on our company website](https://spatie.be/en/opensource/postcards).

## Credits

- [Freek Van der Herten](https://twitter.com/freekmurze)
- [All contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
