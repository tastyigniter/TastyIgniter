# Authorize.Net PHP SDK

[![Travis CI Status](https://travis-ci.org/AuthorizeNet/sdk-php.svg?branch=master)](https://travis-ci.org/AuthorizeNet/sdk-php)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/AuthorizeNet/sdk-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/AuthorizeNet/sdk-php/?branch=master)
[![Packagist Stable Version](https://poser.pugx.org/authorizenet/authorizenet/v/stable.svg)](https://packagist.org/packages/authorizenet/authorizenet)

## Requirements
* PHP 5.6+
* cURL PHP Extension
* JSON PHP Extension
* An Authorize.Net account (see _Registration & Configuration_ section below)
* TLS 1.2 capable versions of libcurl and OpenSSL (or its equivalent)

### Migrating from older versions
Since August 2018, the Authorize.Net API has been reorganized to be more merchant focused. Authorize.Net AIM, ARB, CIM, Transaction Reporting, and SIM classes have been deprecated in favor of net\authorize\api. To see the full list of mapping of new features corresponding to the deprecated features, see [MIGRATING.md](MIGRATING.md).

### Contribution
 - If you need information or clarification about Authorize.Net features, create an issue with your question. You can also search the [Authorize.Net developer community](https://community.developer.authorize.net/)for discussions related to your question.
 - Before creating pull requests, read [the contributors guide](CONTRIBUTING.md)

### TLS 1.2
The Authorize.Net APIs only support connections using the TLS 1.2 security protocol. Make sure to upgrade all required components to support TLS 1.2. Keep these components up to date to mitigate the risk of new security flaws.

To test whether your current installation is capable of communicating to our servers using TLS 1.2, run the following PHP code and examine the output for the TLS version:
```php
<?php
    $ch = curl_init('https://apitest.authorize.net/xml/v1/request.api');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, true);
    $data = curl_exec($ch);
    curl_close($ch);
```

If curl is unable to connect to our URL (as given in the previous sample), it's likely that your system is not able to connect using TLS 1.2, or does not have a supported cipher installed. To verify what TLS version your connection _does_ support, run the following PHP code: 
```php
<?php 
$ch = curl_init('https://www.howsmyssl.com/a/check');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
curl_close($ch);

$json = json_decode($data);
echo "Connection uses " . $json->tls_version ."\n";
```


## Installation
	
### Composer
We recommend using [`Composer`](http://getcomposer.org). *(Note: we never recommend you
override the new secure-http default setting)*. 
*Update your composer.json file as per the example below and then run for this specific release
`composer update`.*

```json
{
  "require": {
  "php": ">=5.6",
  "authorizenet/authorizenet": "2.0.2"
  }
}
```

After installation through Composer,
don't forget to require its autoloader in your script or bootstrap file:
```php
require 'vendor/autoload.php';
```

### Custom SPL Autoloader
Alternatively, we provide a custom `SPL` autoloader for you to reference from within your PHP file:
```php
require 'path/to/anet_php_sdk/autoload.php';
```
This autoloader still requires the `vendor` directory and all of its dependencies to exist.
However, this is a possible solution for cases where composer can't be run on a given system.
You can run composer locally or on another system to build the directory, then copy the
`vendor` directory to the desired system.


## Registration & Configuration
Use of this SDK and the Authorize.Net APIs requires having an account on the Authorize.Net system. You can find these details in the Settings section. If you don't currently have a production Authorize.Net account, [sign up for a sandbox account](https://developer.authorize.net/sandbox/).

### Authentication
To authenticate with the Authorize.Net API, use your account's API Login ID and Transaction Key. If you don't have these credentials, obtain them from the Merchant Interface. For production accounts, the Merchant Interface is located at (https://account.authorize.net/), and for sandbox accounts, at (https://sandbox.authorize.net).

After you have your credentials, load them into the appropriate variables in your code. The below sample code shows how to set the credentials as part of the API request.

#### To set your API credentials for an API request: 
...
```php
use net\authorize\api\contract\v1 as AnetAPI;
```
...

```php
$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
$merchantAuthentication->setName("YOURLOGIN");
$merchantAuthentication->setTransactionKey("YOURKEY");
```
...

```php
$request = new AnetAPI\CreateTransactionRequest();
$request->setMerchantAuthentication($merchantAuthentication);
```
...

You should never include your Login ID and Transaction Key directly in a PHP file that's in a publically accessible portion of your website. A better practice would be to define these in a constants file, and then reference those constants in the appropriate place in your code.

### Switching between the sandbox environment and the production environment
Authorize.Net maintains a complete sandbox environment for testing and development purposes. The sandbox environment is an exact replica of our production environment, with simulated transaction authorization and settlement. By default, this SDK is configured to use the sandbox environment. To switch to the production environment, replace the environment constant in the execute method. For example:
```php
// For PRODUCTION use
$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
```

API credentials are different for each environment, so be sure to switch to the appropriate credentials when switching environments.


## SDK Usage Examples and Sample Code
To get started using this SDK, it's highly recommended to download our sample code repository:
* [Authorize.Net PHP Sample Code Repository (on GitHub)](https://github.com/AuthorizeNet/sample-code-php)

In that respository, we have comprehensive sample code for all common uses of our API:

Additionally, you can find details and examples of how our API is structured in our API Reference Guide:
* [Developer Center API Reference](http://developer.authorize.net/api/reference/index.html)

The API Reference Guide provides examples of what information is needed for a particular request and how that information would be formatted. Using those examples, you can easily determine what methods would be necessary to include that information in a request using this SDK.


## Building & Testing the SDK
Integration tests for the AuthorizeNet SDK are in the `tests` directory. These tests
are mainly for SDK development. However, you can also browse through them to find
more usage examples for the various APIs.

- Run `composer update --dev` to load the `PHPUnit` test library.
- Copy the `phpunit.xml.dist` file to `phpunit.xml` and enter your merchant
  credentials in the constant fields.
- Run `vendor/bin/phpunit` to run the test suite.

*You'll probably want to disable emails on your sandbox account.*

### Testing Guide
For additional help in testing your own code, Authorize.Net maintains a [comprehensive testing guide](http://developer.authorize.net/hello_world/testing_guide/) that includes test credit card numbers to use and special triggers to generate certain responses from the sandbox environment.
 

## Logging
The SDK generates a log with masking for sensitive data like credit card, expiration dates. The provided levels for logging are 
 `debug`, `info`, `warn`, `error`. Add ````use \net\authorize\util\LogFactory;````. Logger can be initialized using `$logger = LogFactory::getLog(get_class($this));`
The default log file `phplog` gets generated in the current folder. The subsequent logs are appended to the same file, unless the execution folder is changed, and a new log file is generated.

### Usage Examples
- Logging a string message `$logger->debug("Sending 'XML' Request type");`
- Logging xml strings `$logger->debug($xmlRequest);`
- Logging using formatting `$logger->debugFormat("Integer: %d, Float: %f, Xml-Request: %s\n", array(100, 1.29f, $xmlRequest));`

### Customizing Sensitive Tags
A local copy of [AuthorizedNetSensitiveTagsConfig.json](/lib/net/authorize/util/ANetSensitiveFields.php) gets generated when code invoking the logger first gets executed. The local file can later be edited by developer to re-configure what is masked and what is visible. (*Do not edit the JSON in the SDK*). 
- For each element of the `sensitiveTags` array, 
  - `tagName` field corresponds to the name of the property in object, or xml-tag that should be hidden entirely ( *XXXX* shown if no replacement specified ) or masked (e.g. showing the last 4 digits of credit card number).
  - `pattern`[<sup>[Note]</sup>](#regex-note) and `replacement`[<sup>[Note]</sup>](#regex-note) can be left `""`, if the default is to be used (as defined in [Log.php](/lib/net/authorize/util/Log.php)). `pattern` gives the regex to identify, while `replacement` defines the visible part.
  - `disableMask` can be set to *true* to allow the log to fully display that property in an object, or tag in a xml string.
- `sensitiveStringRegexes`[<sup>[Note]</sup>](#regex-note) has list of credit-card regexes. So if credit-card number is not already masked, it would get entirely masked.
- Take care of non-ascii characters (refer [manual](http://php.net/manual/en/regexp.reference.unicode.php)) while defining the regex, e.g. use 
`"pattern": "(\\p{N}+)(\\p{N}{4})"` instead of `"pattern": "(\\d+)(\\d{4})"`. Also note `\\` escape sequence is used.

**<a name="regex-note">Note</a>:**
**For any regex, no starting or ending '/' or any other delimiter should be defined. The '/' delimiter and unicode flag is added in the code.**


 ### Transaction Hash Upgrade
Authorize.Net is phasing out the MD5 based `transHash` element in favor of the SHA-512 based `transHashSHA2`. The setting in the Merchant Interface which controlled the MD5 Hash option is no longer available, and the `transHash` element will stop returning values at a later date to be determined. For information on how to use `transHashSHA2`, see the [Transaction Hash Upgrade Guide] (https://developer.authorize.net/support/hash_upgrade/).


## License
This repository is distributed under a proprietary license. See the provided [`LICENSE.txt`](/LICENSE.txt) file.
