
# V1 Refund

V1Refund

## Structure

`V1Refund`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `type` | [`?string (V1RefundType)`](../../doc/models/v1-refund-type.md) | Optional | - | getType(): ?string | setType(?string type): void |
| `reason` | `?string` | Optional | The merchant-specified reason for the refund. | getReason(): ?string | setReason(?string reason): void |
| `refundedMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedMoney(): ?V1Money | setRefundedMoney(?V1Money refundedMoney): void |
| `refundedProcessingFeeMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedProcessingFeeMoney(): ?V1Money | setRefundedProcessingFeeMoney(?V1Money refundedProcessingFeeMoney): void |
| `refundedTaxMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedTaxMoney(): ?V1Money | setRefundedTaxMoney(?V1Money refundedTaxMoney): void |
| `refundedAdditiveTaxMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedAdditiveTaxMoney(): ?V1Money | setRefundedAdditiveTaxMoney(?V1Money refundedAdditiveTaxMoney): void |
| `refundedAdditiveTax` | [`?(V1PaymentTax[])`](../../doc/models/v1-payment-tax.md) | Optional | All of the additive taxes associated with the refund. | getRefundedAdditiveTax(): ?array | setRefundedAdditiveTax(?array refundedAdditiveTax): void |
| `refundedInclusiveTaxMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedInclusiveTaxMoney(): ?V1Money | setRefundedInclusiveTaxMoney(?V1Money refundedInclusiveTaxMoney): void |
| `refundedInclusiveTax` | [`?(V1PaymentTax[])`](../../doc/models/v1-payment-tax.md) | Optional | All of the inclusive taxes associated with the refund. | getRefundedInclusiveTax(): ?array | setRefundedInclusiveTax(?array refundedInclusiveTax): void |
| `refundedTipMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedTipMoney(): ?V1Money | setRefundedTipMoney(?V1Money refundedTipMoney): void |
| `refundedDiscountMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedDiscountMoney(): ?V1Money | setRefundedDiscountMoney(?V1Money refundedDiscountMoney): void |
| `refundedSurchargeMoney` | [`?V1Money`](../../doc/models/v1-money.md) | Optional | - | getRefundedSurchargeMoney(): ?V1Money | setRefundedSurchargeMoney(?V1Money refundedSurchargeMoney): void |
| `refundedSurcharges` | [`?(V1PaymentSurcharge[])`](../../doc/models/v1-payment-surcharge.md) | Optional | A list of all surcharges associated with the refund. | getRefundedSurcharges(): ?array | setRefundedSurcharges(?array refundedSurcharges): void |
| `createdAt` | `?string` | Optional | The time when the merchant initiated the refund for Square to process, in ISO 8601 format. | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `processedAt` | `?string` | Optional | The time when Square processed the refund on behalf of the merchant, in ISO 8601 format. | getProcessedAt(): ?string | setProcessedAt(?string processedAt): void |
| `paymentId` | `?string` | Optional | A Square-issued ID associated with the refund. For single-tender refunds, payment_id is the ID of the original payment ID. For split-tender refunds, payment_id is the ID of the original tender. For exchange-based refunds (is_exchange == true), payment_id is the ID of the original payment ID even if the payment includes other tenders. | getPaymentId(): ?string | setPaymentId(?string paymentId): void |
| `merchantId` | `?string` | Optional | - | getMerchantId(): ?string | setMerchantId(?string merchantId): void |
| `isExchange` | `?bool` | Optional | Indicates whether or not the refund is associated with an exchange. If is_exchange is true, the refund reflects the value of goods returned in the exchange not the total money refunded. | getIsExchange(): ?bool | setIsExchange(?bool isExchange): void |

## Example (as JSON)

```json
{
  "type": "FULL",
  "reason": "reason4",
  "refunded_money": {
    "amount": 214,
    "currency_code": "CHW"
  },
  "refunded_processing_fee_money": {
    "amount": 0,
    "currency_code": "LBP"
  },
  "refunded_tax_money": {
    "amount": 148,
    "currency_code": "BAM"
  },
  "refunded_additive_tax_money": {
    "amount": 234,
    "currency_code": "BZD"
  },
  "refunded_additive_tax": [
    {
      "errors": [
        {
          "category": "API_ERROR",
          "code": "MAP_KEY_LENGTH_TOO_SHORT",
          "detail": "detail1",
          "field": "field9"
        },
        {
          "category": "AUTHENTICATION_ERROR",
          "code": "MAP_KEY_LENGTH_TOO_LONG",
          "detail": "detail2",
          "field": "field0"
        },
        {
          "category": "INVALID_REQUEST_ERROR",
          "code": "CUSTOMER_MISSING_NAME",
          "detail": "detail3",
          "field": "field1"
        }
      ],
      "name": "name0",
      "applied_money": {
        "amount": 170,
        "currency_code": "OMR"
      },
      "rate": "rate0",
      "inclusion_type": "ADDITIVE",
      "fee_id": "fee_id8"
    }
  ],
  "refunded_inclusive_tax_money": {
    "amount": 212,
    "currency_code": "JPY"
  },
  "refunded_inclusive_tax": [
    {
      "errors": [
        {
          "category": "MERCHANT_SUBSCRIPTION_ERROR",
          "code": "INVALID_TIME",
          "detail": "detail3",
          "field": "field1"
        },
        {
          "category": "API_ERROR",
          "code": "INVALID_TIME_RANGE",
          "detail": "detail4",
          "field": "field2"
        },
        {
          "category": "AUTHENTICATION_ERROR",
          "code": "INVALID_VALUE",
          "detail": "detail5",
          "field": "field3"
        }
      ],
      "name": "name2",
      "applied_money": {
        "amount": 188,
        "currency_code": "MYR"
      },
      "rate": "rate8",
      "inclusion_type": "ADDITIVE",
      "fee_id": "fee_id0"
    }
  ],
  "refunded_tip_money": {
    "amount": 198,
    "currency_code": "XCD"
  },
  "refunded_discount_money": {
    "amount": 120,
    "currency_code": "XBC"
  },
  "refunded_surcharge_money": {
    "amount": 194,
    "currency_code": "THB"
  },
  "refunded_surcharges": [
    {
      "name": "name4",
      "applied_money": {
        "amount": 200,
        "currency_code": "EUR"
      },
      "rate": "rate6",
      "amount_money": {
        "amount": 182,
        "currency_code": "QAR"
      },
      "type": "CUSTOM",
      "taxable": false,
      "taxes": [
        {
          "errors": [
            {
              "category": "API_ERROR",
              "code": "RESERVATION_DECLINED",
              "detail": "detail0",
              "field": "field8"
            }
          ],
          "name": "name9",
          "applied_money": {},
          "rate": "rate1",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id7"
        },
        {
          "errors": [
            {
              "category": "MERCHANT_SUBSCRIPTION_ERROR",
              "code": "ALLOWABLE_PIN_TRIES_EXCEEDED",
              "detail": "detail9",
              "field": "field7"
            },
            {
              "category": "API_ERROR",
              "code": "RESERVATION_DECLINED",
              "detail": "detail0",
              "field": "field8"
            },
            {
              "category": "AUTHENTICATION_ERROR",
              "code": "UNKNOWN_BODY_PARAMETER",
              "detail": "detail1",
              "field": "field9"
            }
          ],
          "name": "name8",
          "applied_money": {},
          "rate": "rate2",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id6"
        }
      ],
      "surcharge_id": "surcharge_id0"
    }
  ],
  "created_at": "created_at2",
  "processed_at": "processed_at6",
  "payment_id": "payment_id0",
  "merchant_id": "merchant_id0",
  "is_exchange": false
}
```

