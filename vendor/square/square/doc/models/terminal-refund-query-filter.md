
# Terminal Refund Query Filter

## Structure

`TerminalRefundQueryFilter`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `deviceId` | `?string` | Optional | `TerminalRefund` objects associated with a specific device. If no device is specified, then all<br>`TerminalRefund` objects for the signed-in account are displayed. | getDeviceId(): ?string | setDeviceId(?string deviceId): void |
| `createdAt` | [`?TimeRange`](../../doc/models/time-range.md) | Optional | Represents a generic time range. The start and end values are<br>represented in RFC 3339 format. Time ranges are customized to be<br>inclusive or exclusive based on the needs of a particular endpoint.<br>Refer to the relevant endpoint-specific documentation to determine<br>how time ranges are handled. | getCreatedAt(): ?TimeRange | setCreatedAt(?TimeRange createdAt): void |
| `status` | `?string` | Optional | Filtered results with the desired status of the `TerminalRefund`.<br>Options: `PENDING`, `IN_PROGRESS`, `CANCEL_REQUESTED`, `CANCELED`, or `COMPLETED`. | getStatus(): ?string | setStatus(?string status): void |

## Example (as JSON)

```json
{
  "device_id": "device_id6",
  "created_at": {
    "start_at": "start_at4",
    "end_at": "end_at8"
  },
  "status": "status8"
}
```

