# Employees

```php
$employeesApi = $client->getEmployeesApi();
```

## Class Name

`EmployeesApi`

## Methods

* [List Employees](../../doc/apis/employees.md#list-employees)
* [Retrieve Employee](../../doc/apis/employees.md#retrieve-employee)


# List Employees

**This endpoint is deprecated.**

ListEmployees

```php
function listEmployees(
    ?string $locationId = null,
    ?string $status = null,
    ?int $limit = null,
    ?string $cursor = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `locationId` | `?string` | Query, Optional | - |
| `status` | [`?string (EmployeeStatus)`](../../doc/models/employee-status.md) | Query, Optional | Specifies the EmployeeStatus to filter the employee by. |
| `limit` | `?int` | Query, Optional | The number of employees to be returned on each page. |
| `cursor` | `?string` | Query, Optional | The token required to retrieve the specified page of results. |

## Response Type

[`ListEmployeesResponse`](../../doc/models/list-employees-response.md)

## Example Usage

```php
$apiResponse = $employeesApi->listEmployees();

if ($apiResponse->isSuccess()) {
    $listEmployeesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Employee

**This endpoint is deprecated.**

RetrieveEmployee

```php
function retrieveEmployee(string $id): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `id` | `string` | Template, Required | UUID for the employee that was requested. |

## Response Type

[`RetrieveEmployeeResponse`](../../doc/models/retrieve-employee-response.md)

## Example Usage

```php
$id = 'id0';

$apiResponse = $employeesApi->retrieveEmployee($id);

if ($apiResponse->isSuccess()) {
    $retrieveEmployeeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

