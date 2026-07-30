# clue/redis-protocol

[![CI status](https://github.com/clue/redis-protocol/actions/workflows/ci.yml/badge.svg)](https://github.com/clue/redis-protocol/actions)
[![code coverage](https://img.shields.io/badge/code%20coverage-100%25-success)](#tests)
[![installs on Packagist](https://img.shields.io/packagist/dt/clue/redis-protocol?color=blue&label=installs%20on%20Packagist)](https://packagist.org/packages/clue/redis-protocol)

A streaming Redis protocol (RESP) parser and serializer written in pure PHP.

This parser and serializer implementation allows you to parse Redis protocol
messages into native PHP values and vice-versa. This is usually needed by a
Redis client implementation which also handles the connection socket.

To re-iterate: This is *not* a Redis client implementation. This is a protocol
implementation that is usually used by a Redis client implementation. If you're
looking for an easy way to build your own client implementation, then this is
for you. If you merely want to connect to a Redis server and issue some
commands, you're probably better off using one of the existing client
implementations.

**Table of contents**

* [Support us](#support-us)
* [Quickstart example](#quickstart-example)
* [Usage](#usage)
  * [Factory](#factory)
  * [Parser](#parser)
  * [Model](#model)
  * [Serializer](#serializer)
* [Install](#install)
* [Tests](#tests)
* [License](#license)

## Support us

We invest a lot of time developing, maintaining and updating our awesome
open-source projects. You can help us sustain this high-quality of our work by
[becoming a sponsor on GitHub](https://github.com/sponsors/clue). Sponsors get
numerous benefits in return, see our [sponsoring page](https://github.com/sponsors/clue)
for details.

Let's take these projects to the next level together! 🚀

## Quickstart example

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$factory = new Clue\Redis\Protocol\Factory();
$parser = $factory->createResponseParser();
$serializer = $factory->createSerializer();

$fp = fsockopen('tcp://localhost', 6379);
fwrite($fp, $serializer->getRequestMessage('SET', array('name', 'value')));
fwrite($fp, $serializer->getRequestMessage('GET', array('name')));

// the commands are pipelined, so this may parse multiple responses
$models = $parser->pushIncoming(fread($fp, 4096));

$reply1 = array_shift($models);
$reply2 = array_shift($models);

var_dump($reply1->getValueNative()); // string(2) "OK"
var_dump($reply2->getValueNative()); // string(5) "value"
```

See also the [examples](examples/).

## Usage

### Factory

The factory helps with instantiating the *right* parser and serializer.
Eventually the *best* available implementation will be chosen depending on your
installed extensions. You're also free to instantiate them directly, but this
will lock you down on a given implementation (which could be okay depending on
your use-case).

### Parser

The library includes a streaming Redis protocol parser. As such, it can safely
parse Redis protocol messages and work with an incomplete data stream. For this,
each included parser implements a single method
`ParserInterface::pushIncoming($chunk)`.

* The `ResponseParser` is what most Redis client implementation would want to
  use in order to parse incoming response messages from a Redis server instance.
* The `RequestParser` can be used to test messages coming from a Redis client or
  even to implement a Redis server.
* The `MessageBuffer` decorates either of the available parsers and merely
  offers some helper methods in order to work with single messages:
  * `hasIncomingModel()` to check if there's a complete message in the pipeline
  * `popIncomingModel()` to extract a complete message from the incoming queue.

### Model

Each message (response as well as request) is represented by a model
implementing the `ModelInterface` that has two methods:

* `getValueNative()` returns the wrapped value.
* `getMessageSerialized($serializer)` returns the serialized protocol messages
  that will be sent over the wire.

These models are very lightweight and add little overhead. They help keeping the
code organized and also provide a means to distinguish a single line
`StatusReply` from a binary-safe `BulkReply`.
  
The parser always returns models. Models can also be instantiated directly:

```php
$model = new Model\IntegerReply(123);
var_dump($model->getValueNative()); // int(123)
var_dump($model->getMessageSerialized($serializer)); // string(6) ":123\r\n"
```

### Serializer

The serializer is responsible for creating serialized messages and the
corresponing message models to be sent across the wire.

```php
$message = $serializer->getRequestMessage('ping');
var_dump($message); // string(14) "$1\r\n*4\r\nping\r\n"

$message = $serializer->getRequestMessage('set', array('key', 'value'));
var_dump($message); // string(33) "$3\r\n*3\r\nset\r\n*3\r\nkey\r\n*5\r\nvalue\r\n"

$model = $serializer->createRequestModel('get', array('key'));
var_dump($model->getCommand()); // string(3) "get"
var_dump($model->getArgs()); // array(1) { string(3) "key" }
var_dump($model->getValueNative()); // array(2) { string(3) "GET", string(3) "key" }

$model = $serializer->createReplyModel(array('mixed', 12, array('value')));
assert($model implement Model\MultiBulkReply);
```

## Install

It's very unlikely you'll want to use this protocol parser standalone.
It should be added as a dependency to your Redis client implementation instead.
The recommended way to install this library is [through Composer](https://getcomposer.org/).
[New to Composer?](https://getcomposer.org/doc/00-intro.md)

This will install the latest supported version:

```bash
composer require clue/redis-protocol:^0.3.2
```

See also the [CHANGELOG](CHANGELOG.md) for details about version upgrades.

This project aims to run on any platform and thus does not require any PHP
extensions and supports running on legacy PHP 5.3 through current PHP 8+.
It's *highly recommended to use the latest supported PHP version* for this project.

## Tests

To run the test suite, you first need to clone this repo and then install all
dependencies [through Composer](https://getcomposer.org/):

```bash
composer install
```

To run the test suite, go to the project root and run:

```bash
vendor/bin/phpunit
```

The test suite is set up to always ensure 100% code coverage across all
supported environments. If you have the Xdebug extension installed, you can also
generate a code coverage report locally like this:

```bash
XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-text
```

## License

Its parser and serializer originally used to be based on
[jpd/redisent](https://github.com/jdp/redisent), which is released under the ISC
license, copyright (c) 2009-2012 Justin Poliey <justin@getglue.com>.

Other than that, this project is released under the permissive [MIT license](LICENSE).

> Did you know that I offer custom development services and issuing invoices for
  sponsorships of releases and for contributions? Contact me (@clue) for details.
