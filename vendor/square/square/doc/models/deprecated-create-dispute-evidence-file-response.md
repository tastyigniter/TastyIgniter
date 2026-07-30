
# Deprecated Create Dispute Evidence File Response

Defines the fields in a `DeprecatedCreateDisputeEvidenceFile` response.

## Structure

`DeprecatedCreateDisputeEvidenceFileResponse`

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
    "evidence_file": {
      "filename": "evidence.tiff",
      "filetype": "image/tiff"
    },
    "evidence_id": "TOomLInj6iWmP3N8qfCXrB",
    "evidence_type": "GENERIC_EVIDENCE",
    "uploaded_at": "2018-10-18T16:01:10.000Z"
  }
}
```

