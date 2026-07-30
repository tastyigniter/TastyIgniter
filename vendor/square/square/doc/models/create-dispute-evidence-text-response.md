
# Create Dispute Evidence Text Response

Defines the fields in a `CreateDisputeEvidenceText` response.

## Structure

`CreateDisputeEvidenceTextResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `evidence` | [`?DisputeEvidence`](../../doc/models/dispute-evidence.md) | Optional | - | getEvidence(): ?DisputeEvidence | setEvidence(?DisputeEvidence evidence): void |

## Example (as JSON)

```json
{
  "evidence": {
    "dispute_id": "bVTprrwk0gygTLZ96VX1oB",
    "evidence_text": "The customer purchased the item twice, on April 11 and April 28.",
    "evidence_type": "REBUTTAL_EXPLANATION",
    "id": "TOomLInj6iWmP3N8qfCXrB",
    "uploaded_at": "2022-05-18T16:01:10.000Z"
  }
}
```

