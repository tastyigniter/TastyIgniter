
# Terminal Action Query Filter

## Structure

`TerminalActionQueryFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `deviceId` | `?string` | Optional | `TerminalAction`s associated with a specific device. If no device is specified then all<br>`TerminalAction`s for the merchant will be displayed. | getDeviceId(): ?string | setDeviceId(?string deviceId): void |
| `createdAt` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getCreatedAt(): ?TimeRange | setCreatedAt(?TimeRange createdAt): void |
| `status` | `?string` | Optional | Filter results with the desired status of the `TerminalAction`<br>Options: `PENDING`, `IN_PROGRESS`, `CANCEL_REQUESTED`, `CANCELED`, `COMPLETED` | getStatus(): ?string | setStatus(?string status): void |
| `type` | [`?string (TerminalActionActionType)`](../../doc/models/terminal-action-action-type.md) | Optional | Describes the type of this unit and indicates which field contains the unit information. This is an ‘open’ enum. | getType(): ?string | setType(?string type): void |

## Example (as JSON)

```json
{
  "device_id": "device_id6",
  "created_at": {
    "start_at": "start_at4",
    "end_at": "end_at8"
  },
  "status": "status8",
  "type": "RECEIPT"
}
```

