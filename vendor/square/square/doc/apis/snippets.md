# Snippets

```php
$snippetsApi = $client->getSnippetsApi();
```

## Class Name

`SnippetsApi`

## Methods

* [Delete Snippet](../../doc/apis/snippets.md#delete-snippet)
* [Retrieve Snippet](../../doc/apis/snippets.md#retrieve-snippet)
* [Upsert Snippet](../../doc/apis/snippets.md#upsert-snippet)


# Delete Snippet

Removes your snippet from a Square Online site.

You can call [ListSites](../../doc/apis/sites.md#list-sites) to get the IDs of the sites that belong to a seller.

__Note:__ Square Online APIs are publicly available as part of an early access program. For more information, see [Early access program for Square Online APIs](https://developer.squareup.com/docs/online-api#early-access-program-for-square-online-apis).

```php
function deleteSnippet(string $siteId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `siteId` | `string` | Template, Required | The ID of the site that contains the snippet. |

## Response Type

[`DeleteSnippetResponse`](../../doc/models/delete-snippet-response.md)

## Example Usage

```php
$siteId = 'site_id6';

$apiResponse = $snippetsApi->deleteSnippet($siteId);

if ($apiResponse->isSuccess()) {
    $deleteSnippetResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Snippet

Retrieves your snippet from a Square Online site. A site can contain snippets from multiple snippet applications, but you can retrieve only the snippet that was added by your application.

You can call [ListSites](../../doc/apis/sites.md#list-sites) to get the IDs of the sites that belong to a seller.

__Note:__ Square Online APIs are publicly available as part of an early access program. For more information, see [Early access program for Square Online APIs](https://developer.squareup.com/docs/online-api#early-access-program-for-square-online-apis).

```php
function retrieveSnippet(string $siteId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `siteId` | `string` | Template, Required | The ID of the site that contains the snippet. |

## Response Type

[`RetrieveSnippetResponse`](../../doc/models/retrieve-snippet-response.md)

## Example Usage

```php
$siteId = 'site_id6';

$apiResponse = $snippetsApi->retrieveSnippet($siteId);

if ($apiResponse->isSuccess()) {
    $retrieveSnippetResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Upsert Snippet

Adds a snippet to a Square Online site or updates the existing snippet on the site.
The snippet code is appended to the end of the `head` element on every page of the site, except checkout pages. A snippet application can add one snippet to a given site.

You can call [ListSites](../../doc/apis/sites.md#list-sites) to get the IDs of the sites that belong to a seller.

__Note:__ Square Online APIs are publicly available as part of an early access program. For more information, see [Early access program for Square Online APIs](https://developer.squareup.com/docs/online-api#early-access-program-for-square-online-apis).

```php
function upsertSnippet(string $siteId, UpsertSnippetRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `siteId` | `string` | Template, Required | The ID of the site where you want to add or update the snippet. |
| `body` | [`UpsertSnippetRequest`](../../doc/models/upsert-snippet-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`UpsertSnippetResponse`](../../doc/models/upsert-snippet-response.md)

## Example Usage

```php
$siteId = 'site_id6';

$body = UpsertSnippetRequestBuilder::init(
    SnippetBuilder::init(
        '<script>var js = 1;</script>'
    )->build()
)->build();

$apiResponse = $snippetsApi->upsertSnippet(
    $siteId,
    $body
);

if ($apiResponse->isSuccess()) {
    $upsertSnippetResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

