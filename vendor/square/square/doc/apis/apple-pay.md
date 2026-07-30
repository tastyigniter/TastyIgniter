# Apple Pay

```php
$applePayApi = $client->getApplePayApi();
```

## Class Name

`ApplePayApi`


# Register Domain

Activates a domain for use with Apple Pay on the Web and Square. A validation
is performed on this domain by Apple to ensure that it is properly set up as
an Apple Pay enabled domain.

This endpoint provides an easy way for platform developers to bulk activate
Apple Pay on the Web with Square for merchants using their platform.

Note: The SqPaymentForm library is deprecated as of May 13, 2021, and will only receive critical security updates until it is retired on October 31, 2022.
You must migrate your payment form code to the Web Payments SDK to continue using your domain for Apple Pay. For more information on migrating to the Web Payments SDK, see [Migrate to the Web Payments SDK](https://developer.squareup.com/docs/web-payments/migrate).

To learn more about the Web Payments SDK and how to add Apple Pay, see [Take an Apple Pay Payment](https://developer.squareup.com/docs/web-payments/apple-pay).

```php
function registerDomain(RegisterDomainRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`RegisterDomainRequest`](../../doc/models/register-domain-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`RegisterDomainResponse`](../../doc/models/register-domain-response.md)

## Example Usage

```php
$body = RegisterDomainRequestBuilder::init(
    'example.com'
)->build();

$apiResponse = $applePayApi->registerDomain($body);

if ($apiResponse->isSuccess()) {
    $registerDomainResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

