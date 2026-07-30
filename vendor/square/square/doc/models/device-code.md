
# Device Code

## Structure

`DeviceCode`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The unique id for this device code. | getId(): ?string | setId(?string id): void |
| `name` | `?string` | Optional | An optional user-defined name for the device code.<br>**Constraints**: *Maximum Length*: `128` | getName(): ?string | setName(?string name): void |
| `code` | `?string` | Optional | The unique code that can be used to login. | getCode(): ?string | setCode(?string code): void |
| `deviceId` | `?string` | Optional | The unique id of the device that used this code. Populated when the device is paired up. | getDeviceId(): ?string | setDeviceId(?string deviceId): void |
| `productType` | `string` | Required, Constant | **Default**: `'TERMINAL_API'` | getProductType(): string | setProductType(string productType): void |
| `locationId` | `?string` | Optional | The location assigned to this code.<br>**Constraints**: *Maximum Length*: `50` | getLocationId(): ?string | setLocationId(?string locationId): void |
| `status` | [`?string (DeviceCodeStatus)`](../../doc/models/device-code-status.md) | Optional | DeviceCode.Status enum. | getStatus(): ?string | setStatus(?string status): void |
| `pairBy` | `?string` | Optional | When this DeviceCode will expire and no longer login. Timestamp in RFC 3339 format. | getPairBy(): ?string | setPairBy(?string pairBy): void |
| `createdAt` | `?string` | Optional | When this DeviceCode was created. Timestamp in RFC 3339 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `statusChangedAt` | `?string` | Optional | When this DeviceCode's status was last changed. Timestamp in RFC 3339 format. | getStatusChangedAt(): ?string | setStatusChangedAt(?string statusChangedAt): void |
| `pairedAt` | `?string` | Optional | When this DeviceCode was paired. Timestamp in RFC 3339 format. | getPairedAt(): ?string | setPairedAt(?string pairedAt): void |

## Example (as JSON)

```json
{
  "product_type": "TERMINAL_API"
}
```

