
# Destination

Information about the destination against which the payout was made.

## Structure

`Destination`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `type` | [`?string (DestinationType)`](../../doc/models/destination-type.md) | Optional | List of possible destinations against which a payout can be made. | getType(): ?string | setType(?string type): void |
| `id` | `?string` | Optional | Square issued unique ID (also known as the instrument ID) associated with this destination. | getId(): ?string | setId(?string id): void |

## Example (as JSON)

```json
{
  "type": "SQUARE_BALANCE",
  "id": "id0"
}
```

