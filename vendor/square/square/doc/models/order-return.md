
# Order Return

The set of line items, service charges, taxes, discounts, tips, and other items being returned in an order.

## Structure

`OrderReturn`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `uid` | `?string` | Optional | A unique ID that identifies the return only within this order.<br>**Constraints**: *Maximum Length*: `60` | getUid(): ?string | setUid(?string uid): void |
| `sourceOrderId` | `?string` | Optional | An order that contains the original sale of these return line items. This is unset<br>for unlinked returns. | getSourceOrderId(): ?string | setSourceOrderId(?string sourceOrderId): void |
| `returnLineItems` | [`?(OrderReturnLineItem[])`](../../doc/models/order-return-line-item.md) | Optional | A collection of line items that are being returned. | getReturnLineItems(): ?array | setReturnLineItems(?array returnLineItems): void |
| `returnServiceCharges` | [`?(OrderReturnServiceCharge[])`](../../doc/models/order-return-service-charge.md) | Optional | A collection of service charges that are being returned. | getReturnServiceCharges(): ?array | setReturnServiceCharges(?array returnServiceCharges): void |
| `returnTaxes` | [`?(OrderReturnTax[])`](../../doc/models/order-return-tax.md) | Optional | A collection of references to taxes being returned for an order, including the total<br>applied tax amount to be returned. The taxes must reference a top-level tax ID from the source<br>order. | getReturnTaxes(): ?array | setReturnTaxes(?array returnTaxes): void |
| `returnDiscounts` | [`?(OrderReturnDiscount[])`](../../doc/models/order-return-discount.md) | Optional | A collection of references to discounts being returned for an order, including the total<br>applied discount amount to be returned. The discounts must reference a top-level discount ID<br>from the source order. | getReturnDiscounts(): ?array | setReturnDiscounts(?array returnDiscounts): void |
| `roundingAdjustment` | [`?OrderRoundingAdjustment`](../../doc/models/order-rounding-adjustment.md) | Optional | A rounding adjustment of the money being returned. Commonly used to apply cash rounding<br>when the minimum unit of the account is smaller than the lowest physical denomination of the currency. | getRoundingAdjustment(): ?OrderRoundingAdjustment | setRoundingAdjustment(?OrderRoundingAdjustment roundingAdjustment): void |
| `returnAmounts` | [`?OrderMoneyAmounts`](../../doc/models/order-money-amounts.md) | Optional | A collection of various money amounts. | getReturnAmounts(): ?OrderMoneyAmounts | setReturnAmounts(?OrderMoneyAmounts returnAmounts): void |

## Example (as JSON)

```json
{
  "uid": "uid0",
  "source_order_id": "source_order_id2",
  "return_line_items": [
    {
      "uid": "uid5",
      "source_line_item_uid": "source_line_item_uid7",
      "name": "name5",
      "quantity": "quantity1",
      "quantity_unit": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name3",
            "abbreviation": "abbreviation5"
          },
          "area_unit": "METRIC_SQUARE_CENTIMETER",
          "length_unit": "IMPERIAL_MILE",
          "volume_unit": "IMPERIAL_CUBIC_FOOT",
          "weight_unit": "METRIC_KILOGRAM",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_SECOND",
          "type": "TYPE_GENERIC"
        },
        "precision": 73,
        "catalog_object_id": "catalog_object_id5",
        "catalog_version": 249
      },
      "note": "note9",
      "catalog_object_id": "catalog_object_id1",
      "catalog_version": 107,
      "variation_name": "variation_name5",
      "item_type": "CUSTOM_AMOUNT",
      "return_modifiers": [
        {
          "uid": "uid6",
          "source_modifier_uid": "source_modifier_uid0",
          "catalog_object_id": "catalog_object_id0",
          "catalog_version": 92,
          "name": "name6",
          "base_price_money": {
            "amount": 148,
            "currency": "STD"
          },
          "total_price_money": {
            "amount": 238,
            "currency": "CHE"
          },
          "quantity": "quantity2"
        },
        {
          "uid": "uid7",
          "source_modifier_uid": "source_modifier_uid9",
          "catalog_object_id": "catalog_object_id9",
          "catalog_version": 91,
          "name": "name7",
          "base_price_money": {
            "amount": 149,
            "currency": "SVC"
          },
          "total_price_money": {
            "amount": 239,
            "currency": "CHF"
          },
          "quantity": "quantity3"
        },
        {
          "uid": "uid8",
          "source_modifier_uid": "source_modifier_uid8",
          "catalog_object_id": "catalog_object_id8",
          "catalog_version": 90,
          "name": "name8",
          "base_price_money": {
            "amount": 150,
            "currency": "SYP"
          },
          "total_price_money": {
            "amount": 240,
            "currency": "CHW"
          },
          "quantity": "quantity4"
        }
      ],
      "applied_taxes": [
        {
          "uid": "uid5",
          "tax_uid": "tax_uid9",
          "applied_money": {}
        },
        {
          "uid": "uid6",
          "tax_uid": "tax_uid8",
          "applied_money": {}
        },
        {
          "uid": "uid7",
          "tax_uid": "tax_uid7",
          "applied_money": {}
        }
      ],
      "applied_discounts": [
        {
          "uid": "uid9",
          "discount_uid": "discount_uid5",
          "applied_money": {}
        }
      ],
      "base_price_money": {},
      "variation_total_price_money": {},
      "gross_return_money": {},
      "total_tax_money": {},
      "total_discount_money": {},
      "total_money": {},
      "applied_service_charges": [
        {
          "uid": "uid6",
          "service_charge_uid": "service_charge_uid6",
          "applied_money": {}
        },
        {
          "uid": "uid7",
          "service_charge_uid": "service_charge_uid7",
          "applied_money": {}
        }
      ],
      "total_service_charge_money": {}
    },
    {
      "uid": "uid6",
      "source_line_item_uid": "source_line_item_uid6",
      "name": "name6",
      "quantity": "quantity2",
      "quantity_unit": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name4",
            "abbreviation": "abbreviation6"
          },
          "area_unit": "METRIC_SQUARE_METER",
          "length_unit": "IMPERIAL_YARD",
          "volume_unit": "IMPERIAL_CUBIC_YARD",
          "weight_unit": "METRIC_GRAM",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_MILLISECOND",
          "type": "TYPE_WEIGHT"
        },
        "precision": 74,
        "catalog_object_id": "catalog_object_id4",
        "catalog_version": 248
      },
      "note": "note8",
      "catalog_object_id": "catalog_object_id0",
      "catalog_version": 106,
      "variation_name": "variation_name6",
      "item_type": "GIFT_CARD",
      "return_modifiers": [
        {
          "uid": "uid5",
          "source_modifier_uid": "source_modifier_uid1",
          "catalog_object_id": "catalog_object_id1",
          "catalog_version": 93,
          "name": "name5",
          "base_price_money": {
            "amount": 147,
            "currency": "SSP"
          },
          "total_price_money": {
            "amount": 237,
            "currency": "CDF"
          },
          "quantity": "quantity1"
        },
        {
          "uid": "uid6",
          "source_modifier_uid": "source_modifier_uid0",
          "catalog_object_id": "catalog_object_id0",
          "catalog_version": 92,
          "name": "name6",
          "base_price_money": {
            "amount": 148,
            "currency": "STD"
          },
          "total_price_money": {
            "amount": 238,
            "currency": "CHE"
          },
          "quantity": "quantity2"
        }
      ],
      "applied_taxes": [
        {
          "uid": "uid6",
          "tax_uid": "tax_uid8",
          "applied_money": {}
        }
      ],
      "applied_discounts": [
        {
          "uid": "uid0",
          "discount_uid": "discount_uid4",
          "applied_money": {}
        },
        {
          "uid": "uid1",
          "discount_uid": "discount_uid3",
          "applied_money": {}
        }
      ],
      "base_price_money": {},
      "variation_total_price_money": {},
      "gross_return_money": {},
      "total_tax_money": {},
      "total_discount_money": {},
      "total_money": {},
      "applied_service_charges": [
        {
          "uid": "uid5",
          "service_charge_uid": "service_charge_uid5",
          "applied_money": {}
        }
      ],
      "total_service_charge_money": {}
    },
    {
      "uid": "uid7",
      "source_line_item_uid": "source_line_item_uid5",
      "name": "name7",
      "quantity": "quantity3",
      "quantity_unit": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name5",
            "abbreviation": "abbreviation7"
          },
          "area_unit": "METRIC_SQUARE_KILOMETER",
          "length_unit": "IMPERIAL_FOOT",
          "volume_unit": "METRIC_MILLILITER",
          "weight_unit": "METRIC_MILLIGRAM",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_DAY",
          "type": "TYPE_VOLUME"
        },
        "precision": 75,
        "catalog_object_id": "catalog_object_id3",
        "catalog_version": 247
      },
      "note": "note7",
      "catalog_object_id": "catalog_object_id9",
      "catalog_version": 105,
      "variation_name": "variation_name7",
      "item_type": "ITEM",
      "return_modifiers": [
        {
          "uid": "uid4",
          "source_modifier_uid": "source_modifier_uid2",
          "catalog_object_id": "catalog_object_id2",
          "catalog_version": 94,
          "name": "name4",
          "base_price_money": {
            "amount": 146,
            "currency": "SRD"
          },
          "total_price_money": {
            "amount": 236,
            "currency": "CAD"
          },
          "quantity": "quantity0"
        }
      ],
      "applied_taxes": [
        {
          "uid": "uid7",
          "tax_uid": "tax_uid7",
          "applied_money": {}
        },
        {
          "uid": "uid8",
          "tax_uid": "tax_uid6",
          "applied_money": {}
        }
      ],
      "applied_discounts": [
        {
          "uid": "uid1",
          "discount_uid": "discount_uid3",
          "applied_money": {}
        },
        {
          "uid": "uid2",
          "discount_uid": "discount_uid2",
          "applied_money": {}
        },
        {
          "uid": "uid3",
          "discount_uid": "discount_uid1",
          "applied_money": {}
        }
      ],
      "base_price_money": {},
      "variation_total_price_money": {},
      "gross_return_money": {},
      "total_tax_money": {},
      "total_discount_money": {},
      "total_money": {},
      "applied_service_charges": [
        {
          "uid": "uid4",
          "service_charge_uid": "service_charge_uid4",
          "applied_money": {}
        },
        {
          "uid": "uid5",
          "service_charge_uid": "service_charge_uid5",
          "applied_money": {}
        },
        {
          "uid": "uid6",
          "service_charge_uid": "service_charge_uid6",
          "applied_money": {}
        }
      ],
      "total_service_charge_money": {}
    }
  ],
  "return_service_charges": [
    {
      "uid": "uid3",
      "source_service_charge_uid": "source_service_charge_uid3",
      "name": "name3",
      "catalog_object_id": "catalog_object_id3",
      "catalog_version": 197,
      "percentage": "percentage1",
      "amount_money": {
        "amount": 115,
        "currency": "BDT"
      },
      "applied_money": {
        "amount": 11,
        "currency": "CHW"
      },
      "total_money": {},
      "total_tax_money": {},
      "calculation_phase": "APPORTIONED_AMOUNT_PHASE",
      "taxable": true,
      "applied_taxes": [
        {
          "uid": "uid3",
          "tax_uid": "tax_uid1",
          "applied_money": {}
        }
      ],
      "treatment_type": "APPORTIONED_TREATMENT",
      "scope": "OTHER_SERVICE_CHARGE_SCOPE"
    },
    {
      "uid": "uid4",
      "source_service_charge_uid": "source_service_charge_uid2",
      "name": "name4",
      "catalog_object_id": "catalog_object_id2",
      "catalog_version": 196,
      "percentage": "percentage2",
      "amount_money": {
        "amount": 116,
        "currency": "BGN"
      },
      "applied_money": {
        "amount": 10,
        "currency": "CHF"
      },
      "total_money": {},
      "total_tax_money": {},
      "calculation_phase": "SUBTOTAL_PHASE",
      "taxable": false,
      "applied_taxes": [
        {
          "uid": "uid4",
          "tax_uid": "tax_uid0",
          "applied_money": {}
        },
        {
          "uid": "uid5",
          "tax_uid": "tax_uid9",
          "applied_money": {}
        }
      ],
      "treatment_type": "LINE_ITEM_TREATMENT",
      "scope": "ORDER"
    }
  ],
  "return_taxes": [
    {
      "uid": "uid6",
      "source_tax_uid": "source_tax_uid4",
      "catalog_object_id": "catalog_object_id0",
      "catalog_version": 116,
      "name": "name6",
      "type": "INCLUSIVE",
      "percentage": "percentage4",
      "applied_money": {
        "amount": 186,
        "currency": "UAH"
      },
      "scope": "ORDER"
    }
  ],
  "return_discounts": [
    {
      "uid": "uid6",
      "source_discount_uid": "source_discount_uid6",
      "catalog_object_id": "catalog_object_id0",
      "catalog_version": 58,
      "name": "name6",
      "type": "VARIABLE_AMOUNT",
      "percentage": "percentage4",
      "amount_money": {
        "amount": 254,
        "currency": "GBP"
      },
      "applied_money": {
        "amount": 128,
        "currency": "XPT"
      },
      "scope": "OTHER_DISCOUNT_SCOPE"
    },
    {
      "uid": "uid7",
      "source_discount_uid": "source_discount_uid7",
      "catalog_object_id": "catalog_object_id9",
      "catalog_version": 57,
      "name": "name7",
      "type": "VARIABLE_PERCENTAGE",
      "percentage": "percentage5",
      "amount_money": {
        "amount": 255,
        "currency": "GEL"
      },
      "applied_money": {
        "amount": 127,
        "currency": "XPF"
      },
      "scope": "ORDER"
    }
  ],
  "rounding_adjustment": {
    "uid": "uid2",
    "name": "name2",
    "amount_money": {
      "amount": 142,
      "currency": "TJS"
    }
  },
  "return_amounts": {
    "total_money": {
      "amount": 196,
      "currency": "NIO"
    },
    "tax_money": {
      "amount": 4,
      "currency": "AWG"
    },
    "discount_money": {},
    "tip_money": {},
    "service_charge_money": {}
  }
}
```

