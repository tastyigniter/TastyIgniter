
# Measurement Unit Custom

The information needed to define a custom unit, provided by the seller.

## Structure

`MeasurementUnitCustom`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `string` | Required | The name of the custom unit, for example "bushel". | getName(): string | setName(string name): void |
| `abbreviation` | `string` | Required | The abbreviation of the custom unit, such as "bsh" (bushel). This appears<br>in the cart for the Point of Sale app, and in reports. | getAbbreviation(): string | setAbbreviation(string abbreviation): void |

## Example (as JSON)

```json
{
  "name": "name0",
  "abbreviation": "abbreviation2"
}
```

