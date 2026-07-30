# Disputes

```php
$disputesApi = $client->getDisputesApi();
```

## Class Name

`DisputesApi`

## Methods

* [List Disputes](../../doc/apis/disputes.md#list-disputes)
* [Retrieve Dispute](../../doc/apis/disputes.md#retrieve-dispute)
* [Accept Dispute](../../doc/apis/disputes.md#accept-dispute)
* [List Dispute Evidence](../../doc/apis/disputes.md#list-dispute-evidence)
* [Create Dispute Evidence File](../../doc/apis/disputes.md#create-dispute-evidence-file)
* [Create Dispute Evidence Text](../../doc/apis/disputes.md#create-dispute-evidence-text)
* [Delete Dispute Evidence](../../doc/apis/disputes.md#delete-dispute-evidence)
* [Retrieve Dispute Evidence](../../doc/apis/disputes.md#retrieve-dispute-evidence)
* [Submit Evidence](../../doc/apis/disputes.md#submit-evidence)


# List Disputes

Returns a list of disputes associated with a particular account.

```php
function listDisputes(?string $cursor = null, ?string $states = null, ?string $locationId = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `cursor` | `?string` | Query, Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for the original query.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |
| `states` | [`?string (DisputeState)`](../../doc/models/dispute-state.md) | Query, Optional | The dispute states used to filter the result. If not specified, the endpoint returns all disputes. |
| `locationId` | `?string` | Query, Optional | The ID of the location for which to return a list of disputes.<br>If not specified, the endpoint returns disputes associated with all locations. |

## Response Type

[`ListDisputesResponse`](../../doc/models/list-disputes-response.md)

## Example Usage

```php
$apiResponse = $disputesApi->listDisputes();

if ($apiResponse->isSuccess()) {
    $listDisputesResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Dispute

Returns details about a specific dispute.

```php
function retrieveDispute(string $disputeId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `disputeId` | `string` | Template, Required | The ID of the dispute you want more details about. |

## Response Type

[`RetrieveDisputeResponse`](../../doc/models/retrieve-dispute-response.md)

## Example Usage

```php
$disputeId = 'dispute_id2';

$apiResponse = $disputesApi->retrieveDispute($disputeId);

if ($apiResponse->isSuccess()) {
    $retrieveDisputeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Accept Dispute

Accepts the loss on a dispute. Square returns the disputed amount to the cardholder and
updates the dispute state to ACCEPTED.

Square debits the disputed amount from the seller’s Square account. If the Square account
does not have sufficient funds, Square debits the associated bank account.

```php
function acceptDispute(string $disputeId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `disputeId` | `string` | Template, Required | The ID of the dispute you want to accept. |

## Response Type

[`AcceptDisputeResponse`](../../doc/models/accept-dispute-response.md)

## Example Usage

```php
$disputeId = 'dispute_id2';

$apiResponse = $disputesApi->acceptDispute($disputeId);

if ($apiResponse->isSuccess()) {
    $acceptDisputeResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# List Dispute Evidence

Returns a list of evidence associated with a dispute.

```php
function listDisputeEvidence(string $disputeId, ?string $cursor = null): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `disputeId` | `string` | Template, Required | The ID of the dispute. |
| `cursor` | `?string` | Query, Optional | A pagination cursor returned by a previous call to this endpoint.<br>Provide this cursor to retrieve the next set of results for the original query.<br>For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). |

## Response Type

[`ListDisputeEvidenceResponse`](../../doc/models/list-dispute-evidence-response.md)

## Example Usage

```php
$disputeId = 'dispute_id2';

$apiResponse = $disputesApi->listDisputeEvidence($disputeId);

if ($apiResponse->isSuccess()) {
    $listDisputeEvidenceResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Dispute Evidence File

Uploads a file to use as evidence in a dispute challenge. The endpoint accepts HTTP
multipart/form-data file uploads in HEIC, HEIF, JPEG, PDF, PNG, and TIFF formats.

```php
function createDisputeEvidenceFile(
    string $disputeId,
    ?CreateDisputeEvidenceFileRequest $request = null,
    ?FileWrapper $imageFile = null
): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `disputeId` | `string` | Template, Required | The ID of the dispute for which you want to upload evidence. |
| `request` | [`?CreateDisputeEvidenceFileRequest`](../../doc/models/create-dispute-evidence-file-request.md) | Form (JSON-Encoded), Optional | Defines the parameters for a `CreateDisputeEvidenceFile` request. |
| `imageFile` | `?FileWrapper` | Form, Optional | - |

## Response Type

[`CreateDisputeEvidenceFileResponse`](../../doc/models/create-dispute-evidence-file-response.md)

## Example Usage

```php
$disputeId = 'dispute_id2';

$apiResponse = $disputesApi->createDisputeEvidenceFile($disputeId);

if ($apiResponse->isSuccess()) {
    $createDisputeEvidenceFileResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Create Dispute Evidence Text

Uploads text to use as evidence for a dispute challenge.

```php
function createDisputeEvidenceText(string $disputeId, CreateDisputeEvidenceTextRequest $body): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `disputeId` | `string` | Template, Required | The ID of the dispute for which you want to upload evidence. |
| `body` | [`CreateDisputeEvidenceTextRequest`](../../doc/models/create-dispute-evidence-text-request.md) | Body, Required | An object containing the fields to POST for the request.<br><br>See the corresponding object definition for field details. |

## Response Type

[`CreateDisputeEvidenceTextResponse`](../../doc/models/create-dispute-evidence-text-response.md)

## Example Usage

```php
$disputeId = 'dispute_id2';

$body = CreateDisputeEvidenceTextRequestBuilder::init(
    'ed3ee3933d946f1514d505d173c82648',
    '1Z8888888888888888'
)
    ->evidenceType(DisputeEvidenceType::TRACKING_NUMBER)
    ->build();

$apiResponse = $disputesApi->createDisputeEvidenceText(
    $disputeId,
    $body
);

if ($apiResponse->isSuccess()) {
    $createDisputeEvidenceTextResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Delete Dispute Evidence

Removes specified evidence from a dispute.
Square does not send the bank any evidence that is removed.

```php
function deleteDisputeEvidence(string $disputeId, string $evidenceId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `disputeId` | `string` | Template, Required | The ID of the dispute from which you want to remove evidence. |
| `evidenceId` | `string` | Template, Required | The ID of the evidence you want to remove. |

## Response Type

[`DeleteDisputeEvidenceResponse`](../../doc/models/delete-dispute-evidence-response.md)

## Example Usage

```php
$disputeId = 'dispute_id2';

$evidenceId = 'evidence_id2';

$apiResponse = $disputesApi->deleteDisputeEvidence(
    $disputeId,
    $evidenceId
);

if ($apiResponse->isSuccess()) {
    $deleteDisputeEvidenceResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Retrieve Dispute Evidence

Returns the metadata for the evidence specified in the request URL path.

You must maintain a copy of any evidence uploaded if you want to reference it later. Evidence cannot be downloaded after you upload it.

```php
function retrieveDisputeEvidence(string $disputeId, string $evidenceId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `disputeId` | `string` | Template, Required | The ID of the dispute from which you want to retrieve evidence metadata. |
| `evidenceId` | `string` | Template, Required | The ID of the evidence to retrieve. |

## Response Type

[`RetrieveDisputeEvidenceResponse`](../../doc/models/retrieve-dispute-evidence-response.md)

## Example Usage

```php
$disputeId = 'dispute_id2';

$evidenceId = 'evidence_id2';

$apiResponse = $disputesApi->retrieveDisputeEvidence(
    $disputeId,
    $evidenceId
);

if ($apiResponse->isSuccess()) {
    $retrieveDisputeEvidenceResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```


# Submit Evidence

Submits evidence to the cardholder's bank.

The evidence submitted by this endpoint includes evidence uploaded
using the [CreateDisputeEvidenceFile](../../doc/apis/disputes.md#create-dispute-evidence-file) and
[CreateDisputeEvidenceText](../../doc/apis/disputes.md#create-dispute-evidence-text) endpoints and
evidence automatically provided by Square, when available. Evidence cannot be removed from
a dispute after submission.

```php
function submitEvidence(string $disputeId): ApiResponse
```

## Parameters

| Parameter | Type | Tags | Description |
|  --- | --- | --- | --- |
| `disputeId` | `string` | Template, Required | The ID of the dispute for which you want to submit evidence. |

## Response Type

[`SubmitEvidenceResponse`](../../doc/models/submit-evidence-response.md)

## Example Usage

```php
$disputeId = 'dispute_id2';

$apiResponse = $disputesApi->submitEvidence($disputeId);

if ($apiResponse->isSuccess()) {
    $submitEvidenceResponse = $apiResponse->getResult();
} else {
    $errors = $apiResponse->getErrors();
}

// Getting more response information
var_dump($apiResponse->getStatusCode());
var_dump($apiResponse->getHeaders());
```

