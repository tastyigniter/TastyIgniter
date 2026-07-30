
# Update Invoice Request

Describes a `UpdateInvoice` request.

## Structure

`UpdateInvoiceRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `invoice` | [`Invoice`](../../doc/models/invoice.md) | Required | Stores information about an invoice. You use the Invoices API to create and manage<br>invoices. For more information, see [Invoices API Overview](https://developer.squareup.com/docs/invoices-api/overview). | getInvoice(): Invoice | setInvoice(Invoice invoice): void |
| `idempotencyKey` | `?string` | Optional | A unique string that identifies the `UpdateInvoice` request. If you do not<br>provide `idempotency_key` (or provide an empty string as the value), the endpoint<br>treats each request as independent.<br><br>For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-apis/idempotency).<br>**Constraints**: *Maximum Length*: `128` | getIdempotencyKey(): ?string | setIdempotencyKey(?string idempotencyKey): void |
| `fieldsToClear` | `?(string[])` | Optional | The list of fields to clear.<br>For examples, see [Update an Invoice](https://developer.squareup.com/docs/invoices-api/update-invoices). | getFieldsToClear(): ?array | setFieldsToClear(?array fieldsToClear): void |

## Example (as JSON)

```json
{
  "fields_to_clear": [
    "payments_requests[2da7964f-f3d2-4f43-81e8-5aa220bf3355].reminders"
  ],
  "idempotency_key": "4ee82288-0910-499e-ab4c-5d0071dad1be",
  "invoice": {
    "payment_requests": [
      {
        "tipping_enabled": false,
        "uid": "2da7964f-f3d2-4f43-81e8-5aa220bf3355"
      }
    ],
    "version": 1
  }
}
```

