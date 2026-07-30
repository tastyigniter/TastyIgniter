# Changelog

## 0.3.2 (2024-08-07)

*   Feature: Improve PHP 8.4+ support by avoiding implicitly nullable types.
    (#19 by @clue)

*   Update project structure, homepage and examples. 
    Add `.gitattributes` to exclude dev files from exports.
    (#16, #20, #21 and #22 by @clue)

*   Update test suite to use GitHub actions for continuous integration (CI),
    run tests on all PHP versions up to PHP 8.3 and ensure 100% code coverage.
    (#15 by @SimonFrings and #17 and #18 by @clue)

## 0.3.1 (2017-06-06)

* Fix: Fix server-side parsing of legacy inline protocol when multiple requests are processed at once
  (#12 by @kelunik and #13 by @clue)

## 0.3.0 (2014-01-27)

* Feature: Add dedicated and faster `RequestParser` that also support the old
  inline request protocol.

* Feature: Message serialization can now be handled directly by the Serializer
  again without having to construct the appropriate model first.

* BC break: The `Factory` now has two distinct methods to create parsers:
  * `createResponseParser()` for a client-side library
  * `createRequestParser()` for a server-side library / testing framework

* BC break: Simplified parser API, now `pushIncoming()` returns an array of all
  parsed message models.

* BC break: The signature for getting a serialized message from a model was
  changed and now requires a Serializer passed:

  ```php
  ModelInterface::getMessageSerialized($serializer)
  ```

  * Many, many performance improvements

## 0.2.0 (2014-01-21)

* Re-organize the whole API into dedicated
  * `Parser` (protocol reader) and
  * `Serializer` (protocol writer) sub-namespaces. (#4)

* Use of the factory has now been unified:

  ```php
  $factory = new Clue\Redis\Protocol\Factory();
  $parser = $factory->createParser();
  $serializer = $factory->createSerializer();
  ```

* Add a dedicated `Model` for each type of reply. Among others, this now allows
  you to distinguish a single line `StatusReply` from a binary-safe `BulkReply`. (#2)

* Fix parsing binary values and do not trip over trailing/leading whitespace. (#4)

* Improve parser and serializer performance by up to 20%. (#4)

## 0.1.0 (2013-09-10)

* First tagged release

