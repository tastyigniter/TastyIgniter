# Bank Accounts

```php
$bankAccountsApi = $client->getBankAccountsApi();
```

## Class Name

`BankAccountsApi`

## Methods

* [List Bank Accounts](../../doc/apis/bank-accounts.md#list-bank-accounts)
* [Get Bank Account by V1 Id](../../doc/apis/bank-accounts.md#get-bank-account-by-v1-id)
* [Get Bank Account](../../doc/apis/bank-accounts.md#get-bank-account)


# List Bank Accounts

Returns a list of [BankAccount](../../doc/models/bank-account.md) objects linked to a Square account.

```php
function listBankAccounts(?string $cursor = null, ?int $limit = null, ?string $locationId = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `cursor` | `?string` | Query, Optional | The pagination cursor returned by a previous call to this endpoint.<br>Use it in the next `ListBankAccounts` request to retrieve the next set<br>of results.<br><br>See the [Pagination](https://developer.squareup.com/docs/working-with-apis/pagination) guide for more information. |
| `limit` | `?int` | Query, Optional | Upper limit on the number of bank accounts to return in the response.<br>Currently, 1000 is the largest supported limit. You can specify a limit<br>of up to 1000 bank accounts. This is also the default limit. |
| `locationId` | `?string` | Query, Optional | Location ID. You can specify this optional filter<br>to retrieve only the linked bank accounts belonging to a specific location. |

## Response Type

[`ListBankAccountsResponse`](../../doc/models/list-bank-accounts-response.md)

## Example Usage

```php
$apiResponse = $bankAccountsApi->listBankAccounts();

if ($apiResponse->isSuccess()) {
    $listBankAccountsResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Get Bank Account by V1 Id

Returns details of a [BankAccount](../../doc/models/bank-account.md) identified by V1 bank account ID.

```php
function getBankAccountByV1Id(string $v1BankAccountId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `v1BankAccountId` | `string` | Template, Required | Connect V1 ID of the desired `BankAccount`. For more information, see<br>[Retrieve a bank account by using an ID issued by V1 Bank Accounts API](https://developer.squareup.com/docs/bank-accounts-api#retrieve-a-bank-account-by-using-an-id-issued-by-v1-bank-accounts-api). |

## Response Type

[`GetBankAccountByV1IdResponse`](../../doc/models/get-bank-account-by-v1-id-response.md)

## Example Usage

```php
$v1BankAccountId = 'v1_bank_account_id8';

$apiResponse = $bankAccountsApi->getBankAccountByV1Id($v1BankAccountId);

if ($apiResponse->isSuccess()) {
    $getBankAccountByV1IdResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Get Bank Account

Returns details of a [BankAccount](../../doc/models/bank-account.md)
linked to a Square account.

```php
function getBankAccount(string $bankAccountId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `bankAccountId` | `string` | Template, Required | Square-issued ID of the desired `BankAccount`. |

## Response Type

[`GetBankAccountResponse`](../../doc/models/get-bank-account-response.md)

## Example Usage

```php
$bankAccountId = 'bank_account_id0';

$apiResponse = $bankAccountsApi->getBankAccount($bankAccountId);

if ($apiResponse->isSuccess()) {
    $getBankAccountResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

