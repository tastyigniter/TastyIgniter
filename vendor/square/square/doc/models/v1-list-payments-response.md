
# V1 List Payments Response

## Structure

`V1ListPaymentsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `items` | [`?(V1Payment[])`](../../doc/models/v1-payment.md) | Optional | - | getItems(): ?array | setItems(?array items): void |

## Example (as JSON)

```json
{
  "items": [
    {
      "id": "id7",
      "merchant_id": "merchant_id7",
      "created_at": "created_at5",
      "creator_id": "creator_id7",
      "device": {
        "id": "id3",
        "name": "name3"
      },
      "payment_url": "payment_url1",
      "receipt_url": "receipt_url1",
      "inclusive_tax_money": {
        "amount": 43,
        "currency_code": "NPR"
      },
      "additive_tax_money": {
        "amount": 49,
        "currency_code": "LTL"
      },
      "tax_money": {},
      "tip_money": {},
      "discount_money": {},
      "total_collected_money": {},
      "processing_fee_money": {},
      "net_total_money": {},
      "refunded_money": {},
      "swedish_rounding_money": {},
      "gross_sales_money": {},
      "net_sales_money": {},
      "inclusive_tax": [
        {
          "errors": [
            {
              "category": "MERCHANT_SUBSCRIPTION_ERROR",
              "code": "UNSUPPORTED_SOURCE_TYPE",
              "detail": "detail5",
              "field": "field3"
            },
            {
              "category": "API_ERROR",
              "code": "CARD_MISMATCH",
              "detail": "detail6",
              "field": "field4"
            },
            {
              "category": "AUTHENTICATION_ERROR",
              "code": "CARD_DECLINED",
              "detail": "detail7",
              "field": "field5"
            }
          ],
          "name": "name4",
          "applied_money": {},
          "rate": "rate6",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id2"
        },
        {
          "errors": [
            {
              "category": "API_ERROR",
              "code": "CARD_MISMATCH",
              "detail": "detail6",
              "field": "field4"
            }
          ],
          "name": "name5",
          "applied_money": {},
          "rate": "rate5",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id3"
        }
      ],
      "additive_tax": [
        {},
        {}
      ],
      "tender": [
        {
          "id": "id1",
          "type": "NO_SALE",
          "name": "name1",
          "employee_id": "employee_id1",
          "receipt_url": "receipt_url3",
          "card_brand": "JCB",
          "pan_suffix": "pan_suffix1",
          "entry_method": "SCANNED",
          "payment_note": "payment_note9",
          "total_money": {},
          "tendered_money": {},
          "tendered_at": "tendered_at5",
          "settled_at": "settled_at7",
          "change_back_money": {},
          "refunded_money": {},
          "is_exchange": true
        }
      ],
      "refunds": [
        {
          "type": "PARTIAL",
          "reason": "reason7",
          "refunded_money": {},
          "refunded_processing_fee_money": {},
          "refunded_tax_money": {},
          "refunded_additive_tax_money": {},
          "refunded_additive_tax": [
            {},
            {}
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
              "name": "name7",
              "applied_money": {},
              "rate": "rate3",
              "amount_money": {},
              "type": "UNKNOWN",
              "taxable": true,
              "taxes": [
                {},
                {},
                {}
              ],
              "surcharge_id": "surcharge_id7"
            },
            {
              "name": "name8",
              "applied_money": {},
              "rate": "rate2",
              "amount_money": {},
              "type": "CUSTOM",
              "taxable": false,
              "taxes": [
                {},
                {}
              ],
              "surcharge_id": "surcharge_id6"
            },
            {
              "name": "name9",
              "applied_money": {},
              "rate": "rate1",
              "amount_money": {},
              "type": "AUTO_GRATUITY",
              "taxable": true,
              "taxes": [
                {}
              ],
              "surcharge_id": "surcharge_id5"
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
          "refunded_money": {},
          "refunded_processing_fee_money": {},
          "refunded_tax_money": {},
          "refunded_additive_tax_money": {},
          "refunded_additive_tax": [
            {},
            {},
            {}
          ],
          "refunded_inclusive_tax_money": {},
          "refunded_inclusive_tax": [
            {},
            {},
            {}
          ],
          "refunded_tip_money": {},
          "refunded_discount_money": {},
          "refunded_surcharge_money": {},
          "refunded_surcharges": [
            {
              "name": "name6",
              "applied_money": {},
              "rate": "rate4",
              "amount_money": {},
              "type": "AUTO_GRATUITY",
              "taxable": false,
              "taxes": [
                {}
              ],
              "surcharge_id": "surcharge_id8"
            },
            {
              "name": "name7",
              "applied_money": {},
              "rate": "rate3",
              "amount_money": {},
              "type": "UNKNOWN",
              "taxable": true,
              "taxes": [
                {},
                {},
                {}
              ],
              "surcharge_id": "surcharge_id7"
            }
          ],
          "created_at": "created_at4",
          "processed_at": "processed_at8",
          "payment_id": "payment_id8",
          "merchant_id": "merchant_id8",
          "is_exchange": false
        },
        {
          "type": "PARTIAL",
          "reason": "reason5",
          "refunded_money": {},
          "refunded_processing_fee_money": {},
          "refunded_tax_money": {},
          "refunded_additive_tax_money": {},
          "refunded_additive_tax": [
            {}
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
              "name": "name5",
              "applied_money": {},
              "rate": "rate5",
              "amount_money": {},
              "type": "CUSTOM",
              "taxable": true,
              "taxes": [
                {},
                {}
              ],
              "surcharge_id": "surcharge_id9"
            }
          ],
          "created_at": "created_at3",
          "processed_at": "processed_at7",
          "payment_id": "payment_id9",
          "merchant_id": "merchant_id9",
          "is_exchange": true
        }
      ],
      "itemizations": [
        {
          "name": "name3",
          "quantity": 137.09,
          "itemization_type": "CUSTOM_AMOUNT",
          "item_detail": {
            "category_name": "category_name7",
            "sku": "sku3",
            "item_id": "item_id9",
            "item_variation_id": "item_variation_id5"
          },
          "notes": "notes3",
          "item_variation_name": "item_variation_name1",
          "total_money": {},
          "single_quantity_money": {},
          "gross_sales_money": {},
          "discount_money": {},
          "net_sales_money": {},
          "taxes": [
            {},
            {}
          ],
          "discounts": [
            {
              "name": "name4",
              "applied_money": {},
              "discount_id": "discount_id2"
            },
            {
              "name": "name5",
              "applied_money": {},
              "discount_id": "discount_id3"
            },
            {
              "name": "name6",
              "applied_money": {},
              "discount_id": "discount_id4"
            }
          ],
          "modifiers": [
            {
              "name": "name4",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id0"
            },
            {
              "name": "name5",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id1"
            }
          ]
        },
        {
          "name": "name4",
          "quantity": 137.1,
          "itemization_type": "GIFT_CARD_ACTIVATION",
          "item_detail": {
            "category_name": "category_name6",
            "sku": "sku2",
            "item_id": "item_id8",
            "item_variation_id": "item_variation_id6"
          },
          "notes": "notes4",
          "item_variation_name": "item_variation_name2",
          "total_money": {},
          "single_quantity_money": {},
          "gross_sales_money": {},
          "discount_money": {},
          "net_sales_money": {},
          "taxes": [
            {}
          ],
          "discounts": [
            {
              "name": "name5",
              "applied_money": {},
              "discount_id": "discount_id3"
            }
          ],
          "modifiers": [
            {
              "name": "name5",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id1"
            },
            {
              "name": "name6",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id2"
            },
            {
              "name": "name7",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id3"
            }
          ]
        }
      ],
      "surcharge_money": {},
      "surcharges": [
        {},
        {},
        {}
      ],
      "is_partial": true
    },
    {
      "id": "id8",
      "merchant_id": "merchant_id8",
      "created_at": "created_at6",
      "creator_id": "creator_id8",
      "device": {
        "id": "id4",
        "name": "name4"
      },
      "payment_url": "payment_url2",
      "receipt_url": "receipt_url0",
      "inclusive_tax_money": {
        "amount": 44,
        "currency_code": "NZD"
      },
      "additive_tax_money": {
        "amount": 48,
        "currency_code": "LSL"
      },
      "tax_money": {},
      "tip_money": {},
      "discount_money": {},
      "total_collected_money": {},
      "processing_fee_money": {},
      "net_total_money": {},
      "refunded_money": {},
      "swedish_rounding_money": {},
      "gross_sales_money": {},
      "net_sales_money": {},
      "inclusive_tax": [
        {
          "errors": [
            {
              "category": "API_ERROR",
              "code": "CARD_MISMATCH",
              "detail": "detail6",
              "field": "field4"
            }
          ],
          "name": "name5",
          "applied_money": {},
          "rate": "rate5",
          "inclusion_type": "INCLUSIVE",
          "fee_id": "fee_id3"
        },
        {
          "errors": [
            {
              "category": "AUTHENTICATION_ERROR",
              "code": "CARD_DECLINED",
              "detail": "detail7",
              "field": "field5"
            },
            {
              "category": "INVALID_REQUEST_ERROR",
              "code": "VERIFY_CVV_FAILURE",
              "detail": "detail8",
              "field": "field6"
            }
          ],
          "name": "name6",
          "applied_money": {},
          "rate": "rate4",
          "inclusion_type": "ADDITIVE",
          "fee_id": "fee_id4"
        },
        {
          "errors": [
            {
              "category": "INVALID_REQUEST_ERROR",
              "code": "VERIFY_CVV_FAILURE",
              "detail": "detail8",
              "field": "field6"
            },
            {
              "category": "RATE_LIMIT_ERROR",
              "code": "VERIFY_AVS_FAILURE",
              "detail": "detail9",
              "field": "field7"
            },
            {
              "category": "PAYMENT_METHOD_ERROR",
              "code": "CARD_DECLINED_CALL_ISSUER",
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
      "additive_tax": [
        {},
        {},
        {}
      ],
      "tender": [
        {
          "id": "id2",
          "type": "SQUARE_WALLET",
          "name": "name2",
          "employee_id": "employee_id2",
          "receipt_url": "receipt_url4",
          "card_brand": "CHINA_UNIONPAY",
          "pan_suffix": "pan_suffix2",
          "entry_method": "SQUARE_CASH",
          "payment_note": "payment_note0",
          "total_money": {},
          "tendered_money": {},
          "tendered_at": "tendered_at6",
          "settled_at": "settled_at8",
          "change_back_money": {},
          "refunded_money": {},
          "is_exchange": false
        },
        {
          "id": "id3",
          "type": "SQUARE_GIFT_CARD",
          "name": "name3",
          "employee_id": "employee_id3",
          "receipt_url": "receipt_url5",
          "card_brand": "SQUARE_GIFT_CARD",
          "pan_suffix": "pan_suffix3",
          "entry_method": "SQUARE_WALLET",
          "payment_note": "payment_note1",
          "total_money": {},
          "tendered_money": {},
          "tendered_at": "tendered_at7",
          "settled_at": "settled_at9",
          "change_back_money": {},
          "refunded_money": {},
          "is_exchange": true
        }
      ],
      "refunds": [
        {
          "type": "FULL",
          "reason": "reason8",
          "refunded_money": {},
          "refunded_processing_fee_money": {},
          "refunded_tax_money": {},
          "refunded_additive_tax_money": {},
          "refunded_additive_tax": [
            {}
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
              "name": "name8",
              "applied_money": {},
              "rate": "rate2",
              "amount_money": {},
              "type": "CUSTOM",
              "taxable": false,
              "taxes": [
                {},
                {}
              ],
              "surcharge_id": "surcharge_id6"
            }
          ],
          "created_at": "created_at6",
          "processed_at": "processed_at0",
          "payment_id": "payment_id6",
          "merchant_id": "merchant_id6",
          "is_exchange": false
        },
        {
          "type": "PARTIAL",
          "reason": "reason7",
          "refunded_money": {},
          "refunded_processing_fee_money": {},
          "refunded_tax_money": {},
          "refunded_additive_tax_money": {},
          "refunded_additive_tax": [
            {},
            {}
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
              "name": "name7",
              "applied_money": {},
              "rate": "rate3",
              "amount_money": {},
              "type": "UNKNOWN",
              "taxable": true,
              "taxes": [
                {},
                {},
                {}
              ],
              "surcharge_id": "surcharge_id7"
            },
            {
              "name": "name8",
              "applied_money": {},
              "rate": "rate2",
              "amount_money": {},
              "type": "CUSTOM",
              "taxable": false,
              "taxes": [
                {},
                {}
              ],
              "surcharge_id": "surcharge_id6"
            },
            {
              "name": "name9",
              "applied_money": {},
              "rate": "rate1",
              "amount_money": {},
              "type": "AUTO_GRATUITY",
              "taxable": true,
              "taxes": [
                {}
              ],
              "surcharge_id": "surcharge_id5"
            }
          ],
          "created_at": "created_at5",
          "processed_at": "processed_at9",
          "payment_id": "payment_id7",
          "merchant_id": "merchant_id7",
          "is_exchange": true
        }
      ],
      "itemizations": [
        {
          "name": "name4",
          "quantity": 137.1,
          "itemization_type": "GIFT_CARD_ACTIVATION",
          "item_detail": {
            "category_name": "category_name6",
            "sku": "sku2",
            "item_id": "item_id8",
            "item_variation_id": "item_variation_id6"
          },
          "notes": "notes4",
          "item_variation_name": "item_variation_name2",
          "total_money": {},
          "single_quantity_money": {},
          "gross_sales_money": {},
          "discount_money": {},
          "net_sales_money": {},
          "taxes": [
            {}
          ],
          "discounts": [
            {
              "name": "name5",
              "applied_money": {},
              "discount_id": "discount_id3"
            }
          ],
          "modifiers": [
            {
              "name": "name5",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id1"
            },
            {
              "name": "name6",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id2"
            },
            {
              "name": "name7",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id3"
            }
          ]
        },
        {
          "name": "name5",
          "quantity": 137.11,
          "itemization_type": "GIFT_CARD_RELOAD",
          "item_detail": {
            "category_name": "category_name5",
            "sku": "sku1",
            "item_id": "item_id7",
            "item_variation_id": "item_variation_id7"
          },
          "notes": "notes5",
          "item_variation_name": "item_variation_name3",
          "total_money": {},
          "single_quantity_money": {},
          "gross_sales_money": {},
          "discount_money": {},
          "net_sales_money": {},
          "taxes": [
            {},
            {},
            {}
          ],
          "discounts": [
            {
              "name": "name6",
              "applied_money": {},
              "discount_id": "discount_id4"
            },
            {
              "name": "name7",
              "applied_money": {},
              "discount_id": "discount_id5"
            }
          ],
          "modifiers": [
            {
              "name": "name6",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id2"
            }
          ]
        },
        {
          "name": "name6",
          "quantity": 137.12,
          "itemization_type": "GIFT_CARD_UNKNOWN",
          "item_detail": {
            "category_name": "category_name4",
            "sku": "sku0",
            "item_id": "item_id6",
            "item_variation_id": "item_variation_id8"
          },
          "notes": "notes6",
          "item_variation_name": "item_variation_name4",
          "total_money": {},
          "single_quantity_money": {},
          "gross_sales_money": {},
          "discount_money": {},
          "net_sales_money": {},
          "taxes": [
            {},
            {}
          ],
          "discounts": [
            {
              "name": "name7",
              "applied_money": {},
              "discount_id": "discount_id5"
            },
            {
              "name": "name8",
              "applied_money": {},
              "discount_id": "discount_id6"
            },
            {
              "name": "name9",
              "applied_money": {},
              "discount_id": "discount_id7"
            }
          ],
          "modifiers": [
            {
              "name": "name7",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id3"
            },
            {
              "name": "name8",
              "applied_money": {},
              "modifier_option_id": "modifier_option_id4"
            }
          ]
        }
      ],
      "surcharge_money": {},
      "surcharges": [
        {}
      ],
      "is_partial": false
    }
  ]
}
```

