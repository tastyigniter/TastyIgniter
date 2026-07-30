
# V1 List Refunds Response

## Structure

`V1ListRefundsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `items` | [`?(V1Refund[])`](../../doc/models/v1-refund.md) | Optional | - | getItems(): ?array | setItems(?array items): void |

## Example (as JSON)

```json
{
  "items": [
    {
      "type": "PARTIAL",
      "reason": "reason7",
      "refunded_money": {
        "amount": 17,
        "currency_code": "XTS"
      },
      "refunded_processing_fee_money": {
        "amount": 59,
        "currency_code": "GYD"
      },
      "refunded_tax_money": {},
      "refunded_additive_tax_money": {},
      "refunded_additive_tax": [
        {
          "errors": [
            {
              "category": "REFUND_ERROR",
              "code": "INVALID_TIME",
              "detail": "detail8",
              "field": "field6"
            },
            {
              "category": "MERCHANT_SUBSCRIPTION_ERROR",
              "code": "INVALID_TIME_RANGE",
              "detail": "detail9",
              "field": "field7"
            },
            {
              "category": "API_ERROR",
              "code": "INVALID_VALUE",
              "detail": "detail0",
              "field": "field8"
            }
          ],
          "name": "name7",
          "applied_money": {},
          "rate": "rate3",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id5"
        }
      ],
      "refunded_inclusive_tax_money": {},
      "refunded_inclusive_tax": [
        {}
      ],
      "refunded_tip_money": {},
      "refunded_discount_money": {},
      "refunded_surcharge_money": {},
      "refunded_surcharges": [
        {
          "name": "name3",
          "applied_money": {},
          "rate": "rate7",
          "amount_money": {},
          "type": "CUSTOM",
          "taxable": true,
          "taxes": [
            {},
            {}
          ],
          "surcharge_id": "surcharge_id1"
        }
      ],
      "created_at": "created_at5",
      "processed_at": "processed_at9",
      "payment_id": "payment_id7",
      "merchant_id": "merchant_id7",
      "is_exchange": true
    },
    {
      "type": "FULL",
      "reason": "reason6",
      "refunded_money": {
        "amount": 18,
        "currency_code": "XXX"
      },
      "refunded_processing_fee_money": {
        "amount": 60,
        "currency_code": "HKD"
      },
      "refunded_tax_money": {},
      "refunded_additive_tax_money": {},
      "refunded_additive_tax": [
        {
          "errors": [
            {
              "category": "MERCHANT_SUBSCRIPTION_ERROR",
              "code": "INVALID_TIME_RANGE",
              "detail": "detail9",
              "field": "field7"
            }
          ],
          "name": "name8",
          "applied_money": {},
          "rate": "rate2",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id6"
        },
        {
          "errors": [
            {
              "category": "API_ERROR",
              "code": "INVALID_VALUE",
              "detail": "detail0",
              "field": "field8"
            },
            {
              "category": "AUTHENTICATION_ERROR",
              "code": "INVALID_CURSOR",
              "detail": "detail1",
              "field": "field9"
            }
          ],
          "name": "name9",
          "applied_money": {},
          "rate": "rate1",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id7"
        }
      ],
      "refunded_inclusive_tax_money": {},
      "refunded_inclusive_tax": [
        {},
        {}
      ],
      "refunded_tip_money": {},
      "refunded_discount_money": {},
      "refunded_surcharge_money": {},
      "refunded_surcharges": [
        {
          "name": "name4",
          "applied_money": {},
          "rate": "rate6",
          "amount_money": {},
          "type": "AUTO_GRATUITY",
          "taxable": false,
          "taxes": [
            {}
          ],
          "surcharge_id": "surcharge_id0"
        },
        {
          "name": "name3",
          "applied_money": {},
          "rate": "rate7",
          "amount_money": {},
          "type": "CUSTOM",
          "taxable": true,
          "taxes": [
            {},
            {}
          ],
          "surcharge_id": "surcharge_id1"
        },
        {
          "name": "name2",
          "applied_money": {},
          "rate": "rate8",
          "amount_money": {},
          "type": "UNKNOWN",
          "taxable": false,
          "taxes": [
            {},
            {},
            {}
          ],
          "surcharge_id": "surcharge_id2"
        }
      ],
      "created_at": "created_at6",
      "processed_at": "processed_at8",
      "payment_id": "payment_id8",
      "merchant_id": "merchant_id8",
      "is_exchange": false
    }
  ]
}
```

