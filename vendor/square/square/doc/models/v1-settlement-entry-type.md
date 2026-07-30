
# V1 Settlement Entry Type

## Enumeration

`V1SettlementEntryType`

## Fields

| Name | Description |
|  --- | --- |
| `ADJUSTMENT` | A manual adjustment applied to the merchant's account by Square |
| `BALANCE_CHARGE` | A payment from an existing Square balance, such as a gift card |
| `CHARGE` | A credit card payment CAPTURE |
| `FREE_PROCESSING` | Square offers Free Payments Processing for a variety of business scenarios including seller referral or when we want to apologize for a bug, customer service, repricing complication, etc. This entry represents a credit to the merchant for the purposes of Free Processing. |
| `HOLD_ADJUSTMENT` | An adjustment made by Square related to holding/releasing a payment |
| `PAID_SERVICE_FEE` | a fee paid to a 3rd party merchant |
| `PAID_SERVICE_FEE_REFUND` | a refund for a 3rd party merchant fee |
| `REDEMPTION_CODE` | Repayment for a redemption code |
| `REFUND` | A refund for an existing card payment |
| `RETURNED_PAYOUT` | An entry created when we receive a response for the ACH file we sent indicating that the settlement of the original entry failed. |
| `SQUARE_CAPITAL_ADVANCE` | Initial deposit to a merchant for a Capital merchant cash advance (MCA). |
| `SQUARE_CAPITAL_PAYMENT` | Capital merchant cash advance (MCA) assessment. These are, generally, proportional to the merchant's sales but may be issued for other reasons related to the MCA. |
| `SQUARE_CAPITAL_REVERSED_PAYMENT` | Capital merchant cash advance (MCA) assessment refund. These are, generally, proportional to the merchant's refunds but may be issued for other reasons related to the MCA. |
| `SUBSCRIPTION_FEE` | Fee charged for subscription to a Square product |
| `SUBSCRIPTION_FEE_REFUND` | Refund of a previously charged Square product subscription fee. |
| `OTHER` |  |
| `INCENTED_PAYMENT` | A payment in which Square covers part of the funds for a purchase |
| `RETURNED_ACH_ENTRY` | A settlement failed to be processed and the settlement amount has been returned to the account |
| `RETURNED_SQUARE_275` | Refund for cancelling a Square Plus subscription |
| `SQUARE_275` | Fee charged for a Square Plus subscription ($275) |
| `SQUARE_CARD` | Settlements to or withdrawals from the Square Card (an asset) |

