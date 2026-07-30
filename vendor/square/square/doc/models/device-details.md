
# Device Details

Details about the device that took the payment.

## Structure

`DeviceDetails`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `deviceId` | `?string` | Optional | The Square-issued ID of the device.<br>**Constraints**: *Maximum Length*: `255` | getDeviceId(): ?string | setDeviceId(?string deviceId): void |
| `deviceInstallationId` | `?string` | Optional | The Square-issued installation ID for the device.<br>**Constraints**: *Maximum Length*: `255` | getDeviceInstallationId(): ?string | setDeviceInstallationId(?string deviceInstallationId): void |
| `deviceName` | `?string` | Optional | The name of the device set by the seller.<br>**Constraints**: *Maximum Length*: `255` | getDeviceName(): ?string | setDeviceName(?string deviceName): void |

## Example (as JSON)

```json
{
  "device_id": "device_id6",
  "device_installation_id": "device_installation_id8",
  "device_name": "device_name2"
}
```

