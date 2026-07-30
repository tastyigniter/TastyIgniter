
# List Dispute Evidence Response

Defines the fields in a `ListDisputeEvidence` response.

## Structure

`ListDisputeEvidenceResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `evidence` | [`?(DisputeEvidence[])`](../../doc/models/dispute-evidence.md) | Optional | The list of evidence previously uploaded to the specified dispute. | getEvidence(): ?array | setEvidence(?array evidence): void |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information about errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `cursor` | `?string` | Optional | The pagination cursor to be used in a subsequent request.<br>If unset, this is the final response. For more information, see [Pagination](https://developer.squareup.com/docs/build-basics/common-api-patterns/pagination). | getCursor(): ?string | setCursor(?string cursor): void |

## Example (as JSON)

```json
{
  "evidence": [
    {
      "evidence_id": "evidence_id6",
      "id": "id6",
      "dispute_id": "dispute_id8",
      "evidence_file": {
        "filename": "filename4",
        "filetype": "filetype4"
      },
      "evidence_text": "evidence_text0",
      "uploaded_at": "uploaded_at0",
      "evidence_type": "REBUTTAL_EXPLANATION"
    },
    {
      "evidence_id": "evidence_id5",
      "id": "id7",
      "dispute_id": "dispute_id9",
      "evidence_file": {
        "filename": "filename5",
        "filetype": "filetype5"
      },
      "evidence_text": "evidence_text1",
      "uploaded_at": "uploaded_at1",
      "evidence_type": "RELATED_TRANSACTION_DOCUMENTATION"
    }
  ],
  "errors": [
    {
      "category": "AUTHENTICATION_ERROR",
      "code": "REFUND_ALREADY_PENDING",
      "detail": "detail1",
      "field": "field9"
    },
    {
      "category": "INVALID_REQUEST_ERROR",
      "code": "PAYMENT_NOT_REFUNDABLE",
      "detail": "detail2",
      "field": "field0"
    },
    {
      "category": "RATE_LIMIT_ERROR",
      "code": "REFUND_DECLINED",
      "detail": "detail3",
      "field": "field1"
    }
  ],
  "cursor": "cursor6"
}
```

