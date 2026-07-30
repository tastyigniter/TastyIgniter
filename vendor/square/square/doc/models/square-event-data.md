
# Square Event Data

## Structure

`SquareEventData`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `type` | `?string` | Optional | Name of the affected object’s type. | getType(): ?string | setType(?string type): void |
| `id` | `?string` | Optional | ID of the affected object. | getId(): ?string | setId(?string id): void |
| `deleted` | `?bool` | Optional | Is true if the affected object was deleted. Otherwise absent. | getDeleted(): ?bool | setDeleted(?bool deleted): void |
| `object` | `mixed` | Optional | An object containing fields and values relevant to the event. Is absent if affected object was deleted. | getObject(): | setObject( object): void |

## Example (as JSON)

```json
{
  "type": "type0",
  "id": "id0",
  "deleted": false,
  "object": {
    "key1": "val1",
    "key2": "val2"
  }
}
```

