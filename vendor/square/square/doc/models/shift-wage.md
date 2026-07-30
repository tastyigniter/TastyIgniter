
# Shift Wage

The hourly wage rate used to compensate an employee for this shift.

## Structure

`ShiftWage`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `title` | `?string` | Optional | The name of the job performed during this shift. Square<br>labor-reporting UIs might group shifts together by title. | getTitle(): ?string | setTitle(?string title): void |
| `hourlyRate` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getHourlyRate(): ?Money | setHourlyRate(?Money hourlyRate): void |

## Example (as JSON)

```json
{
  "title": "title4",
  "hourly_rate": {
    "amount": 172,
    "currency": "TJS"
  }
}
```

