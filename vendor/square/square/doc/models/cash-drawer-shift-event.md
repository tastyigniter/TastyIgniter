
# Cash Drawer Shift Event

## Structure

`CashDrawerShiftEvent`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The unique ID of the event. | getId(): ?string | setId(?string id): void |
| `employeeId` | `?string` | Optional | The ID of the employee that created the event. | getEmployeeId(): ?string | setEmployeeId(?string employeeId): void |
| `eventType` | [`?string (CashDrawerEventType)`](../../doc/models/cash-drawer-event-type.md) | Optional | The types of events on a CashDrawerShift.<br>Each event type represents an employee action on the actual cash drawer<br>represented by a CashDrawerShift. | getEventType(): ?string | setEventType(?string eventType): void |
| `eventMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getEventMoney(): ?Money | setEventMoney(?Money eventMoney): void |
| `createdAt` | `?string` | Optional | The event time in ISO 8601 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `description` | `?string` | Optional | An optional description of the event, entered by the employee that<br>created the event. | getDescription(): ?string | setDescription(?string description): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "employee_id": "employee_id0",
  "event_type": "OTHER_TENDER_CANCELLED_PAYMENT",
  "event_money": {
    "amount": 148,
    "currency": "HTG"
  },
  "created_at": "created_at2",
  "description": "description0"
}
```

