
# Invoice Request Type

Indicates the type of the payment request. For more information, see
[Configuring payment requests](https://developer.squareup.com/docs/invoices-api/create-publish-invoices#payment-requests).

## Enumeration

`InvoiceRequestType`

## Fields

| Name | Description |
|  --- | --- |
| `BALANCE` | A request for a balance payment. The balance amount is computed as follows:<br><br>- If the invoice specifies only a balance payment request, the balance amount is the<br>  total amount of the associated order.<br>- If the invoice also specifies a deposit request, the balance amount is the amount<br>  remaining after the deposit.<br><br>`INSTALLMENT` and `BALANCE` payment requests are not allowed in the same invoice. |
| `DEPOSIT` | A request for a deposit payment. You have the option of specifying<br>an exact amount or a percentage of the total order amount. If you request a deposit,<br>it must be due before any other payment requests. |
| `INSTALLMENT` | A request for an installment payment. Installments allow buyers to pay the invoice over time. Installments can optionally be combined with a deposit.<br><br>Adding `INSTALLMENT` payment requests to an invoice requires an<br>[Invoices Plus subscription](https://developer.squareup.com/docs/invoices-api/overview#invoices-plus-subscription). |

