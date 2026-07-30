
# Device Checkout Options

## Structure

`DeviceCheckoutOptions`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `deviceId` | `string` | Required | The unique ID of the device intended for this `TerminalCheckout`.<br>A list of `DeviceCode` objects can be retrieved from the /v2/devices/codes endpoint.<br>Match a `DeviceCode.device_id` value with `device_id` to get the associated device code. | getDeviceId(): string | setDeviceId(string deviceId): void |
| `skipReceiptScreen` | `?bool` | Optional | Instructs the device to skip the receipt screen. Defaults to false. | getSkipReceiptScreen(): ?bool | setSkipReceiptScreen(?bool skipReceiptScreen): void |
| `collectSignature` | `?bool` | Optional | Indicates that signature collection is desired during checkout. Defaults to false. | getCollectSignature(): ?bool | setCollectSignature(?bool collectSignature): void |
| `tipSettings` | [`?TipSettings`](../../doc/models/tip-settings.md) | Optional | - | getTipSettings(): ?TipSettings | setTipSettings(?TipSettings tipSettings): void |
| `showItemizedCart` | `?bool` | Optional | Show the itemization screen prior to taking a payment. This field is only meaningful when the<br>checkout includes an order ID. Defaults to true. | getShowItemizedCart(): ?bool | setShowItemizedCart(?bool showItemizedCart): void |

## Example (as JSON)

```json
{
  "device_id": "device_id6",
  "skip_receipt_screen": false,
  "collect_signature": false,
  "tip_settings": {
    "allow_tipping": false,
    "separate_tip_screen": false,
    "custom_tip_field": false,
    "tip_percentages": [
      48
    ],
    "smart_tipping": false
  },
  "show_itemized_cart": false
}
```

