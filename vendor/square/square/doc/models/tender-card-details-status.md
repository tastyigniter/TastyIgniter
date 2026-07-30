
# Tender Card Details Status

Indicates the card transaction's current status.

## Enumeration

`TenderCardDetailsStatus`

## Fields

| Name | Description |
|  --- | --- |
| `AUTHORIZED` | The card transaction has been authorized but not yet captured. |
| `CAPTURED` | The card transaction was authorized and subsequently captured (i.e., completed). |
| `VOIDED` | The card transaction was authorized and subsequently voided (i.e., canceled). |
| `FAILED` | The card transaction failed. |

