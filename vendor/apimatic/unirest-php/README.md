# Unirest for PHP

[![version][packagist-version]][packagist-url]
[![Downloads][packagist-downloads]][packagist-url]
[![Tests](https://github.com/apimatic/unirest-php/actions/workflows/php.yml/badge.svg)](https://github.com/apimatic/unirest-php/actions/workflows/php.yml)
[![License][packagist-license]][license-url]

Unirest is a set of lightweight HTTP libraries available in [multiple languages](http://unirest.io).

This fork is maintained by [APIMatic](https://www.apimatic.io) for its Code Generator as a Service.

## Features

* Request class to create custom requests
* Simple HttpClientInterface to execute a Request
* Automatic JSON parsing into a native object for JSON responses
* Response data class to store http response information
* Supports form parameters, file uploads and custom body entities
* Supports gzip
* Supports Basic, Digest, Negotiate, NTLM Authentication natively
* Configuration class manage all the HttpClient's configurations
* Customizable timeout
* Customizable retries and backoff
* Customizable default headers for every request (DRY)

## Supported PHP Versions
- PHP 7.2
- PHP 7.4
- PHP 8.0
- PHP 8.1
- PHP 8.2

## Installation

To install `apimatic/unirest-php` with Composer, just add the following to your `composer.json` file:

```json
{
    "require": {
        "apimatic/unirest-php": "^4.0.0"
    }
}
```

or by running the following command:

```shell
composer require apimatic/unirest-php
```

## Usage

### Creating a HttpClient with Default Configurations
You can create a variable at class level and instantiate it with an instance of `HttpClient`, like:

```php
private $httpClient = new \Unirest\HttpClient();
```

### Creating a HttpClient with Custom Configurations
To create a client with custom configurations you first required an instance of `Configuration`, and then add it to the HttpClient during its initialization, like:
```php
$configurations = \Unirest\Configuration::init()
    ->timeout(10)
    ->enableRetries(true)
    ->retryInterval(2.5);
$httpClient = new \Unirest\HttpClient($configurations);
```
This `Configuration` instance can further be customized by setting properties like: `maximumRetryWaitTime`, `verifyPeer`, `defaultHeaders`, etc. Check out [Advanced Configuration](#advanced-configuration) for more information.

### Creating a Request
After the initialization of HttpClient, you will be needing an instance of `Request` that is required to be exchanged as `Response`.
```php
$request = new \Unirest\Request\Request(
    'http://mockbin.com/request',
    RequestMethod::GET,
    ['headerKey' => 'headerValue'],
    Unirest\Request\Body::json(["key" => "value"]'),
    RetryOption::ENABLE_RETRY
);
```
Let's look at a working example of sending the above request:

```php
$headers = array('Accept' => 'application/json');
$query = array('foo' => 'hello', 'bar' => 'world');

$response = $this->httpClient->execute($request);

$response->getStatusCode(); // HTTP Status code
$response->getHeaders();    // Headers
$response->getBody();       // Parsed body
$response->getRawBody();    // Unparsed body
```

### JSON Requests *(`application/json`)*

A JSON Request can be constructed using the `Unirest\Request\Body::Json` helper:

```php
$headers = array('Accept' => 'application/json');
$data = array('name' => 'ahmad', 'company' => 'mashape');

$body = Unirest\Request\Body::Json($data);
$request = new \Unirest\Request\Request(
    'http://mockbin.com/request',
    RequestMethod::POST,
    $headers,
    $body
);
$response = $this->httpClient->execute($request);
```

**Notes:**
- `Content-Type` headers will be automatically set to `application/json` 
- the data variable will be processed through [`json_encode`](http://php.net/manual/en/function.json-encode.php) with default values for arguments.
- an error will be thrown if the [JSON Extension](http://php.net/manual/en/book.json.php) is not available.

### Form Requests *(`application/x-www-form-urlencoded`)*

A typical Form Request can be constructed using the `Unirest\Request\Body::Form` helper:

```php
$headers = array('Accept' => 'application/json');
$data = array('name' => 'ahmad', 'company' => 'mashape');

$body = Unirest\Request\Body::Form($data);
$request = new \Unirest\Request\Request(
    'http://mockbin.com/request',
    RequestMethod::POST,
    $headers,
    $body
);
$response = $this->httpClient->execute($request);
```

**Notes:** 
- `Content-Type` headers will be automatically set to `application/x-www-form-urlencoded`
- the final data array will be processed through [`http_build_query`](http://php.net/manual/en/function.http-build-query.php) with default values for arguments.

### Multipart Requests *(`multipart/form-data`)*

A Multipart Request can be constructed using the `Unirest\Request\Body::Multipart` helper:

```php
$headers = array('Accept' => 'application/json');
$data = array('name' => 'ahmad', 'company' => 'mashape');

$body = Unirest\Request\Body::Multipart($data);
$request = new \Unirest\Request\Request(
    'http://mockbin.com/request',
    RequestMethod::POST,
    $headers,
    $body
);
$response = $this->httpClient->execute($request);
```

**Notes:** 

- `Content-Type` headers will be automatically set to `multipart/form-data`.
- an auto-generated `--boundary` will be set.

### Multipart File Upload

simply add an array of files as the second argument to to the `Multipart` helper:

```php
$headers = array('Accept' => 'application/json');
$data = array('name' => 'ahmad', 'company' => 'mashape');
$files = array('bio' => '/path/to/bio.txt', 'avatar' => '/path/to/avatar.jpg');

$body = Unirest\Request\Body::Multipart($data, $files);
$request = new \Unirest\Request\Request(
    'http://mockbin.com/request',
    RequestMethod::POST,
    $headers,
    $body
);
$response = $this->httpClient->execute($request);
 ```

If you wish to further customize the properties of files uploaded you can do so with the `Unirest\Request\Body::File` helper:

```php
$headers = array('Accept' => 'application/json');
$body = array(
    'name' => 'ahmad', 
    'company' => 'mashape'
    'bio' => Unirest\Request\Body::File('/path/to/bio.txt', 'text/plain'),
    'avatar' => Unirest\Request\Body::File('/path/to/my_avatar.jpg', 'text/plain', 'avatar.jpg')
);
$request = new \Unirest\Request\Request(
    'http://mockbin.com/request',
    RequestMethod::POST,
    $headers,
    $body
);
$response = $this->httpClient->execute($request);
 ```

**Note**: we did not use the `Unirest\Request\Body::multipart` helper in this example, it is not needed when manually adding files.
 
### Custom Body

Sending a custom body such rather than using the `Unirest\Request\Body` helpers is also possible, for example, using a [`serialize`](http://php.net/manual/en/function.serialize.php) body string with a custom `Content-Type`:

```php
$headers = array('Accept' => 'application/json', 'Content-Type' => 'application/x-php-serialized');
$body = serialize((array('foo' => 'hello', 'bar' => 'world'));
$request = new \Unirest\Request\Request(
    'http://mockbin.com/request',
    RequestMethod::POST,
    $headers,
    $body
);
$response = $this->httpClient->execute($request);
```

### Authentication
For Authentication you need httpClient instance with custom configurations, So, create `Configuration` instance like:

```php
// Basic auth
$configuration = Configuration::init()
    ->auth('username', 'password', CURLAUTH_BASIC);
```

The third parameter, which is a bitmask, will Unirest which HTTP authentication method(s) you want it to use for your proxy authentication.

If more than one bit is set, Unirest *(at PHP's libcurl level)* will first query the site to see what authentication methods it supports and then pick the best one you allow it to use. *For some methods, this will induce an extra network round-trip.*

**Supported Methods**

| Method               | Description                                                                                                                                                                                                     |
| -------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `CURLAUTH_BASIC`     | HTTP Basic authentication. This is the default choice                                                                                                                                                           | 
| `CURLAUTH_DIGEST`    | HTTP Digest authentication. as defined in [RFC 2617](http://www.ietf.org/rfc/rfc2617.txt)                                                                                                                       | 
| `CURLAUTH_DIGEST_IE` | HTTP Digest authentication with an IE flavor. *The IE flavor is simply that libcurl will use a special "quirk" that IE is known to have used before version 7 and that some servers require the client to use.* | 
| `CURLAUTH_NEGOTIATE` | HTTP Negotiate (SPNEGO) authentication. as defined in [RFC 4559](http://www.ietf.org/rfc/rfc4559.txt)                                                                                                           |
| `CURLAUTH_NTLM`      | HTTP NTLM authentication. A proprietary protocol invented and used by Microsoft.                                                                                                                                |
| `CURLAUTH_NTLM_WB`   | NTLM delegating to winbind helper. Authentication is performed by a separate binary application. *see [libcurl docs](http://curl.haxx.se/libcurl/c/CURLOPT_HTTPAUTH.html) for more info*                        | 
| `CURLAUTH_ANY`       | This is a convenience macro that sets all bits and thus makes libcurl pick any it finds suitable. libcurl will automatically select the one it finds most secure.                                               |
| `CURLAUTH_ANYSAFE`   | This is a convenience macro that sets all bits except Basic and thus makes libcurl pick any it finds suitable. libcurl will automatically select the one it finds most secure.                                  |
| `CURLAUTH_ONLY`      | This is a meta symbol. OR this value together with a single specific auth value to force libcurl to probe for un-restricted auth and if not, only that single auth algorithm is acceptable.                     |

```php
// custom auth method
$configuration = Configuration::init()
    ->proxyAuth('username', 'password', CURLAUTH_DIGEST);
```
### Cookies

Set a cookie string to specify the contents of a cookie header. Multiple cookies are separated with a semicolon followed by a space (e.g., "fruit=apple; colour=red")

```php
$configuration = Configuration::init()
    ->cookie($cookie);
```

Set a cookie file path for enabling cookie reading and storing cookies across multiple sequence of requests.

```php
$this->request->cookieFile($cookieFile)
```

`$cookieFile` must be a correct path with write permission.

### Response Object

Upon receiving a response Unirest returns the result in the form of an Object, this object should always have the same keys for each language regarding to the response details.
- `getStatusCode()` - HTTP Response Status Code (Example `200`)
- `getHeaders()` - HTTP Response Headers
- `getBody()` - Parsed response body where applicable, for example JSON responses are parsed to Objects / Associative Arrays.
- `getRawBody()` - Un-parsed response body

### Advanced Configuration

You can set some advanced configuration to tune Unirest-PHP:

#### Custom JSON Decode Flags

Unirest uses PHP's [JSON Extension](http://php.net/manual/en/book.json.php) for automatically decoding JSON responses.
sometime you may want to return associative arrays, limit the depth of recursion, or use any of the [customization flags](http://php.net/manual/en/json.constants.php).

To do so, simply set the desired options using the `jsonOpts` request method:

```php
$configuration = Configuration::init()
    ->jsonOpts(true, 512, JSON_NUMERIC_CHECK & JSON_FORCE_OBJECT & JSON_UNESCAPED_SLASHES);
```

#### Timeout

You can set a custom timeout value (in **seconds**):

```php
$configuration = Configuration::init()
    ->timeout(5); // 5s timeout
```

#### Retries Related

```php
$configuration = Configuration::init()
    ->enableRetries(true)               // To enable retries feature
    ->maxNumberOfRetries(10)            // To set max number of retries
    ->retryOnTimeout(false)             // Should we retry on timeout
    ->retryInterval(20)                 // Initial retry interval in seconds
    ->maximumRetryWaitTime(30)          // Maximum retry wait time
    ->backoffFactor(1.1)                // Backoff factor to be used to increase retry interval
    ->httpStatusCodesToRetry([400,401]) // Http status codes to retry against
    ->httpMethodsToRetry(['POST'])      // Http methods to retry against
```

#### Proxy

Set the proxy to use for the upcoming request.

you can also set the proxy type to be one of `CURLPROXY_HTTP`, `CURLPROXY_HTTP_1_0`, `CURLPROXY_SOCKS4`, `CURLPROXY_SOCKS5`, `CURLPROXY_SOCKS4A`, and `CURLPROXY_SOCKS5_HOSTNAME`.

*check the [cURL docs](http://curl.haxx.se/libcurl/c/CURLOPT_PROXYTYPE.html) for more info*.

```php
// quick setup with default port: 1080
$configuration = Configuration::init()
    ->proxy('10.10.10.1');

// custom port and proxy type
$configuration = Configuration::init()
    ->proxy('10.10.10.1', 8080, CURLPROXY_HTTP);

// enable tunneling
$configuration = Configuration::init()
    ->proxy('10.10.10.1', 8080, CURLPROXY_HTTP, true);
```

##### Proxy Authentication

Passing a username, password *(optional)*, defaults to Basic Authentication:

```php
// basic auth
$configuration = Configuration::init()
    ->proxyAuth('username', 'password');
```

The third parameter, which is a bitmask, will Unirest which HTTP authentication method(s) you want it to use for your proxy authentication. 

If more than one bit is set, Unirest *(at PHP's libcurl level)* will first query the site to see what authentication methods it supports and then pick the best one you allow it to use. *For some methods, this will induce an extra network round-trip.*

See [Authentication](#authentication) for more details on methods supported.

```php
// basic auth
$configuration = Configuration::init()
    ->proxyAuth('username', 'password', CURLAUTH_DIGEST);
```

#### Default Request Headers

You can set default headers that will be sent on every request:

```php
$configuration = Configuration::init()
    ->defaultHeader('Header1', 'Value1')
    ->defaultHeader('Header2', 'Value2');
```

You can set default headers in bulk by passing an array:

```php
$configuration = Configuration::init()
    ->defaultHeaders([
        'Header1' => 'Value1',
        'Header2' => 'Value2'
    ]);
```

You can clear the default headers anytime with:

```php
$configuration = Configuration::init()
    ->clearDefaultHeaders();
```

#### Default cURL Options

You can set default [cURL options](http://php.net/manual/en/function.curl-setopt.php) that will be sent on every request:

```php
$configuration = Configuration::init()
    ->curlOpt(CURLOPT_COOKIE, 'foo=bar');
```

You can set options bulk by passing an array:

```php
$configuration = Configuration::init()
    ->curlOpts(array(
    CURLOPT_COOKIE => 'foo=bar'
));
```

You can clear the default options anytime with:

```php
$configuration = Configuration::init()
    ->clearCurlOpts();
```

#### SSL validation

You can explicitly enable or disable SSL certificate validation when consuming an SSL protected endpoint:

```php
$configuration = Configuration::init()
    ->verifyPeer(false); // Disables SSL cert validation
```

By default is `true`.

#### Utility Methods

```php
// alias for `curl_getinfo`
$httpClient->getInfo();

```

----

[license-url]: https://github.com/apimatic/unirest-php/blob/master/LICENSE
[travis-url]: https://travis-ci.org/apimatic/unirest-php
[travis-image]: https://img.shields.io/travis/apimatic/unirest-php.svg?style=flat
[packagist-url]: https://packagist.org/packages/apimatic/unirest-php
[packagist-license]: https://img.shields.io/packagist/l/apimatic/unirest-php.svg?style=flat
[packagist-version]: https://img.shields.io/packagist/v/apimatic/unirest-php.svg?style=flat
[packagist-downloads]: https://img.shields.io/packagist/dm/apimatic/unirest-php.svg?style=flat
