
# Cancel Invoice Request

Describes a `CancelInvoice` request.

## Structure

`CancelInvoiceRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `version` | `int` | Required | The version of the [invoice](entity:Invoice) to cancel.<br>If you do not know the version, you can call<br>[GetInvoice](api-endpoint:Invoices-GetInvoice) or [ListInvoices](api-endpoint:Invoices-ListInvoices). | getVersion(): int | setVersion(int version): void |

## Example (as JSON)

```json
{
  "version": 0
}
```

