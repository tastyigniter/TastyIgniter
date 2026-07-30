
# Dispute Evidence File

A file to be uploaded as dispute evidence.

## Structure

`DisputeEvidenceFile`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `filename` | `?string` | Optional | The file name including the file extension. For example: "receipt.tiff".<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `40` | getFilename(): ?string | setFilename(?string filename): void |
| `filetype` | `?string` | Optional | Dispute evidence files must be application/pdf, image/heic, image/heif, image/jpeg, image/png, or image/tiff formats.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `40` | getFiletype(): ?string | setFiletype(?string filetype): void |

## Example (as JSON)

```json
{
  "filename": "filename2",
  "filetype": "filetype2"
}
```

