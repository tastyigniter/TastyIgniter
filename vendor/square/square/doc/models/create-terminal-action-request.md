
# Create Terminal Action Request

## Structure

`CreateTerminalActionRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `idempotencyKey` | `string` | Required | A unique string that identifies this `CreateAction` request. Keys can be any valid string<br>but must be unique for every `CreateAction` request.<br><br>See [Idempotency keys](https://developer.squareup.com/docs/basics/api101/idempotency) for more<br>information.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `64` | getIdempotencyKey(): string | setIdempotencyKey(string idempotencyKey): void |
| `action` | [`TerminalAction`](../../doc/models/terminal-action.md) | Required | Represents an action processed by the Square Terminal. | getAction(): TerminalAction | setAction(TerminalAction action): void |

## Example (as JSON)

```json
{
  "action": {
    "deadline_duration": "PT5M",
    "device_id": "{{DEVICE_ID}}",
    "save_card_options": {
      "customer_id": "{{CUSTOMER_ID}}",
      "reference_id": "user-id-1"
    },
    "type": "SAVE_CARD"
  },
  "idempotency_key": "thahn-70e75c10-47f7-4ab6-88cc-aaa4076d065e"
}
```

