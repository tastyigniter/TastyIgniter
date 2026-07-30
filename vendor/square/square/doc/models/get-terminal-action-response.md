
# Get Terminal Action Response

## Structure

`GetTerminalActionResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Information on errors encountered during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `action` | [`?TerminalAction`](../../doc/models/terminal-action.md) | Optional | Represents an action processed by the Square Terminal. | getAction(): ?TerminalAction | setAction(?TerminalAction action): void |

## Example (as JSON)

```json
{
  "action": {
    "app_id": "APP_ID",
    "created_at": "2021-07-28T23:22:07.476Z",
    "deadline_duration": "PT5M",
    "device_id": "DEVICE_ID",
    "id": "termapia:jveJIAkkAjILHkdCE",
    "location_id": "LOCATION_ID",
    "save_card_options": {
      "customer_id": "CUSTOMER_ID",
      "reference_id": "user-id-1"
    },
    "status": "IN_PROGRESS",
    "type": "SAVE_CARD",
    "updated_at": "2021-07-28T23:22:08.301Z"
  }
}
```

