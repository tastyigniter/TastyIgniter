# php-enum
[![Build Status](https://github.com/marc-mabe/php-enum/workflows/Test/badge.svg?branch=master)](https://github.com/marc-mabe/php-enum/actions?query=workflow%3ATest%20branch%3Amaster)
[![Code Coverage](https://codecov.io/github/marc-mabe/php-enum/coverage.svg?branch=master)](https://codecov.io/gh/marc-mabe/php-enum/branch/master/)
[![License](https://poser.pugx.org/marc-mabe/php-enum/license)](https://github.com/marc-mabe/php-enum/blob/master/LICENSE.txt)
[![Latest Stable](https://poser.pugx.org/marc-mabe/php-enum/v/stable.png)](https://packagist.org/packages/marc-mabe/php-enum)
[![Total Downloads](https://poser.pugx.org/marc-mabe/php-enum/downloads.png)](https://packagist.org/packages/marc-mabe/php-enum)
[![Monthly Downloads](https://poser.pugx.org/marc-mabe/php-enum/d/monthly)](https://packagist.org/packages/marc-mabe/php-enum)
[![Dependents](https://poser.pugx.org/marc-mabe/php-enum/dependents)](https://packagist.org/packages/marc-mabe/php-enum/dependents?order_by=downloads)

This is a native PHP implementation to add enumeration support to PHP.
It's an abstract class that needs to be extended to use it.


# What is an Enumeration?

[Wikipedia](http://wikipedia.org/wiki/Enumerated_type)
> In computer programming, an enumerated type (also called enumeration or enum)
> is a data type consisting of a set of named values called elements, members
> or enumerators of the type. The enumerator names are usually identifiers that
> behave as constants in the language. A variable that has been declared as
> having an enumerated type can be assigned any of the enumerators as a value.
> In other words, an enumerated type has values that are different from each
> other, and that can be compared and assigned, but which do not have any
> particular concrete representation in the computer's memory; compilers and
> interpreters can represent them arbitrarily.


# Usage

## Basics

```php
use MabeEnum\Enum;

// define an own enumeration class
class UserStatus extends Enum
{
    const INACTIVE = 'i';
    const ACTIVE   = 'a';
    const DELETED  = 'd';

    // all scalar data types and arrays are supported as enumerator values
    const NIL     = null;
    const BOOLEAN = true;
    const INT     = 1234;
    const STR     = 'string';
    const FLOAT   = 0.123;
    const ARR     = ['this', 'is', ['an', 'array']];

    // Enumerators will be generated from public constants only
    public    const PUBLIC_CONST    = 'public constant';    // this will be an enumerator
    protected const PROTECTED_CONST = 'protected constant'; // this will NOT be an enumerator
    private   const PRIVATE_CONST   = 'private constant';   // this will NOT be an enumerator

    // works since PHP-7.0 - see https://wiki.php.net/rfc/context_sensitive_lexer
    const TRUE      = 'true';
    const FALSE     = 'false';
    const NULL      = 'null';
    const PUBLIC    = 'public';
    const PRIVATE   = 'private';
    const PROTECTED = 'protected';
    const FUNCTION  = 'function';
    const TRAIT     = 'trait';
    const INTERFACE = 'interface';

    // Doesn't work - see https://wiki.php.net/rfc/class_name_scalars
    // const CLASS = 'class';
}

// ways to instantiate an enumerator
$status = UserStatus::get(UserStatus::ACTIVE); // by value or instance
$status = UserStatus::ACTIVE();                // by name as callable
$status = UserStatus::byValue('a');            // by value
$status = UserStatus::byName('ACTIVE');        // by name
$status = UserStatus::byOrdinal(1);            // by ordinal number

// basic methods of an instantiated enumerator
$status->getValue();   // returns the selected constant value
$status->getName();    // returns the selected constant name
$status->getOrdinal(); // returns the ordinal number of the selected constant

// basic methods to list defined enumerators
UserStatus::getEnumerators();  // returns a list of enumerator instances
UserStatus::getValues();       // returns a list of enumerator values
UserStatus::getNames();        // returns a list of enumerator names
UserStatus::getOrdinals();     // returns a list of ordinal numbers
UserStatus::getConstants();    // returns an associative array of enumerator names to enumerator values

// same enumerators (of the same enumeration class) holds the same instance
UserStatus::get(UserStatus::ACTIVE) === UserStatus::ACTIVE()
UserStatus::get(UserStatus::DELETED) != UserStatus::INACTIVE()

// simplified way to compare two enumerators
$status = UserStatus::ACTIVE();
$status->is(UserStatus::ACTIVE);     // true
$status->is(UserStatus::ACTIVE());   // true
$status->is(UserStatus::DELETED);    // false
$status->is(UserStatus::DELETED());  // false
```

## Type-Hint

```php
use MabeEnum\Enum;

class User
{
    protected $status;

    public function setStatus(UserStatus $status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        if (!$this->status) {
            // initialize default
            $this->status = UserStatus::INACTIVE();
        }
        return $this->status;
    }
}
```

### Type-Hint issue

Because in normal OOP the above example allows `UserStatus` and types inherited from it.

Please think about the following example:

```php
class ExtendedUserStatus extends UserStatus
{
    const EXTENDED = 'extended';
}

$user = new User();
$user->setStatus(ExtendedUserStatus::EXTENDED());
```

Now the setter receives a status it doesn't know about but allows it.

#### Solution 1: Finalize the enumeration

```php
final class UserStatus extends Enum
{
    // ...
}

class User
{
    protected $status;

    public function setStatus(UserStatus $status)
    {
        $this->status = $status;
    }
}
````

* Nice and obvious solution

* Resulting behaviour matches native enumeration implementation of most other languages (like Java)

But as this library emulates enumerations it has a few downsides:

* Enumerator values can not be used directly
  * `$user->setStatus(UserStatus::ACTIVE)` fails
  * `$user->setStatus(UserStatus::ACTIVE())` works

* Does not help if the enumeration was defined in an external library


#### Solution 2: Using `Enum::get()`

```php
class User
{
    public function setStatus($status)
    {
        $this->status = UserStatus::get($status);
    }
}
```

* Makes sure the resulting enumerator exactly matches an enumeration. (Inherited enumerators are not allowed).

* Allows enumerator values directly
  * `$user->setStatus(UserStatus::ACTIVE)` works
  * `$user->setStatus(UserStatus::ACTIVE())` works

* Also works for enumerations defined in external libraries

But of course this solution has downsides, too:

* Looses declarative type-hint

* A bit slower


## EnumSet

An `EnumSet` is a specialized Set implementation for use with enumeration types.
All of the enumerators in an `EnumSet` must come from a single enumeration type that is specified, when the set is
created.

Enum sets are represented internally as bit vectors. The bit vector is either an integer type or a binary string type
depending on how many enumerators are defined in the enumeration type. This representation is extremely compact and
efficient. Bulk operations will run very quickly. Enumerators of an `EnumSet` are unique and ordered based on its
ordinal number by design.

It implements `IteratorAggregate` and `Countable` to be directly iterable with `foreach` and countable with `count()`.

The `EnumSet` has a mutable and an immutable interface.
Mutable methods start with `set`, `add` or `remove` while immutable methods start with `with`.

```php
use MabeEnum\EnumSet;

// create a new EnumSet and initialize with the given enumerators
$enumSet = new EnumSet('UserStatus', [UserStatus::ACTIVE()]);

// modify an EnumSet (mutable interface)

// add enumerators (by value or by instance)
$enumSet->addIterable([UserStatus::INACTIVE, UserStatus::DELETED()]);
// or
$enumSet->add(UserStatus::INACTIVE);
$enumSet->add(UserStatus::DELETED());

// remove enumerators (by value or by instance)
$enumSet->removeIterable([UserStatus::INACTIVE, UserStatus::DELETED()]);
// or
$enumSet->remove(UserStatus::INACTIVE);
$enumSet->remove(UserStatus::DELETED());


// The immutable interface will create a new EnumSet for each modification 

// add enumerators (by value or by instance)
$enumSet = $enumSet->withIterable([UserStatus::INACTIVE, UserStatus::DELETED()]);
// or
$enumSet = $enumSet->with(UserStatus::INACTIVE);
$enumSet = $enumSet->with(UserStatus::DELETED());

// remove enumerators (by value or by instance)
$enumSet->withoutIterable([UserStatus::INACTIVE, UserStatus::DELETED()]);
// or
$enumSet = $enumSet->without(UserStatus::INACTIVE);
$enumSet = $enumSet->without(UserStatus::DELETED());


// Test if an enumerator exists (by value or by instance)
$enumSet->has(UserStatus::INACTIVE); // bool


// count the number of enumerators
$enumSet->count();
count($enumSet);

// test for elements
$enumSet->isEmpty();

// convert to array
$enumSet->getValues();      // List of enumerator values
$enumSet->getEnumerators(); // List of enumerator instances
$enumSet->getNames();       // List of enumerator names
$enumSet->getOrdinals();    // List of ordinal numbers


// iterating over the set
foreach ($enumSet as $ordinal => $enum) {
    gettype($ordinal);  // int (the ordinal number of the enumerator)
    get_class($enum);   // UserStatus (enumerator object)
}


// compare two EnumSets
$enumSet->isEqual($other);    // Check if the EnumSet is the same as other
$enumSet->isSubset($other);   // Check if the EnumSet is a subset of other
$enumSet->isSuperset($other); // Check if the EnumSet is a superset of other


// union, intersect, difference and symmetric difference

// ... the mutable interface will modify the set
$enumSet->setUnion($other);     // Enumerators from both this and other (this | other)
$enumSet->setIntersect($other); // Enumerators common to both this and other (this & other)
$enumSet->setDiff($other);      // Enumerators in this but not in other (this - other)
$enumSet->setSymDiff($other);   // Enumerators in either this and other but not in both (this ^ other)

// ... the immutable interface will produce a new set
$enumSet = $enumSet->withUnion($other);     // Enumerators from both this and other (this | other)
$enumSet = $enumSet->withIntersect($other); // Enumerators common to both this and other (this & other)
$enumSet = $enumSet->withDiff($other);      // Enumerators in this but not in other (this - other)
$enumSet = $enumSet->withSymDiff($other);   // Enumerators in either this and other but not in both (this ^ other)
```


## EnumMap

An `EnumMap` maps enumerators of the same type to data assigned to.

It implements `ArrayAccess`, `Countable` and `IteratorAggregate`
so elements can be accessed, iterated and counted like a normal array
using `$enumMap[$key]`, `foreach` and `count()`.

```php
use MabeEnum\EnumMap;

// create a new EnumMap
$enumMap = new EnumMap('UserStatus');


// read and write key-value-pairs like an array
$enumMap[UserStatus::INACTIVE] = 'inaktiv';
$enumMap[UserStatus::ACTIVE]   = 'aktiv';
$enumMap[UserStatus::DELETED]  = 'gelöscht';
$enumMap[UserStatus::INACTIVE]; // 'inaktiv';
$enumMap[UserStatus::ACTIVE];   // 'aktiv';
$enumMap[UserStatus::DELETED];  // 'gelöscht';

isset($enumMap[UserStatus::DELETED]); // true
unset($enumMap[UserStatus::DELETED]);
isset($enumMap[UserStatus::DELETED]); // false

// ... no matter if you use enumerator values or enumerator objects
$enumMap[UserStatus::INACTIVE()] = 'inaktiv';
$enumMap[UserStatus::ACTIVE()]   = 'aktiv';
$enumMap[UserStatus::DELETED()]  = 'gelöscht';
$enumMap[UserStatus::INACTIVE()]; // 'inaktiv';
$enumMap[UserStatus::ACTIVE()];   // 'aktiv';
$enumMap[UserStatus::DELETED()];  // 'gelöscht';

isset($enumMap[UserStatus::DELETED()]); // true
unset($enumMap[UserStatus::DELETED()]);
isset($enumMap[UserStatus::DELETED()]); // false


// count number of attached elements
$enumMap->count();
count($enumMap);

// test for elements
$enumMap->isEmpty();

// support for null aware exists check
$enumMap[UserStatus::NULL] = null;
isset($enumMap[UserStatus::NULL]); // false
$enumMap->has(UserStatus::NULL);   // true


// iterating over the map
foreach ($enumMap as $enum => $value) {
    get_class($enum);  // UserStatus (enumerator object)
    gettype($value);   // mixed (the value the enumerators maps to)
}

// get a list of keys (= a list of enumerator objects)
$enumMap->getKeys();

// get a list of values (= a list of values the enumerator maps to)
$enumMap->getValues();
```


## Serializing

Because this enumeration implementation is based on a singleton pattern and in PHP
it's currently impossible to unserialize a singleton without creating a new instance
this feature isn't supported without any additional work.

As of it's an often requested feature there is a trait that can be added to your
enumeration definition. The trait adds serialization functionallity and injects
the unserialized enumeration instance in case it's the first one.
This reduces singleton behavior breakage but still it beaks if it's not the first
instance and you could result in two different instance of the same enumeration.

**Use it with caution!**

PS: `EnumSet` and `EnumMap` are serializable by default as long as you don't set other non-serializable values.


### Example of using EnumSerializableTrait

```php
use MabeEnum\Enum;
use MabeEnum\EnumSerializableTrait;
use Serializable;

class CardinalDirection extends Enum implements Serializable
{
    use EnumSerializableTrait;

    const NORTH = 'n';
    const EAST  = 'e';
    const WEST  = 'w';
    const SOUTH = 's';
}

$north1 = CardinalDirection::NORTH();
$north2 = unserialize(serialize($north1));

var_dump($north1 === $north2);  // returns FALSE as described above
var_dump($north1->is($north2)); // returns TRUE - this way the two instances are treated equal
var_dump($north2->is($north1)); // returns TRUE - equality works in both directions
```


# Generics and Static Code Analyzer

With version 4.3 we have added support for generics and added better type support.

* `EnumSet<T of Enum>`
* `EnumMap<T of Enum>`

Generic types will be detected by [PHPStan](https://phpstan.org/) and [Psalm](https://psalm.dev/).

Additionally, we have developed an [extension for PHPStan](https://github.com/marc-mabe/php-enum-phpstan/)
to make enumerator accessor methods known.


# Why not `SplEnum`

* `SplEnum` is not built-in into PHP and requires pecl extension installed.
* Instances of the same value of an `SplEnum` are not the same instance.
* No support for `EnumMap` or `EnumSet`.


# Changelog

Changes are documented in the [release page](https://github.com/marc-mabe/php-enum/releases).


# Install

## Composer

Add `marc-mabe/php-enum` to the project's composer.json dependencies and run
`php composer.phar install`

## GIT

`git clone git://github.com/marc-mabe/php-enum.git`

## ZIP / TAR

Download the last version from [Github](https://github.com/marc-mabe/php-enum/tags)
and extract it.


# Versioning and Releases

This project follows [SemVer](https://semver.org/) specification. 

There are **no** [LTS](https://en.wikipedia.org/wiki/Long-term_support) releases
and we don't have (fixed) time based release windows.
Instead releases happen as necessary.

We do support at least all maintained PHP versions.

Bug fixes will be backported to the latest maintained minor release.

Critical bug fixes and security relates fixes can also be backported to older releases.

| Release | Status      | PHP-Version     |
|---------|-------------|-----------------|
| 1.x     | EOL         | \>=5.3          |
| 2.x     | EOL         | \>=5.3 & HHVM<4 |
| 3.x     | EOL         | \>=5.6 & HHVM<4 |
| 4.x     | active      | \>=7.1          |


# New BSD License

The files in this archive are released under the New BSD License.
You can find a copy of this license in LICENSE.txt file.
