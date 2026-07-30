# Sites

```php
$sitesApi = $client->getSitesApi();
```

## Class Name

`SitesApi`


# List Sites

Lists the Square Online sites that belong to a seller. Sites are listed in descending order by the `created_at` date.

__Note:__ Square Online APIs are publicly available as part of an early access program. For more information, see [Early access program for Square Online APIs](https://developer.squareup.com/docs/online-api#early-access-program-for-square-online-apis).

```php
function listSites(): ApiResponse
```

## Response Type

[`ListSitesResponse`](../../doc/models/list-sites-response.md)

## Example Usage

```php
$apiResponse = $sitesApi->listSites();

if ($apiResponse->isSuccess()) {
    $listSitesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

