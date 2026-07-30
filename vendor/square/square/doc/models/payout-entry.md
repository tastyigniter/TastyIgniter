
# Payout Entry

One or more PayoutEntries that make up a Payout. Each one has a date, amount, and type of activity.
The total amount of the payout will equal the sum of the payout entries for a batch payout

## Structure

`PayoutEntry`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `string` | Required | A unique ID for the payout entry.<br>**Constraints**: *Minimum Length*: `1` | getId(): string | setId(string id): void |
| `payoutId` | `string` | Required | The ID of the payout entries’ associated payout.<br>**Constraints**: *Minimum Length*: `1` | getPayoutId(): string | setPayoutId(string payoutId): void |
| `effectiveAt` | `?string` | Optional | The timestamp of when the payout entry affected the balance, in RFC 3339 format. | getEffectiveAt(): ?string | setEffectiveAt(?string effectiveAt): void |
| `type` | [`?string (ActivityType)`](../../doc/models/activity-type.md) | Optional | - | getType(): ?string | setType(?string type): void |
| `grossAmountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getGrossAmountMoney(): ?Money | setGrossAmountMoney(?Money grossAmountMoney): void |
| `feeAmountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getFeeAmountMoney(): ?Money | setFeeAmountMoney(?Money feeAmountMoney): void |
| `netAmountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getNetAmountMoney(): ?Money | setNetAmountMoney(?Money netAmountMoney): void |
| `typeAppFeeRevenueDetails` | [`?PaymentBalanceActivityAppFeeRevenueDetail`](../../doc/models/payment-balance-activity-app-fee-revenue-detail.md) | Optional | - | getTypeAppFeeRevenueDetails(): ?PaymentBalanceActivityAppFeeRevenueDetail | setTypeAppFeeRevenueDetails(?PaymentBalanceActivityAppFeeRevenueDetail typeAppFeeRevenueDetails): void |
| `typeAppFeeRefundDetails` | [`?PaymentBalanceActivityAppFeeRefundDetail`](../../doc/models/payment-balance-activity-app-fee-refund-detail.md) | Optional | - | getTypeAppFeeRefundDetails(): ?PaymentBalanceActivityAppFeeRefundDetail | setTypeAppFeeRefundDetails(?PaymentBalanceActivityAppFeeRefundDetail typeAppFeeRefundDetails): void |
| `typeAutomaticSavingsDetails` | [`?PaymentBalanceActivityAutomaticSavingsDetail`](../../doc/models/payment-balance-activity-automatic-savings-detail.md) | Optional | - | getTypeAutomaticSavingsDetails(): ?PaymentBalanceActivityAutomaticSavingsDetail | setTypeAutomaticSavingsDetails(?PaymentBalanceActivityAutomaticSavingsDetail typeAutomaticSavingsDetails): void |
| `typeAutomaticSavingsReversedDetails` | [`?PaymentBalanceActivityAutomaticSavingsReversedDetail`](../../doc/models/payment-balance-activity-automatic-savings-reversed-detail.md) | Optional | - | getTypeAutomaticSavingsReversedDetails(): ?PaymentBalanceActivityAutomaticSavingsReversedDetail | setTypeAutomaticSavingsReversedDetails(?PaymentBalanceActivityAutomaticSavingsReversedDetail typeAutomaticSavingsReversedDetails): void |
| `typeChargeDetails` | [`?PaymentBalanceActivityChargeDetail`](../../doc/models/payment-balance-activity-charge-detail.md) | Optional | - | getTypeChargeDetails(): ?PaymentBalanceActivityChargeDetail | setTypeChargeDetails(?PaymentBalanceActivityChargeDetail typeChargeDetails): void |
| `typeDepositFeeDetails` | [`?PaymentBalanceActivityDepositFeeDetail`](../../doc/models/payment-balance-activity-deposit-fee-detail.md) | Optional | - | getTypeDepositFeeDetails(): ?PaymentBalanceActivityDepositFeeDetail | setTypeDepositFeeDetails(?PaymentBalanceActivityDepositFeeDetail typeDepositFeeDetails): void |
| `typeDisputeDetails` | [`?PaymentBalanceActivityDisputeDetail`](../../doc/models/payment-balance-activity-dispute-detail.md) | Optional | - | getTypeDisputeDetails(): ?PaymentBalanceActivityDisputeDetail | setTypeDisputeDetails(?PaymentBalanceActivityDisputeDetail typeDisputeDetails): void |
| `typeFeeDetails` | [`?PaymentBalanceActivityFeeDetail`](../../doc/models/payment-balance-activity-fee-detail.md) | Optional | - | getTypeFeeDetails(): ?PaymentBalanceActivityFeeDetail | setTypeFeeDetails(?PaymentBalanceActivityFeeDetail typeFeeDetails): void |
| `typeFreeProcessingDetails` | [`?PaymentBalanceActivityFreeProcessingDetail`](../../doc/models/payment-balance-activity-free-processing-detail.md) | Optional | - | getTypeFreeProcessingDetails(): ?PaymentBalanceActivityFreeProcessingDetail | setTypeFreeProcessingDetails(?PaymentBalanceActivityFreeProcessingDetail typeFreeProcessingDetails): void |
| `typeHoldAdjustmentDetails` | [`?PaymentBalanceActivityHoldAdjustmentDetail`](../../doc/models/payment-balance-activity-hold-adjustment-detail.md) | Optional | - | getTypeHoldAdjustmentDetails(): ?PaymentBalanceActivityHoldAdjustmentDetail | setTypeHoldAdjustmentDetails(?PaymentBalanceActivityHoldAdjustmentDetail typeHoldAdjustmentDetails): void |
| `typeOpenDisputeDetails` | [`?PaymentBalanceActivityOpenDisputeDetail`](../../doc/models/payment-balance-activity-open-dispute-detail.md) | Optional | - | getTypeOpenDisputeDetails(): ?PaymentBalanceActivityOpenDisputeDetail | setTypeOpenDisputeDetails(?PaymentBalanceActivityOpenDisputeDetail typeOpenDisputeDetails): void |
| `typeOtherDetails` | [`?PaymentBalanceActivityOtherDetail`](../../doc/models/payment-balance-activity-other-detail.md) | Optional | - | getTypeOtherDetails(): ?PaymentBalanceActivityOtherDetail | setTypeOtherDetails(?PaymentBalanceActivityOtherDetail typeOtherDetails): void |
| `typeOtherAdjustmentDetails` | [`?PaymentBalanceActivityOtherAdjustmentDetail`](../../doc/models/payment-balance-activity-other-adjustment-detail.md) | Optional | - | getTypeOtherAdjustmentDetails(): ?PaymentBalanceActivityOtherAdjustmentDetail | setTypeOtherAdjustmentDetails(?PaymentBalanceActivityOtherAdjustmentDetail typeOtherAdjustmentDetails): void |
| `typeRefundDetails` | [`?PaymentBalanceActivityRefundDetail`](../../doc/models/payment-balance-activity-refund-detail.md) | Optional | - | getTypeRefundDetails(): ?PaymentBalanceActivityRefundDetail | setTypeRefundDetails(?PaymentBalanceActivityRefundDetail typeRefundDetails): void |
| `typeReleaseAdjustmentDetails` | [`?PaymentBalanceActivityReleaseAdjustmentDetail`](../../doc/models/payment-balance-activity-release-adjustment-detail.md) | Optional | - | getTypeReleaseAdjustmentDetails(): ?PaymentBalanceActivityReleaseAdjustmentDetail | setTypeReleaseAdjustmentDetails(?PaymentBalanceActivityReleaseAdjustmentDetail typeReleaseAdjustmentDetails): void |
| `typeReserveHoldDetails` | [`?PaymentBalanceActivityReserveHoldDetail`](../../doc/models/payment-balance-activity-reserve-hold-detail.md) | Optional | - | getTypeReserveHoldDetails(): ?PaymentBalanceActivityReserveHoldDetail | setTypeReserveHoldDetails(?PaymentBalanceActivityReserveHoldDetail typeReserveHoldDetails): void |
| `typeReserveReleaseDetails` | [`?PaymentBalanceActivityReserveReleaseDetail`](../../doc/models/payment-balance-activity-reserve-release-detail.md) | Optional | - | getTypeReserveReleaseDetails(): ?PaymentBalanceActivityReserveReleaseDetail | setTypeReserveReleaseDetails(?PaymentBalanceActivityReserveReleaseDetail typeReserveReleaseDetails): void |
| `typeSquareCapitalPaymentDetails` | [`?PaymentBalanceActivitySquareCapitalPaymentDetail`](../../doc/models/payment-balance-activity-square-capital-payment-detail.md) | Optional | - | getTypeSquareCapitalPaymentDetails(): ?PaymentBalanceActivitySquareCapitalPaymentDetail | setTypeSquareCapitalPaymentDetails(?PaymentBalanceActivitySquareCapitalPaymentDetail typeSquareCapitalPaymentDetails): void |
| `typeSquareCapitalReversedPaymentDetails` | [`?PaymentBalanceActivitySquareCapitalReversedPaymentDetail`](../../doc/models/payment-balance-activity-square-capital-reversed-payment-detail.md) | Optional | - | getTypeSquareCapitalReversedPaymentDetails(): ?PaymentBalanceActivitySquareCapitalReversedPaymentDetail | setTypeSquareCapitalReversedPaymentDetails(?PaymentBalanceActivitySquareCapitalReversedPaymentDetail typeSquareCapitalReversedPaymentDetails): void |
| `typeTaxOnFeeDetails` | [`?PaymentBalanceActivityTaxOnFeeDetail`](../../doc/models/payment-balance-activity-tax-on-fee-detail.md) | Optional | - | getTypeTaxOnFeeDetails(): ?PaymentBalanceActivityTaxOnFeeDetail | setTypeTaxOnFeeDetails(?PaymentBalanceActivityTaxOnFeeDetail typeTaxOnFeeDetails): void |
| `typeThirdPartyFeeDetails` | [`?PaymentBalanceActivityThirdPartyFeeDetail`](../../doc/models/payment-balance-activity-third-party-fee-detail.md) | Optional | - | getTypeThirdPartyFeeDetails(): ?PaymentBalanceActivityThirdPartyFeeDetail | setTypeThirdPartyFeeDetails(?PaymentBalanceActivityThirdPartyFeeDetail typeThirdPartyFeeDetails): void |
| `typeThirdPartyFeeRefundDetails` | [`?PaymentBalanceActivityThirdPartyFeeRefundDetail`](../../doc/models/payment-balance-activity-third-party-fee-refund-detail.md) | Optional | - | getTypeThirdPartyFeeRefundDetails(): ?PaymentBalanceActivityThirdPartyFeeRefundDetail | setTypeThirdPartyFeeRefundDetails(?PaymentBalanceActivityThirdPartyFeeRefundDetail typeThirdPartyFeeRefundDetails): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "payout_id": "payout_id6",
  "effective_at": "effective_at6",
  "type": "CHARGE",
  "gross_amount_money": {
    "amount": 186,
    "currency": "SVC"
  },
  "fee_amount_money": {
    "amount": 126,
    "currency": "ANG"
  },
  "net_amount_money": {
    "amount": 6,
    "currency": "AOA"
  },
  "type_app_fee_revenue_details": {
    "payment_id": "payment_id0",
    "location_id": "location_id4"
  },
  "type_app_fee_refund_details": {
    "payment_id": "payment_id6",
    "refund_id": "refund_id0",
    "location_id": "location_id0"
  },
  "type_automatic_savings_details": {
    "payment_id": "payment_id4",
    "payout_id": "payout_id0"
  },
  "type_automatic_savings_reversed_details": {
    "payment_id": "payment_id8",
    "payout_id": "payout_id4"
  },
  "type_charge_details": {
    "payment_id": "payment_id4"
  },
  "type_deposit_fee_details": {
    "payout_id": "payout_id8"
  },
  "type_dispute_details": {
    "payment_id": "payment_id4",
    "dispute_id": "dispute_id6"
  },
  "type_fee_details": {
    "payment_id": "payment_id8"
  },
  "type_free_processing_details": {
    "payment_id": "payment_id4"
  },
  "type_hold_adjustment_details": {
    "payment_id": "payment_id8"
  },
  "type_open_dispute_details": {
    "payment_id": "payment_id6",
    "dispute_id": "dispute_id8"
  },
  "type_other_details": {
    "payment_id": "payment_id8"
  },
  "type_other_adjustment_details": {
    "payment_id": "payment_id6"
  },
  "type_refund_details": {
    "payment_id": "payment_id8",
    "refund_id": "refund_id2"
  },
  "type_release_adjustment_details": {
    "payment_id": "payment_id4"
  },
  "type_reserve_hold_details": {
    "payment_id": "payment_id4"
  },
  "type_reserve_release_details": {
    "payment_id": "payment_id6"
  },
  "type_square_capital_payment_details": {
    "payment_id": "payment_id2"
  },
  "type_square_capital_reversed_payment_details": {
    "payment_id": "payment_id6"
  },
  "type_tax_on_fee_details": {
    "payment_id": "payment_id4",
    "tax_rate_description": "tax_rate_description2"
  },
  "type_third_party_fee_details": {
    "payment_id": "payment_id2"
  },
  "type_third_party_fee_refund_details": {
    "payment_id": "payment_id8",
    "refund_id": "refund_id2"
  }
}
```

