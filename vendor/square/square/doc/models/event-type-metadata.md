
# Event Type Metadata

Contains the metadata of a webhook event type.

## Structure

`EventTypeMetadata`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `eventType` | `?string` | Optional | The event type. | getEventType(): ?string | setEventType(?string eventType): void |
| `apiVersionIntroduced` | `?string` | Optional | The API version at which the event type was introduced. | getApiVersionIntroduced(): ?string | setApiVersionIntroduced(?string apiVersionIntroduced): void |
| `releaseStatus` | `?string` | Optional | The release status of the event type. | getReleaseStatus(): ?string | setReleaseStatus(?string releaseStatus): void |

## Example (as JSON)

```json
{
  "event_type": "event_type0",
  "api_version_introduced": "api_version_introduced0",
  "release_status": "release_status4"
}
```

