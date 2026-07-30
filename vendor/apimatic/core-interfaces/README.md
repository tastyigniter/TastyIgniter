# APIMatic Core Library Interfaces
[![version][packagist-version]][packagist-url]
[![Maintainability](https://api.codeclimate.com/v1/badges/8c44cc226ce627f4efab/maintainability)](https://codeclimate.com/github/apimatic/core-interfaces-php/maintainability)
[![Licence][license-badge]][license-url]

## Introduction
Definition of the behavior of apimatic/core, apimatic/unirest-php and APIMatic's PHP SDK

## Supported PHP Versions
- PHP 7.2
- PHP 7.4
- PHP 8.0
- PHP 8.1
- PHP 8.2

## Install the Package

Run the following command to install the package and automatically add the dependency to your composer.json file:

```php
composer require "apimatic/core-interfaces"
```

## Interfaces
| Name                                                                    | Description                                                        |
|-------------------------------------------------------------------------|--------------------------------------------------------------------|
| [`ContextInterface`](src/Core/ContextInterface.php)                     | To save both Request and Response after the completion of response |
| [`AuthInterface`](src/Core/Authentication/AuthInterface.php)            | To Provide abstraction for all AuthManagers                        |
| [`ApiLoggerInterface`](src/Core/Logger/ApiLoggerInterface.php)          | To set up an abstract layer for logging requests and responses     |
| [`RequestInterface`](src/Core/Request/RequestInterface.php)             | To get the properties from the instance of Request                 |
| [`RequestSetterInterface`](src/Core/Request/RequestSetterInterface.php) | To update the instance of Request                                  |
| [`ParamInterface`](src/Core/Request/ParamInterface.php)                 | To Provide abstraction for common functionality of Parameters      |
| [`NonEmptyParamInterface`](src/Core/Request/NonEmptyParamInterface.php) | An extension of ParamInterface, for validation of non-empty values |
| [`TypeValidatorInterface`](src/Core/Request/TypeValidatorInterface.php) | To Provide abstraction for type validation in Parameters           |
| [`ResponseInterface`](src/Core/Response/ResponseInterface.php)          | To get the properties from the instance of Response                |
| [`HttpConfigurations`](src/Http/HttpConfigurations.php)                 | To hold the default configurations for HttpClient                  |
| [`HttpClientInterface`](src/Http/HttpClientInterface.php)               | To provide abstraction to execute API call in HttpClient           |
| [`ConverterInterface`](src/Sdk/ConverterInterface.php)                  | Holds required converter methods to create SDK classes             |
| [`ExceptionInterface`](src/Sdk/ExceptionInterface.php)                  | Default interface for all the exception models in SDK              |

## Enumerations
| Name                                                                          | Description                                                     |
|-------------------------------------------------------------------------------|-----------------------------------------------------------------|
| [`AuthGroup`](src/Core/Authentication/AuthGroup.php)                          | Enumeration for multiple Auth groups                            |
| [`RequestArraySerialization`](src/Core/Request/RequestArraySerialization.php) | Enumeration for all ArraySerialization formats                  |
| [`RequestMethod`](src/Core/Request/RequestMethod.php)                         | Enumeration for all possible types of requests                  |
| [`Format`](src/Core/Format.php)                                               | Enumeration for different formats of request body and responses |
| [`RetryOption`](src/Http/RetryOption.php)                                     | Enumeration for RetryingOption of each API call                 |


[packagist-url]: https://packagist.org/packages/apimatic/core-interfaces
[packagist-version]: https://img.shields.io/packagist/v/apimatic/core-interfaces.svg?style=flat
[packagist-downloads]: https://img.shields.io/packagist/dm/apimatic/core-interfaces.svg?style=flat
[license-badge]: https://img.shields.io/badge/license-MIT-blue
[license-url]: LICENSE
