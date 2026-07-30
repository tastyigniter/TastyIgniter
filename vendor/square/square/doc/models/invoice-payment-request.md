
# Invoice Payment Request

Represents a payment request for an [invoice](../../doc/models/invoice.md). Invoices can specify a maximum
of 13 payment requests, with up to 12 `INSTALLMENT` request types. For more information,
see [Configuring payment requests](https://developer.squareup.com/docs/invoices-api/create-publish-invoices#payment-requests).

Adding `INSTALLMENT` payment requests to an invoice requires an
[Invoices Plus subscription](https://developer.squareup.com/docs/invoices-api/overview#invoices-plus-subscription).

## Structure

`InvoicePaymentRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | The Square-generated ID of the payment request in an [invoice](entity:Invoice).<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `255` | getUid(): ?string | setUid(?string uid): void |
| `requestMethod` | [`?string (InvoiceRequestMethod)`](../../doc/models/invoice-request-method.md) | Optional | Specifies the action for Square to take for processing the invoice. For example,<br>email the invoice, charge a customer's card on file, or do nothing. DEPRECATED at<br>version 2021-01-21. The corresponding `request_method` field is replaced by the<br>`Invoice.delivery_method` and `InvoicePaymentRequest.automatic_payment_source` fields. | getRequestMethod(): ?string | setRequestMethod(?string requestMethod): void |
| `requestType` | [`?string (InvoiceRequestType)`](../../doc/models/invoice-request-type.md) | Optional | Indicates the type of the payment request. For more information, see<br>[Configuring payment requests](https://developer.squareup.com/docs/invoices-api/create-publish-invoices#payment-requests). | getRequestType(): ?string | setRequestType(?string requestType): void |
| `dueDate` | `?string` | Optional | The due date (in the invoice's time zone) for the payment request, in `YYYY-MM-DD` format. This field<br>is required to create a payment request. If an `automatic_payment_source` is defined for the request, Square<br>charges the payment source on this date.<br><br>After this date, the invoice becomes overdue. For example, a payment `due_date` of 2021-03-09 with a `timezone`<br>of America/Los\_Angeles becomes overdue at midnight on March 9 in America/Los\_Angeles (which equals a UTC<br>timestamp of 2021-03-10T08:00:00Z). | getDueDate(): ?string | setDueDate(?string dueDate): void |
| `fixedAmountRequestedMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getFixedAmountRequestedMoney(): ?Money | setFixedAmountRequestedMoney(?Money fixedAmountRequestedMoney): void |
| `percentageRequested` | `?string` | Optional | Specifies the amount for the payment request in percentage:<br><br>- When the payment `request_type` is `DEPOSIT`, it is the percentage of the order's total amount.<br>- When the payment `request_type` is `INSTALLMENT`, it is the percentage of the order's total less<br>  the deposit, if requested. The sum of the `percentage_requested` in all installment<br>  payment requests must be equal to 100.<br><br>You cannot specify this when the payment `request_type` is `BALANCE` or when the<br>payment request specifies the `fixed_amount_requested_money` field. | getPercentageRequested(): ?string | setPercentageRequested(?string percentageRequested): void |
| `tippingEnabled` | `?bool` | Optional | If set to true, the Square-hosted invoice page (the `public_url` field of the invoice)<br>provides a place for the customer to pay a tip.<br><br>This field is allowed only on the final payment request  <br>and the payment `request_type` must be `BALANCE` or `INSTALLMENT`. | getTippingEnabled(): ?bool | setTippingEnabled(?bool tippingEnabled): void |
| `automaticPaymentSource` | [`?string (InvoiceAutomaticPaymentSource)`](../../doc/models/invoice-automatic-payment-source.md) | Optional | Indicates the automatic payment method for an [invoice payment request](../../doc/models/invoice-payment-request.md). | getAutomaticPaymentSource(): ?string | setAutomaticPaymentSource(?string automaticPaymentSource): void |
| `cardId` | `?string` | Optional | The ID of the credit or debit card on file to charge for the payment request. To get the cards on file for a customer,<br>call [ListCards](api-endpoint:Cards-ListCards) and include the `customer_id` of the invoice recipient.<br>**Constraints**: *Minimum Length*: `1`, *Maximum Length*: `255` | getCardId(): ?string | setCardId(?string cardId): void |
| `reminders` | [`?(InvoicePaymentReminder[])`](../../doc/models/invoice-payment-reminder.md) | Optional | A list of one or more reminders to send for the payment request. | getReminders(): ?array | setReminders(?array reminders): void |
| `computedAmountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getComputedAmountMoney(): ?Money | setComputedAmountMoney(?Money computedAmountMoney): void |
| `totalCompletedAmountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalCompletedAmountMoney(): ?Money | setTotalCompletedAmountMoney(?Money totalCompletedAmountMoney): void |
| `roundingAdjustmentIncludedMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getRoundingAdjustmentIncludedMoney(): ?Money | setRoundingAdjustmentIncludedMoney(?Money roundingAdjustmentIncludedMoney): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "request_method": "CHARGE_CARD_ON_FILE",
  "request_type": "BALANCE",
  "due_date": "due_date8",
  "fixed_amount_requested_money": {
    "amount": 162,
    "currency": "TOP"
  },
  "percentage_requested": "percentage_requested2",
  "tipping_enabled": false,
  "automatic_payment_source": "CARD_ON_FILE",
  "card_id": "card_id4",
  "reminders": [
    {
      "uid": "uid6",
      "relative_scheduled_days": 86,
      "message": "message6",
      "status": "NOT_APPLICABLE",
      "sent_at": "sent_at6"
    },
    {
      "uid": "uid7",
      "relative_scheduled_days": 87,
      "message": "message7",
      "status": "PENDING",
      "sent_at": "sent_at7"
    },
    {
      "uid": "uid8",
      "relative_scheduled_days": 88,
      "message": "message8",
      "status": "SENT",
      "sent_at": "sent_at8"
    }
  ],
  "computed_amount_money": {
    "amount": 32,
    "currency": "ETB"
  },
  "total_completed_amount_money": {
    "amount": 168,
    "currency": "BIF"
  },
  "rounding_adjustment_included_money": {
    "amount": 232,
    "currency": "SEK"
  }
}
```

