
# Delete Invoice Request

Describes a `DeleteInvoice` request.

## Structure

`DeleteInvoiceRequest`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `version` | `?int` | Optional | The version of the [invoice](entity:Invoice) to delete.<br>If you do not know the version, you can call [GetInvoice](api-endpoint:Invoices-GetInvoice) or<br>[ListInvoices](api-endpoint:Invoices-ListInvoices). | getVersion(): ?int | setVersion(?int version): void |

## Example (as JSON)

```json
{
  "version": 172
}
```

