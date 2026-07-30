# O Auth

```php
$oAuthApi = $client->getOAuthApi();
```

## Class Name

`OAuthApi`

## Methods

* [Renew Token](../../doc/apis/o-auth.md#renew-token)
* [Revoke Token](../../doc/apis/o-auth.md#revoke-token)
* [Obtain Token](../../doc/apis/o-auth.md#obtain-token)
* [Retrieve Token Status](../../doc/apis/o-auth.md#retrieve-token-status)


# Renew Token

**This endpoint is deprecated.**

`RenewToken` is deprecated. For information about refreshing OAuth access tokens, see
[Migrate from Renew to Refresh OAuth Tokens](https://developer.squareup.com/docs/oauth-api/migrate-to-refresh-tokens).

Renews an OAuth access token before it expires.

OAuth access tokens besides your application's personal access token expire after 30 days.
You can also renew expired tokens within 15 days of their expiration.
You cannot renew an access token that has been expired for more than 15 days.
Instead, the associated user must recomplete the OAuth flow from the beginning.

__Important:__ The `Authorization` header for this endpoint must have the
following format:

```
Authorization: Client APPLICATION_SECRET
```

Replace `APPLICATION_SECRET` with the application secret on the Credentials
page in the [Developer Dashboard](https://developer.squareup.com/apps).

:information_source: **Note** This endpoint does not require authentication.

```php
function renewToken(string $clientId, RenewTokenRequest $body, string $authorization): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `clientId` | `string` | Template, Required | Your application ID, which is available in the OAuth page in the [Developer Dashboard](https://developer.squareup.com/apps). |
| `body` | [`RenewTokenRequest`](../../doc/models/renew-token-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |
| `authorization` | `string` | Header, Required | Client APPLICATION_SECRET |

## Response Type

[`RenewTokenResponse`](../../doc/models/renew-token-response.md)

## Example Usage

```php
$clientId = 'client_id8';

$body = RenewTokenRequestBuilder::init()
    ->accessToken('ACCESS_TOKEN')
    ->build();

$authorization = 'Client CLIENT_SECRET';

$apiResponse = $oAuthApi->renewToken(
    $clientId,
    $body,
    $authorization
);

if ($apiResponse->isSuccess()) {
    $renewTokenResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Revoke Token

Revokes an access token generated with the OAuth flow.

If an account has more than one OAuth access token for your application, this
endpoint revokes all of them, regardless of which token you specify. When an
OAuth access token is revoked, all of the active subscriptions associated
with that OAuth token are canceled immediately.

__Important:__ The `Authorization` header for this endpoint must have the
following format:

```
Authorization: Client APPLICATION_SECRET
```

Replace `APPLICATION_SECRET` with the application secret on the OAuth
page for your application on the Developer Dashboard.

:information_source: **Note** This endpoint does not require authentication.

```php
function revokeToken(RevokeTokenRequest $body, string $authorization): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`RevokeTokenRequest`](../../doc/models/revoke-token-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |
| `authorization` | `string` | Header, Required | Client APPLICATION_SECRET |

## Response Type

[`RevokeTokenResponse`](../../doc/models/revoke-token-response.md)

## Example Usage

```php
$body = RevokeTokenRequestBuilder::init()
    ->clientId('CLIENT_ID')
    ->accessToken('ACCESS_TOKEN')
    ->build();

$authorization = 'Client CLIENT_SECRET';

$apiResponse = $oAuthApi->revokeToken(
    $body,
    $authorization
);

if ($apiResponse->isSuccess()) {
    $revokeTokenResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Obtain Token

Returns an OAuth access token and a refresh token unless the
`short_lived` parameter is set to `true`, in which case the endpoint
returns only an access token.

The `grant_type` parameter specifies the type of OAuth request. If
`grant_type` is `authorization_code`, you must include the authorization
code you received when a seller granted you authorization. If `grant_type`
is `refresh_token`, you must provide a valid refresh token. If you are using
an old version of the Square APIs (prior to March 13, 2019), `grant_type`
can be `migration_token` and you must provide a valid migration token.

You can use the `scopes` parameter to limit the set of permissions granted
to the access token and refresh token. You can use the `short_lived` parameter
to create an access token that expires in 24 hours.

__Note:__ OAuth tokens should be encrypted and stored on a secure server.
Application clients should never interact directly with OAuth tokens.

:information_source: **Note** This endpoint does not require authentication.

```php
function obtainToken(ObtainTokenRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `body` | [`ObtainTokenRequest`](../../doc/models/obtain-token-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`ObtainTokenResponse`](../../doc/models/obtain-token-response.md)

## Example Usage

```php
$body = ObtainTokenRequestBuilder::init(
    'APPLICATION_ID',
    'authorization_code'
)
    ->clientSecret('APPLICATION_SECRET')
    ->code('CODE_FROM_AUTHORIZE')
    ->build();

$apiResponse = $oAuthApi->obtainToken($body);

if ($apiResponse->isSuccess()) {
    $obtainTokenResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Token Status

Returns information about an [OAuth access token](https://developer.squareup.com/docs/build-basics/access-tokens#get-an-oauth-access-token) or an application’s [personal access token](https://developer.squareup.com/docs/build-basics/access-tokens#get-a-personal-access-token).

Add the access token to the Authorization header of the request.

__Important:__ The `Authorization` header you provide to this endpoint must have the following format:

```
Authorization: Bearer ACCESS_TOKEN
```

where `ACCESS_TOKEN` is a
[valid production authorization credential](https://developer.squareup.com/docs/build-basics/access-tokens).

If the access token is expired or not a valid access token, the endpoint returns an `UNAUTHORIZED` error.

:information_source: **Note** This endpoint does not require authentication.

```php
function retrieveTokenStatus(string $authorization): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `authorization` | `string` | Header, Required | Client APPLICATION_SECRET |

## Response Type

[`RetrieveTokenStatusResponse`](../../doc/models/retrieve-token-status-response.md)

## Example Usage

```php
$authorization = 'Client CLIENT_SECRET';

$apiResponse = $oAuthApi->retrieveTokenStatus($authorization);

if ($apiResponse->isSuccess()) {
    $retrieveTokenStatusResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

