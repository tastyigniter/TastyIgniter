# Mobile Authorization

```php
$mobileAuthorizationApi = $client->getMobileAuthorizationApi();
```

## Class Name

`MobileAuthorizationApi`


# Create Mobile Authorization Code

Generates code to authorize a mobile application to connect to a Square card reader.

Authorization codes are one-time-use codes and expire 60 minutes after being issued.

__Important:__ The `Authorization` header you provide to this endpoint must have the following format:

```
Authorization: Bearer ACCESS_TOKEN
```

Replace `ACCESS_TOKEN` with a
[valid production authorization credential](https://developer.squareup.com/docs/build-basics/access-tokens).

```php
function createMobileAuthorizationCode(CreateMobileAuthorizationCodeRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`CreateMobileAuthorizationCodeRequest`](../../doc/models/create-mobile-authorization-code-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateMobileAuthorizationCodeResponse`](../../doc/models/create-mobile-authorization-code-response.md)

## Example Usage

```php
$body = CreateMobileAuthorizationCodeRequestBuilder::init()
    ->locationId('YOUR_LOCATION_ID')
    ->build();

$apiResponse = $mobileAuthorizationApi->createMobileAuthorizationCode($body);

if ($apiResponse->isSuccess()) {
    $createMobileAuthorizationCodeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

