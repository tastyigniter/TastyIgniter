# msgpack.php

[![Quality Assurance](https://github.com/rybakit/msgpack.php/workflows/QA/badge.svg)](https://github.com/rybakit/msgpack.php/actions?query=workflow%3AQA)
[![Code Coverage](https://scrutinizer-ci.com/g/rybakit/msgpack.php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/rybakit/msgpack.php/?branch=master)
[![Mentioned in Awesome PHP](https://awesome.re/mentioned-badge.svg)](https://github.com/ziadoz/awesome-php#data-structure-and-storage)

A pure PHP implementation of the [MessagePack](https://msgpack.org/) serialization format.


## Features

 * Fully compliant with the latest [MessagePack specification](https://github.com/msgpack/msgpack/blob/master/spec.md)
 * Supports [streaming unpacking](#unpacking)
 * Supports [unsigned 64-bit integers handling](#unpacking-options)
 * Supports [object serialization](#custom-types)
 * [Fully tested](https://github.com/rybakit/msgpack.php/actions?query=workflow%3AQA)
 * [Relatively fast](#performance)


## Table of contents

 * [Installation](#installation)
 * [Usage](#usage)
   * [Packing](#packing)
     * [Packing options](#packing-options)
   * [Unpacking](#unpacking)
     * [Unpacking options](#unpacking-options)
 * [Custom types](#custom-types)
   * [Type objects](#type-objects)
   * [Type transformers](#type-transformers)
   * [Extensions](#extensions)
     * [Timestamp](#timestamp)
     * [Application-specific extensions](#application-specific-extensions)
 * [Exceptions](#exceptions)
 * [Tests](#tests)
    * [Fuzzing](#fuzzing)
    * [Performance](#performance)
 * [License](#license)


## Installation

The recommended way to install the library is through [Composer](http://getcomposer.org):

```sh
composer require rybakit/msgpack
```


## Usage

### Packing

To pack values, you can either use an instance of a `Packer`:

```php
$packer = new Packer();
$packed = $packer->pack($value);
```

or call a static method on the `MessagePack` class:

```php
$packed = MessagePack::pack($value);
```

In the examples above, the method `pack` automatically packs a value depending on its type. However, not all PHP types 
can be uniquely translated to MessagePack types. For example, the MessagePack format defines `map` and `array` types, 
which are represented by a single `array` type in PHP. By default, the packer will pack a PHP array as a MessagePack
array if it has sequential numeric keys starting from `0`, and as a MessagePack map otherwise:

```php
$mpArr1 = $packer->pack([1, 2]);               // MP array [1, 2]
$mpArr2 = $packer->pack([0 => 1, 1 => 2]);     // MP array [1, 2]
$mpMap1 = $packer->pack([0 => 1, 2 => 3]);     // MP map {0: 1, 2: 3}
$mpMap2 = $packer->pack([1 => 2, 2 => 3]);     // MP map {1: 2, 2: 3}
$mpMap3 = $packer->pack(['a' => 1, 'b' => 2]); // MP map {a: 1, b: 2}
```

However, sometimes you need to pack a sequential array as a MessagePack map.
To do this, use the `packMap` method:

```php
$mpMap = $packer->packMap([1, 2]); // {0: 1, 1: 2}
```

Here is a list of type-specific packing methods:

```php
$packer->packNil();           // MP nil
$packer->packBool(true);      // MP bool
$packer->packInt(42);         // MP int
$packer->packFloat(M_PI);     // MP float (32 or 64)
$packer->packFloat32(M_PI);   // MP float 32
$packer->packFloat64(M_PI);   // MP float 64
$packer->packStr('foo');      // MP str
$packer->packBin("\x80");     // MP bin
$packer->packArray([1, 2]);   // MP array
$packer->packMap(['a' => 1]); // MP map
$packer->packExt(1, "\xaa");  // MP ext
```

> *Check the ["Custom types"](#custom-types) section below on how to pack custom types.*


#### Packing options

The `Packer` object supports a number of bitmask-based options for fine-tuning 
the packing process (defaults are in bold):

| Name                 | Description                                                   |
| -------------------- | ------------------------------------------------------------- |
| **`FORCE_STR`**      | Forces PHP strings to be packed as MessagePack UTF-8 strings  |
| `FORCE_BIN`          | Forces PHP strings to be packed as MessagePack binary data    |
| `DETECT_STR_BIN`     | Detects MessagePack str/bin type automatically                |
|                      |                                                               |
| `FORCE_ARR`          | Forces PHP arrays to be packed as MessagePack arrays          |
| `FORCE_MAP`          | Forces PHP arrays to be packed as MessagePack maps            |
| **`DETECT_ARR_MAP`** | Detects MessagePack array/map type automatically              |
|                      |                                                               |
| `FORCE_FLOAT32`      | Forces PHP floats to be packed as 32-bits MessagePack floats  |
| **`FORCE_FLOAT64`**  | Forces PHP floats to be packed as 64-bits MessagePack floats  |

> *The type detection mode (`DETECT_STR_BIN`/`DETECT_ARR_MAP`) adds some overhead 
> which can be noticed when you pack large (16- and 32-bit) arrays or strings. 
> However, if you know the value type in advance (for example, you only work with 
> UTF-8 strings or/and associative arrays), you can eliminate this overhead by 
> forcing the packer to use the appropriate type, which will save it from running 
> the auto-detection routine. Another option is to explicitly specify the value 
> type. The library provides 2 auxiliary classes for this, `Map` and `Bin`. 
> Check the ["Custom types"](#custom-types) section below for details.*

Examples:

```php
// detect str/bin type and pack PHP 64-bit floats (doubles) to MP 32-bit floats
$packer = new Packer(PackOptions::DETECT_STR_BIN | PackOptions::FORCE_FLOAT32);

// these will throw MessagePack\Exception\InvalidOptionException
$packer = new Packer(PackOptions::FORCE_STR | PackOptions::FORCE_BIN);
$packer = new Packer(PackOptions::FORCE_FLOAT32 | PackOptions::FORCE_FLOAT64);
```


### Unpacking

To unpack data, you can either use an instance of a `BufferUnpacker`:

```php
$unpacker = new BufferUnpacker();

$unpacker->reset($packed);
$value = $unpacker->unpack();
```

or call a static method on the `MessagePack` class:

```php
$value = MessagePack::unpack($packed);
```

If the packed data is received in chunks (e.g. when reading from a stream), use the `tryUnpack` method, which attempts
to unpack the data and returns an array of unpacked messages (if any) instead of throwing an `InsufficientDataException`:

```php
while ($chunk = ...) {
    $unpacker->append($chunk);
    if ($messages = $unpacker->tryUnpack()) {
        return $messages;
    }
}
```

If you want to unpack from a specific position in a buffer, use `seek`:

```php
$unpacker->seek(42); // set position equal to 42 bytes
$unpacker->seek(-8); // set position to 8 bytes before the end of the buffer
```

To skip bytes from the current position, use `skip`:

```php
$unpacker->skip(10); // set position to 10 bytes ahead of the current position
```

To get the number of remaining (unread) bytes in the buffer:

```php
$unreadBytesCount = $unpacker->getRemainingCount();
```

To check whether the buffer has unread data:

```php
$hasUnreadBytes = $unpacker->hasRemaining();
```

If needed, you can remove already read data from the buffer by calling:

```php
$releasedBytesCount = $unpacker->release();
```

With the `read` method you can read raw (packed) data:

```php
$packedData = $unpacker->read(2); // read 2 bytes
```

Besides the above methods `BufferUnpacker` provides type-specific unpacking methods, namely:

```php
$unpacker->unpackNil();   // PHP null
$unpacker->unpackBool();  // PHP bool
$unpacker->unpackInt();   // PHP int
$unpacker->unpackFloat(); // PHP float
$unpacker->unpackStr();   // PHP UTF-8 string
$unpacker->unpackBin();   // PHP binary string
$unpacker->unpackArray(); // PHP sequential array
$unpacker->unpackMap();   // PHP associative array
$unpacker->unpackExt();   // PHP MessagePack\Type\Ext object
```


#### Unpacking options

The `BufferUnpacker` object supports a number of bitmask-based options for fine-tuning 
the unpacking process (defaults are in bold):

| Name                | Description                                                              |
| ------------------- | ------------------------------------------------------------------------ |
| **`BIGINT_AS_STR`** | Converts overflowed integers to strings <sup>[1]</sup>                   |
| `BIGINT_AS_GMP`     | Converts overflowed integers to `GMP` objects <sup>[2]</sup>             |
| `BIGINT_AS_DEC`     | Converts overflowed integers to `Decimal\Decimal` objects <sup>[3]</sup> |

> *1. The binary MessagePack format has unsigned 64-bit as its largest integer 
>     data type, but PHP does not support such integers, which means that 
>     an overflow can occur during unpacking.*
>
> *2. Make sure the [GMP](http://php.net/manual/en/book.gmp.php) extension 
>     is enabled.*
>
> *3. Make sure the [Decimal](http://php-decimal.io/) extension is enabled.*


Examples:

```php
$packedUint64 = "\xcf"."\xff\xff\xff\xff"."\xff\xff\xff\xff";

$unpacker = new BufferUnpacker($packedUint64);
var_dump($unpacker->unpack()); // string(20) "18446744073709551615"

$unpacker = new BufferUnpacker($packedUint64, UnpackOptions::BIGINT_AS_GMP);
var_dump($unpacker->unpack()); // object(GMP) {...}

$unpacker = new BufferUnpacker($packedUint64, UnpackOptions::BIGINT_AS_DEC);
var_dump($unpacker->unpack()); // object(Decimal\Decimal) {...}
```


### Custom types

In addition to the [basic types](https://github.com/msgpack/msgpack/blob/master/spec.md#type-system), the library 
provides functionality to serialize and deserialize arbitrary types. This can be done in several ways, depending 
on your use case. Let's take a look at them.

#### Type objects

If you need to *serialize* an instance of one of your classes into one of the basic MessagePack types, the best way 
to do this is to implement the [CanBePacked](src/CanBePacked.php) interface in the class. A good example of such 
a class is the `Map` type class that comes with the library. This type is useful when you want to explicitly specify 
that a given PHP array should be packed as a MessagePack map without triggering an automatic type detection routine:

```php
$packer = new Packer();

$packedMap = $packer->pack(new Map([1, 2, 3]));
$packedArray = $packer->pack([1, 2, 3]);
```

> *More type examples can be found in the [src/Type](src/Type) directory.*

#### Type transformers

As with type objects, type transformers are only responsible for *serializing* values. They should be 
used when you need to serialize a value that does not implement the [CanBePacked](src/CanBePacked.php) 
interface. Examples of such values include instances of built-in or third-party classes that you do not
own, or non-objects such as resources.

A transformer class must implement the [CanPack](src/CanPack.php) interface. To use a transformer, 
it must first be registered in the packer. Here is an example of how to serialize PHP streams into 
the MessagePack `bin` format type using one of the supplied transformers, `StreamTransformer`:

```php
$packer = new Packer(null, [new StreamTransformer()]);

$packedBin = $packer->pack(fopen('/path/to/file', 'r+'));
```

> *More type transformer examples can be found in the [src/TypeTransformer](src/TypeTransformer) directory.*

#### Extensions

In contrast to the cases described above, extensions are intended to handle
[extension types](https://github.com/msgpack/msgpack/blob/master/spec.md#extension-types)
and are responsible for both *serialization* and *deserialization* of values (types). 

An extension class must implement the [Extension](src/Extension.php) interface. To use an extension, 
it must first be registered in the packer and the unpacker.

The MessagePack specification divides extension types into two groups: *predefined* and *application-specific*. 
Currently, there is only one predefined type in the specification, Timestamp.

##### Timestamp

The Timestamp extension type is a [predefined](https://github.com/msgpack/msgpack/blob/master/spec.md#timestamp-extension-type) 
type. Support for this type in the library is done through the `TimestampExtension` class. This class is responsible 
for handling `Timestamp` objects, which represent the number of seconds and optional adjustment in nanoseconds:

```php
$timestampExtension = new TimestampExtension();

$packer = new Packer();
$packer = $packer->extendWith($timestampExtension);

$unpacker = new BufferUnpacker();
$unpacker = $unpacker->extendWith($timestampExtension);

$packedTimestamp = $packer->pack(Timestamp::now());
$timestamp = $unpacker->reset($packedTimestamp)->unpack();

$seconds = $timestamp->getSeconds();
$nanoseconds = $timestamp->getNanoseconds();
```

When using the `MessagePack` class, the Timestamp extension is already registered:

```php
$packedTimestamp = MessagePack::pack(Timestamp::now());
$timestamp = MessagePack::unpack($packedTimestamp);
```

##### Application-specific extensions

In addition, the format can be extended with your own types. For example, to make the built-in PHP `DateTime` objects 
first-class citizens in your code, you can create a corresponding extension, as shown in the [example](examples/MessagePack/DateTimeExtension.php).
Please note that custom extensions must be registered with a unique extension ID (an integer from `0` to `127`).

> *More extension examples can be found in the [examples/MessagePack](examples/MessagePack) directory.*

> *To learn more about how extension types can be useful, check out this 
> [article](https://dev.to/tarantool/advanced-messagepack-capabilities-4735).*


## Exceptions

If an error occurs during packing/unpacking, a `PackingFailedException` or an `UnpackingFailedException` 
will be thrown, respectively. In addition, an `InsufficientDataException` can be thrown during unpacking.

An `InvalidOptionException` will be thrown in case an invalid option (or a combination of mutually 
exclusive options) is used.


## Tests

Run tests as follows:

```sh
vendor/bin/phpunit
```

Also, if you already have Docker installed, you can run the tests in a Docker container. First, create a container:

```sh
./dockerfile.sh | docker build -t msgpack -
```

The command above will create a container named `msgpack` with PHP 8.4 runtime. You may change the default runtime 
by defining the `PHP_IMAGE` environment variable:

```sh
PHP_IMAGE='php:8.3-cli' ./dockerfile.sh | docker build -t msgpack -
```

> *See a list of various images [here](https://hub.docker.com/_/php).*

Then run the unit tests:

```sh
docker run --rm -v $PWD:/msgpack -w /msgpack msgpack
```


#### Fuzzing

To ensure that the unpacking works correctly with malformed/semi-malformed data, you can use a testing technique 
called [fuzzing](https://en.wikipedia.org/wiki/Fuzzing). The library ships with a helper file (target) 
for [PHP-Fuzzer](https://github.com/nikic/PHP-Fuzzer) and can be used as follows:

```sh
php-fuzzer fuzz tests/fuzz_buffer_unpacker.php
```


#### Performance

To check performance, run:

```sh
php -n -dzend_extension=opcache.so \
-dpcre.jit=1 -dopcache.enable=1 -dopcache.enable_cli=1 \
tests/bench.php
```

<details>
<summary><strong>Example output</strong></summary>

```
Filter: MessagePack\Tests\Perf\Filter\ListFilter
Rounds: 3
Iterations: 100000

=============================================
Test/Target            Packer  BufferUnpacker
---------------------------------------------
nil .................. 0.0030 ........ 0.0139
false ................ 0.0037 ........ 0.0144
true ................. 0.0040 ........ 0.0137
7-bit uint #1 ........ 0.0052 ........ 0.0120
7-bit uint #2 ........ 0.0059 ........ 0.0114
7-bit uint #3 ........ 0.0061 ........ 0.0119
5-bit sint #1 ........ 0.0067 ........ 0.0126
5-bit sint #2 ........ 0.0064 ........ 0.0132
5-bit sint #3 ........ 0.0066 ........ 0.0135
8-bit uint #1 ........ 0.0078 ........ 0.0200
8-bit uint #2 ........ 0.0077 ........ 0.0212
8-bit uint #3 ........ 0.0086 ........ 0.0203
16-bit uint #1 ....... 0.0111 ........ 0.0271
16-bit uint #2 ....... 0.0115 ........ 0.0260
16-bit uint #3 ....... 0.0103 ........ 0.0273
32-bit uint #1 ....... 0.0116 ........ 0.0326
32-bit uint #2 ....... 0.0118 ........ 0.0332
32-bit uint #3 ....... 0.0127 ........ 0.0325
64-bit uint #1 ....... 0.0140 ........ 0.0277
64-bit uint #2 ....... 0.0134 ........ 0.0294
64-bit uint #3 ....... 0.0134 ........ 0.0281
8-bit int #1 ......... 0.0086 ........ 0.0241
8-bit int #2 ......... 0.0089 ........ 0.0225
8-bit int #3 ......... 0.0085 ........ 0.0229
16-bit int #1 ........ 0.0118 ........ 0.0280
16-bit int #2 ........ 0.0121 ........ 0.0270
16-bit int #3 ........ 0.0109 ........ 0.0274
32-bit int #1 ........ 0.0128 ........ 0.0346
32-bit int #2 ........ 0.0118 ........ 0.0339
32-bit int #3 ........ 0.0135 ........ 0.0368
64-bit int #1 ........ 0.0138 ........ 0.0276
64-bit int #2 ........ 0.0132 ........ 0.0286
64-bit int #3 ........ 0.0137 ........ 0.0274
64-bit int #4 ........ 0.0180 ........ 0.0285
64-bit float #1 ...... 0.0134 ........ 0.0284
64-bit float #2 ...... 0.0125 ........ 0.0275
64-bit float #3 ...... 0.0126 ........ 0.0283
fix string #1 ........ 0.0035 ........ 0.0133
fix string #2 ........ 0.0094 ........ 0.0216
fix string #3 ........ 0.0094 ........ 0.0222
fix string #4 ........ 0.0091 ........ 0.0241
8-bit string #1 ...... 0.0122 ........ 0.0301
8-bit string #2 ...... 0.0118 ........ 0.0304
8-bit string #3 ...... 0.0119 ........ 0.0315
16-bit string #1 ..... 0.0150 ........ 0.0388
16-bit string #2 ..... 0.1545 ........ 0.1665
32-bit string ........ 0.1570 ........ 0.1756
wide char string #1 .. 0.0091 ........ 0.0236
wide char string #2 .. 0.0122 ........ 0.0313
8-bit binary #1 ...... 0.0100 ........ 0.0302
8-bit binary #2 ...... 0.0123 ........ 0.0324
8-bit binary #3 ...... 0.0126 ........ 0.0327
16-bit binary ........ 0.0168 ........ 0.0372
32-bit binary ........ 0.1588 ........ 0.1754
fix array #1 ......... 0.0042 ........ 0.0131
fix array #2 ......... 0.0294 ........ 0.0367
fix array #3 ......... 0.0412 ........ 0.0472
16-bit array #1 ...... 0.1378 ........ 0.1596
16-bit array #2 ........... S ............. S
32-bit array .............. S ............. S
complex array ........ 0.1865 ........ 0.2283
fix map #1 ........... 0.0725 ........ 0.1048
fix map #2 ........... 0.0319 ........ 0.0405
fix map #3 ........... 0.0356 ........ 0.0665
fix map #4 ........... 0.0465 ........ 0.0497
16-bit map #1 ........ 0.2540 ........ 0.3028
16-bit map #2 ............. S ............. S
32-bit map ................ S ............. S
complex map .......... 0.2372 ........ 0.2710
fixext 1 ............. 0.0283 ........ 0.0358
fixext 2 ............. 0.0291 ........ 0.0371
fixext 4 ............. 0.0302 ........ 0.0355
fixext 8 ............. 0.0288 ........ 0.0384
fixext 16 ............ 0.0293 ........ 0.0359
8-bit ext ............ 0.0302 ........ 0.0439
16-bit ext ........... 0.0334 ........ 0.0499
32-bit ext ........... 0.1845 ........ 0.1888
32-bit timestamp #1 .. 0.0337 ........ 0.0547
32-bit timestamp #2 .. 0.0335 ........ 0.0560
64-bit timestamp #1 .. 0.0371 ........ 0.0575
64-bit timestamp #2 .. 0.0374 ........ 0.0542
64-bit timestamp #3 .. 0.0356 ........ 0.0533
96-bit timestamp #1 .. 0.0362 ........ 0.0699
96-bit timestamp #2 .. 0.0381 ........ 0.0701
96-bit timestamp #3 .. 0.0367 ........ 0.0687
=============================================
Total                  2.7618          4.0820
Skipped                     4               4
Failed                      0               0
Ignored                     0               0
```
</details>

*With JIT:*

```sh
php -n -dzend_extension=opcache.so \
-dpcre.jit=1 -dopcache.jit_buffer_size=64M -dopcache.jit=tracing -dopcache.enable=1 -dopcache.enable_cli=1 \
tests/bench.php
```

<details>
<summary><strong>Example output</strong></summary>

```
Filter: MessagePack\Tests\Perf\Filter\ListFilter
Rounds: 3
Iterations: 100000

=============================================
Test/Target            Packer  BufferUnpacker
---------------------------------------------
nil .................. 0.0005 ........ 0.0054
false ................ 0.0004 ........ 0.0059
true ................. 0.0004 ........ 0.0059
7-bit uint #1 ........ 0.0010 ........ 0.0047
7-bit uint #2 ........ 0.0010 ........ 0.0046
7-bit uint #3 ........ 0.0010 ........ 0.0046
5-bit sint #1 ........ 0.0025 ........ 0.0046
5-bit sint #2 ........ 0.0023 ........ 0.0046
5-bit sint #3 ........ 0.0024 ........ 0.0045
8-bit uint #1 ........ 0.0043 ........ 0.0081
8-bit uint #2 ........ 0.0043 ........ 0.0079
8-bit uint #3 ........ 0.0041 ........ 0.0080
16-bit uint #1 ....... 0.0064 ........ 0.0095
16-bit uint #2 ....... 0.0064 ........ 0.0091
16-bit uint #3 ....... 0.0064 ........ 0.0094
32-bit uint #1 ....... 0.0085 ........ 0.0114
32-bit uint #2 ....... 0.0077 ........ 0.0122
32-bit uint #3 ....... 0.0077 ........ 0.0120
64-bit uint #1 ....... 0.0085 ........ 0.0159
64-bit uint #2 ....... 0.0086 ........ 0.0157
64-bit uint #3 ....... 0.0086 ........ 0.0158
8-bit int #1 ......... 0.0042 ........ 0.0080
8-bit int #2 ......... 0.0042 ........ 0.0080
8-bit int #3 ......... 0.0042 ........ 0.0081
16-bit int #1 ........ 0.0065 ........ 0.0095
16-bit int #2 ........ 0.0065 ........ 0.0090
16-bit int #3 ........ 0.0056 ........ 0.0085
32-bit int #1 ........ 0.0067 ........ 0.0107
32-bit int #2 ........ 0.0066 ........ 0.0106
32-bit int #3 ........ 0.0063 ........ 0.0104
64-bit int #1 ........ 0.0072 ........ 0.0162
64-bit int #2 ........ 0.0073 ........ 0.0174
64-bit int #3 ........ 0.0072 ........ 0.0164
64-bit int #4 ........ 0.0077 ........ 0.0161
64-bit float #1 ...... 0.0053 ........ 0.0135
64-bit float #2 ...... 0.0053 ........ 0.0135
64-bit float #3 ...... 0.0052 ........ 0.0135
fix string #1 ....... -0.0002 ........ 0.0044
fix string #2 ........ 0.0035 ........ 0.0067
fix string #3 ........ 0.0035 ........ 0.0077
fix string #4 ........ 0.0033 ........ 0.0078
8-bit string #1 ...... 0.0059 ........ 0.0110
8-bit string #2 ...... 0.0063 ........ 0.0121
8-bit string #3 ...... 0.0064 ........ 0.0124
16-bit string #1 ..... 0.0099 ........ 0.0146
16-bit string #2 ..... 0.1522 ........ 0.1474
32-bit string ........ 0.1511 ........ 0.1483
wide char string #1 .. 0.0039 ........ 0.0084
wide char string #2 .. 0.0073 ........ 0.0123
8-bit binary #1 ...... 0.0040 ........ 0.0112
8-bit binary #2 ...... 0.0075 ........ 0.0123
8-bit binary #3 ...... 0.0077 ........ 0.0129
16-bit binary ........ 0.0096 ........ 0.0145
32-bit binary ........ 0.1535 ........ 0.1479
fix array #1 ......... 0.0008 ........ 0.0061
fix array #2 ......... 0.0121 ........ 0.0165
fix array #3 ......... 0.0193 ........ 0.0222
16-bit array #1 ...... 0.0607 ........ 0.0479
16-bit array #2 ........... S ............. S
32-bit array .............. S ............. S
complex array ........ 0.0749 ........ 0.0824
fix map #1 ........... 0.0329 ........ 0.0431
fix map #2 ........... 0.0161 ........ 0.0189
fix map #3 ........... 0.0205 ........ 0.0262
fix map #4 ........... 0.0252 ........ 0.0205
16-bit map #1 ........ 0.1016 ........ 0.0927
16-bit map #2 ............. S ............. S
32-bit map ................ S ............. S
complex map .......... 0.1096 ........ 0.1030
fixext 1 ............. 0.0157 ........ 0.0161
fixext 2 ............. 0.0175 ........ 0.0183
fixext 4 ............. 0.0156 ........ 0.0185
fixext 8 ............. 0.0163 ........ 0.0184
fixext 16 ............ 0.0164 ........ 0.0182
8-bit ext ............ 0.0158 ........ 0.0207
16-bit ext ........... 0.0203 ........ 0.0219
32-bit ext ........... 0.1614 ........ 0.1539
32-bit timestamp #1 .. 0.0195 ........ 0.0249
32-bit timestamp #2 .. 0.0188 ........ 0.0260
64-bit timestamp #1 .. 0.0207 ........ 0.0281
64-bit timestamp #2 .. 0.0212 ........ 0.0291
64-bit timestamp #3 .. 0.0207 ........ 0.0295
96-bit timestamp #1 .. 0.0222 ........ 0.0358
96-bit timestamp #2 .. 0.0228 ........ 0.0353
96-bit timestamp #3 .. 0.0210 ........ 0.0319
=============================================
Total                  1.6432          1.9674
Skipped                     4               4
Failed                      0               0
Ignored                     0               0
```
</details>

You may change default benchmark settings by defining the following environment 
variables:

| Name                | Default                                                                     |
|---------------------|-----------------------------------------------------------------------------|
| MP_BENCH_TARGETS    | `pure_p,pure_u`, *see the [list](tests/bench.php#L83) of available targets* |
| MP_BENCH_ITERATIONS | `100_000`                                                                   |
| MP_BENCH_DURATION   | *not set*                                                                   |
| MP_BENCH_ROUNDS     | `3`                                                                         |
| MP_BENCH_TESTS      | `-@slow`, *see the [list](tests/DataProvider.php) of available tests*       |

For example:

```sh
export MP_BENCH_TARGETS=pure_p
export MP_BENCH_ITERATIONS=1000000
export MP_BENCH_ROUNDS=5
# a comma separated list of test names
export MP_BENCH_TESTS='complex array, complex map'
# or a group name
# export MP_BENCH_TESTS='-@slow' // @pecl_comp
# or a regexp
# export MP_BENCH_TESTS='/complex (array|map)/'
```

Another example, benchmarking both the library and the [PECL extension](https://pecl.php.net/package/msgpack):

```sh
MP_BENCH_TARGETS=pure_p,pure_u,pecl_p,pecl_u \
php -n -dextension=msgpack.so -dzend_extension=opcache.so \
-dpcre.jit=1 -dopcache.enable=1 -dopcache.enable_cli=1 \
tests/bench.php
```

<details>
<summary><strong>Example output</strong></summary>

```
Filter: MessagePack\Tests\Perf\Filter\ListFilter
Rounds: 3
Iterations: 100000

===========================================================================
Test/Target            Packer  BufferUnpacker  msgpack_pack  msgpack_unpack
---------------------------------------------------------------------------
nil .................. 0.0031 ........ 0.0141 ...... 0.0055 ........ 0.0064
false ................ 0.0039 ........ 0.0154 ...... 0.0056 ........ 0.0053
true ................. 0.0038 ........ 0.0139 ...... 0.0056 ........ 0.0044
7-bit uint #1 ........ 0.0061 ........ 0.0110 ...... 0.0059 ........ 0.0046
7-bit uint #2 ........ 0.0065 ........ 0.0119 ...... 0.0042 ........ 0.0029
7-bit uint #3 ........ 0.0054 ........ 0.0117 ...... 0.0045 ........ 0.0025
5-bit sint #1 ........ 0.0047 ........ 0.0103 ...... 0.0038 ........ 0.0022
5-bit sint #2 ........ 0.0048 ........ 0.0117 ...... 0.0038 ........ 0.0022
5-bit sint #3 ........ 0.0046 ........ 0.0102 ...... 0.0038 ........ 0.0023
8-bit uint #1 ........ 0.0063 ........ 0.0174 ...... 0.0039 ........ 0.0031
8-bit uint #2 ........ 0.0063 ........ 0.0167 ...... 0.0040 ........ 0.0029
8-bit uint #3 ........ 0.0063 ........ 0.0168 ...... 0.0039 ........ 0.0030
16-bit uint #1 ....... 0.0092 ........ 0.0222 ...... 0.0049 ........ 0.0030
16-bit uint #2 ....... 0.0096 ........ 0.0227 ...... 0.0042 ........ 0.0046
16-bit uint #3 ....... 0.0123 ........ 0.0274 ...... 0.0059 ........ 0.0051
32-bit uint #1 ....... 0.0136 ........ 0.0331 ...... 0.0060 ........ 0.0048
32-bit uint #2 ....... 0.0130 ........ 0.0336 ...... 0.0070 ........ 0.0048
32-bit uint #3 ....... 0.0127 ........ 0.0329 ...... 0.0051 ........ 0.0048
64-bit uint #1 ....... 0.0126 ........ 0.0268 ...... 0.0055 ........ 0.0049
64-bit uint #2 ....... 0.0135 ........ 0.0281 ...... 0.0052 ........ 0.0046
64-bit uint #3 ....... 0.0131 ........ 0.0274 ...... 0.0069 ........ 0.0044
8-bit int #1 ......... 0.0077 ........ 0.0236 ...... 0.0058 ........ 0.0044
8-bit int #2 ......... 0.0087 ........ 0.0244 ...... 0.0058 ........ 0.0048
8-bit int #3 ......... 0.0084 ........ 0.0241 ...... 0.0055 ........ 0.0049
16-bit int #1 ........ 0.0112 ........ 0.0271 ...... 0.0048 ........ 0.0045
16-bit int #2 ........ 0.0124 ........ 0.0292 ...... 0.0057 ........ 0.0049
16-bit int #3 ........ 0.0118 ........ 0.0270 ...... 0.0058 ........ 0.0050
32-bit int #1 ........ 0.0137 ........ 0.0366 ...... 0.0058 ........ 0.0051
32-bit int #2 ........ 0.0133 ........ 0.0366 ...... 0.0056 ........ 0.0049
32-bit int #3 ........ 0.0129 ........ 0.0350 ...... 0.0052 ........ 0.0048
64-bit int #1 ........ 0.0145 ........ 0.0254 ...... 0.0034 ........ 0.0025
64-bit int #2 ........ 0.0097 ........ 0.0214 ...... 0.0034 ........ 0.0025
64-bit int #3 ........ 0.0096 ........ 0.0287 ...... 0.0059 ........ 0.0050
64-bit int #4 ........ 0.0143 ........ 0.0277 ...... 0.0059 ........ 0.0046
64-bit float #1 ...... 0.0134 ........ 0.0281 ...... 0.0057 ........ 0.0052
64-bit float #2 ...... 0.0141 ........ 0.0281 ...... 0.0057 ........ 0.0050
64-bit float #3 ...... 0.0144 ........ 0.0282 ...... 0.0057 ........ 0.0050
fix string #1 ........ 0.0036 ........ 0.0143 ...... 0.0066 ........ 0.0053
fix string #2 ........ 0.0107 ........ 0.0222 ...... 0.0065 ........ 0.0068
fix string #3 ........ 0.0116 ........ 0.0245 ...... 0.0063 ........ 0.0069
fix string #4 ........ 0.0105 ........ 0.0253 ...... 0.0083 ........ 0.0077
8-bit string #1 ...... 0.0126 ........ 0.0318 ...... 0.0075 ........ 0.0088
8-bit string #2 ...... 0.0121 ........ 0.0295 ...... 0.0076 ........ 0.0086
8-bit string #3 ...... 0.0125 ........ 0.0293 ...... 0.0130 ........ 0.0093
16-bit string #1 ..... 0.0159 ........ 0.0368 ...... 0.0117 ........ 0.0086
16-bit string #2 ..... 0.1547 ........ 0.1686 ...... 0.1516 ........ 0.1373
32-bit string ........ 0.1558 ........ 0.1729 ...... 0.1511 ........ 0.1396
wide char string #1 .. 0.0098 ........ 0.0237 ...... 0.0066 ........ 0.0065
wide char string #2 .. 0.0128 ........ 0.0291 ...... 0.0061 ........ 0.0082
8-bit binary #1 ........... I ............. I ........... F ............. I
8-bit binary #2 ........... I ............. I ........... F ............. I
8-bit binary #3 ........... I ............. I ........... F ............. I
16-bit binary ............. I ............. I ........... F ............. I
32-bit binary ............. I ............. I ........... F ............. I
fix array #1 ......... 0.0040 ........ 0.0129 ...... 0.0120 ........ 0.0058
fix array #2 ......... 0.0279 ........ 0.0390 ...... 0.0143 ........ 0.0165
fix array #3 ......... 0.0415 ........ 0.0463 ...... 0.0162 ........ 0.0187
16-bit array #1 ...... 0.1349 ........ 0.1628 ...... 0.0334 ........ 0.0341
16-bit array #2 ........... S ............. S ........... S ............. S
32-bit array .............. S ............. S ........... S ............. S
complex array ............. I ............. I ........... F ............. F
fix map #1 ................ I ............. I ........... F ............. I
fix map #2 ........... 0.0345 ........ 0.0391 ...... 0.0143 ........ 0.0168
fix map #3 ................ I ............. I ........... F ............. I
fix map #4 ........... 0.0459 ........ 0.0473 ...... 0.0151 ........ 0.0163
16-bit map #1 ........ 0.2518 ........ 0.2962 ...... 0.0400 ........ 0.0490
16-bit map #2 ............. S ............. S ........... S ............. S
32-bit map ................ S ............. S ........... S ............. S
complex map .......... 0.2380 ........ 0.2682 ...... 0.0545 ........ 0.0579
fixext 1 .................. I ............. I ........... F ............. F
fixext 2 .................. I ............. I ........... F ............. F
fixext 4 .................. I ............. I ........... F ............. F
fixext 8 .................. I ............. I ........... F ............. F
fixext 16 ................. I ............. I ........... F ............. F
8-bit ext ................. I ............. I ........... F ............. F
16-bit ext ................ I ............. I ........... F ............. F
32-bit ext ................ I ............. I ........... F ............. F
32-bit timestamp #1 ....... I ............. I ........... F ............. F
32-bit timestamp #2 ....... I ............. I ........... F ............. F
64-bit timestamp #1 ....... I ............. I ........... F ............. F
64-bit timestamp #2 ....... I ............. I ........... F ............. F
64-bit timestamp #3 ....... I ............. I ........... F ............. F
96-bit timestamp #1 ....... I ............. I ........... F ............. F
96-bit timestamp #2 ....... I ............. I ........... F ............. F
96-bit timestamp #3 ....... I ............. I ........... F ............. F
===========================================================================
Total                  1.5625          2.3866        0.7735          0.7243
Skipped                     4               4             4               4
Failed                      0               0            24              17
Ignored                    24              24             0               7
```
</details>


*With JIT:*

```sh
MP_BENCH_TARGETS=pure_p,pure_u,pecl_p,pecl_u \
php -n -dextension=msgpack.so -dzend_extension=opcache.so \
-dpcre.jit=1 -dopcache.jit_buffer_size=64M -dopcache.jit=tracing -dopcache.enable=1 -dopcache.enable_cli=1 \
tests/bench.php
```

<details>
<summary><strong>Example output</strong></summary>

```
Filter: MessagePack\Tests\Perf\Filter\ListFilter
Rounds: 3
Iterations: 100000

===========================================================================
Test/Target            Packer  BufferUnpacker  msgpack_pack  msgpack_unpack
---------------------------------------------------------------------------
nil .................. 0.0001 ........ 0.0052 ...... 0.0053 ........ 0.0042
false ................ 0.0007 ........ 0.0060 ...... 0.0057 ........ 0.0043
true ................. 0.0008 ........ 0.0060 ...... 0.0056 ........ 0.0041
7-bit uint #1 ........ 0.0031 ........ 0.0046 ...... 0.0062 ........ 0.0041
7-bit uint #2 ........ 0.0021 ........ 0.0043 ...... 0.0062 ........ 0.0041
7-bit uint #3 ........ 0.0022 ........ 0.0044 ...... 0.0061 ........ 0.0040
5-bit sint #1 ........ 0.0030 ........ 0.0048 ...... 0.0062 ........ 0.0040
5-bit sint #2 ........ 0.0032 ........ 0.0046 ...... 0.0062 ........ 0.0040
5-bit sint #3 ........ 0.0031 ........ 0.0046 ...... 0.0062 ........ 0.0040
8-bit uint #1 ........ 0.0054 ........ 0.0079 ...... 0.0062 ........ 0.0050
8-bit uint #2 ........ 0.0051 ........ 0.0079 ...... 0.0064 ........ 0.0044
8-bit uint #3 ........ 0.0051 ........ 0.0082 ...... 0.0062 ........ 0.0044
16-bit uint #1 ....... 0.0077 ........ 0.0094 ...... 0.0065 ........ 0.0045
16-bit uint #2 ....... 0.0077 ........ 0.0094 ...... 0.0063 ........ 0.0045
16-bit uint #3 ....... 0.0077 ........ 0.0095 ...... 0.0064 ........ 0.0047
32-bit uint #1 ....... 0.0088 ........ 0.0119 ...... 0.0063 ........ 0.0043
32-bit uint #2 ....... 0.0089 ........ 0.0117 ...... 0.0062 ........ 0.0039
32-bit uint #3 ....... 0.0089 ........ 0.0118 ...... 0.0063 ........ 0.0044
64-bit uint #1 ....... 0.0097 ........ 0.0155 ...... 0.0063 ........ 0.0045
64-bit uint #2 ....... 0.0095 ........ 0.0153 ...... 0.0061 ........ 0.0045
64-bit uint #3 ....... 0.0096 ........ 0.0156 ...... 0.0063 ........ 0.0047
8-bit int #1 ......... 0.0053 ........ 0.0083 ...... 0.0062 ........ 0.0044
8-bit int #2 ......... 0.0052 ........ 0.0080 ...... 0.0062 ........ 0.0044
8-bit int #3 ......... 0.0052 ........ 0.0080 ...... 0.0062 ........ 0.0043
16-bit int #1 ........ 0.0089 ........ 0.0097 ...... 0.0069 ........ 0.0046
16-bit int #2 ........ 0.0075 ........ 0.0093 ...... 0.0063 ........ 0.0043
16-bit int #3 ........ 0.0075 ........ 0.0094 ...... 0.0062 ........ 0.0046
32-bit int #1 ........ 0.0086 ........ 0.0122 ...... 0.0063 ........ 0.0044
32-bit int #2 ........ 0.0087 ........ 0.0120 ...... 0.0066 ........ 0.0046
32-bit int #3 ........ 0.0086 ........ 0.0121 ...... 0.0060 ........ 0.0044
64-bit int #1 ........ 0.0096 ........ 0.0149 ...... 0.0060 ........ 0.0045
64-bit int #2 ........ 0.0096 ........ 0.0157 ...... 0.0062 ........ 0.0044
64-bit int #3 ........ 0.0096 ........ 0.0160 ...... 0.0063 ........ 0.0046
64-bit int #4 ........ 0.0097 ........ 0.0157 ...... 0.0061 ........ 0.0044
64-bit float #1 ...... 0.0079 ........ 0.0153 ...... 0.0056 ........ 0.0044
64-bit float #2 ...... 0.0079 ........ 0.0152 ...... 0.0057 ........ 0.0045
64-bit float #3 ...... 0.0079 ........ 0.0155 ...... 0.0057 ........ 0.0044
fix string #1 ........ 0.0010 ........ 0.0045 ...... 0.0071 ........ 0.0044
fix string #2 ........ 0.0048 ........ 0.0075 ...... 0.0070 ........ 0.0060
fix string #3 ........ 0.0048 ........ 0.0086 ...... 0.0068 ........ 0.0060
fix string #4 ........ 0.0050 ........ 0.0088 ...... 0.0070 ........ 0.0059
8-bit string #1 ...... 0.0081 ........ 0.0129 ...... 0.0069 ........ 0.0062
8-bit string #2 ...... 0.0086 ........ 0.0128 ...... 0.0069 ........ 0.0065
8-bit string #3 ...... 0.0086 ........ 0.0126 ...... 0.0115 ........ 0.0065
16-bit string #1 ..... 0.0105 ........ 0.0137 ...... 0.0128 ........ 0.0068
16-bit string #2 ..... 0.1510 ........ 0.1486 ...... 0.1526 ........ 0.1391
32-bit string ........ 0.1517 ........ 0.1475 ...... 0.1504 ........ 0.1370
wide char string #1 .. 0.0044 ........ 0.0085 ...... 0.0067 ........ 0.0057
wide char string #2 .. 0.0081 ........ 0.0125 ...... 0.0069 ........ 0.0063
8-bit binary #1 ........... I ............. I ........... F ............. I
8-bit binary #2 ........... I ............. I ........... F ............. I
8-bit binary #3 ........... I ............. I ........... F ............. I
16-bit binary ............. I ............. I ........... F ............. I
32-bit binary ............. I ............. I ........... F ............. I
fix array #1 ......... 0.0014 ........ 0.0059 ...... 0.0132 ........ 0.0055
fix array #2 ......... 0.0146 ........ 0.0156 ...... 0.0155 ........ 0.0148
fix array #3 ......... 0.0211 ........ 0.0229 ...... 0.0179 ........ 0.0180
16-bit array #1 ...... 0.0673 ........ 0.0498 ...... 0.0343 ........ 0.0388
16-bit array #2 ........... S ............. S ........... S ............. S
32-bit array .............. S ............. S ........... S ............. S
complex array ............. I ............. I ........... F ............. F
fix map #1 ................ I ............. I ........... F ............. I
fix map #2 ........... 0.0148 ........ 0.0180 ...... 0.0156 ........ 0.0179
fix map #3 ................ I ............. I ........... F ............. I
fix map #4 ........... 0.0252 ........ 0.0201 ...... 0.0214 ........ 0.0167
16-bit map #1 ........ 0.1027 ........ 0.0836 ...... 0.0388 ........ 0.0510
16-bit map #2 ............. S ............. S ........... S ............. S
32-bit map ................ S ............. S ........... S ............. S
complex map .......... 0.1104 ........ 0.1010 ...... 0.0556 ........ 0.0602
fixext 1 .................. I ............. I ........... F ............. F
fixext 2 .................. I ............. I ........... F ............. F
fixext 4 .................. I ............. I ........... F ............. F
fixext 8 .................. I ............. I ........... F ............. F
fixext 16 ................. I ............. I ........... F ............. F
8-bit ext ................. I ............. I ........... F ............. F
16-bit ext ................ I ............. I ........... F ............. F
32-bit ext ................ I ............. I ........... F ............. F
32-bit timestamp #1 ....... I ............. I ........... F ............. F
32-bit timestamp #2 ....... I ............. I ........... F ............. F
64-bit timestamp #1 ....... I ............. I ........... F ............. F
64-bit timestamp #2 ....... I ............. I ........... F ............. F
64-bit timestamp #3 ....... I ............. I ........... F ............. F
96-bit timestamp #1 ....... I ............. I ........... F ............. F
96-bit timestamp #2 ....... I ............. I ........... F ............. F
96-bit timestamp #3 ....... I ............. I ........... F ............. F
===========================================================================
Total                  0.9642          1.0909        0.8224          0.7213
Skipped                     4               4             4               4
Failed                      0               0            24              17
Ignored                    24              24             0               7
```
</details>

> *Note that the msgpack extension (v2.1.2) doesn't support **ext**, **bin** and UTF-8 **str** types.*


## License

The library is released under the MIT License. See the bundled [LICENSE](LICENSE) file for details.
