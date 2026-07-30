
# Invoice Recipient Tax Ids

Represents the tax IDs for an invoice recipient. The country of the seller account determines
whether the corresponding `tax_ids` field is available for the customer. For more information,
see [Invoice recipient tax IDs](https://developer.squareup.com/docs/invoices-api/overview#recipient-tax-ids).

## Structure

`InvoiceRecipientTaxIds`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `euVat` | `?string` | Optional | The EU VAT identification number for the invoice recipient. For example, `IE3426675K`. | getEuVat(): ?string | setEuVat(?string euVat): void |

## Example (as JSON)

```json
{
  "eu_vat": "eu_vat2"
}
```

