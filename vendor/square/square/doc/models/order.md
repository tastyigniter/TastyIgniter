
# Order

Contains all information related to a single order to process with Square,
including line items that specify the products to purchase. `Order` objects also
include information about any associated tenders, refunds, and returns.

All Connect V2 Transactions have all been converted to Orders including all associated
itemization data.

## Structure

`Order`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `id` | `?string` | Optional | The order's unique ID. | getId(): ?string | setId(?string id): void |
| `locationId` | `string` | Required | The ID of the seller location that this order is associated with.<br>**Constraints**: *Minimum Length*: `1` | getLocationId(): string | setLocationId(string locationId): void |
| `referenceId` | `?string` | Optional | A client-specified ID to associate an entity in another system<br>with this order.<br>**Constraints**: *Maximum Length*: `40` | getReferenceId(): ?string | setReferenceId(?string referenceId): void |
| `source` | [`?OrderSource`](../../doc/models/order-source.md) | Optional | Represents the origination details of an order. | getSource(): ?OrderSource | setSource(?OrderSource source): void |
| `customerId` | `?string` | Optional | The ID of the [customer](../../doc/models/customer.md) associated with the order.<br><br>You should specify a `customer_id` on the order (or the payment) to ensure that transactions<br>are reliably linked to customers. Omitting this field might result in the creation of new<br>[instant profiles](https://developer.squareup.com/docs/customers-api/what-it-does#instant-profiles).<br>**Constraints**: *Maximum Length*: `191` | getCustomerId(): ?string | setCustomerId(?string customerId): void |
| `lineItems` | [`?(OrderLineItem[])`](../../doc/models/order-line-item.md) | Optional | The line items included in the order. | getLineItems(): ?array | setLineItems(?array lineItems): void |
| `taxes` | [`?(OrderLineItemTax[])`](../../doc/models/order-line-item-tax.md) | Optional | The list of all taxes associated with the order.<br><br>Taxes can be scoped to either `ORDER` or `LINE_ITEM`. For taxes with `LINE_ITEM` scope, an<br>`OrderLineItemAppliedTax` must be added to each line item that the tax applies to. For taxes<br>with `ORDER` scope, the server generates an `OrderLineItemAppliedTax` for every line item.<br><br>On reads, each tax in the list includes the total amount of that tax applied to the order.<br><br>__IMPORTANT__: If `LINE_ITEM` scope is set on any taxes in this field, using the deprecated<br>`line_items.taxes` field results in an error. Use `line_items.applied_taxes`<br>instead. | getTaxes(): ?array | setTaxes(?array taxes): void |
| `discounts` | [`?(OrderLineItemDiscount[])`](../../doc/models/order-line-item-discount.md) | Optional | The list of all discounts associated with the order.<br><br>Discounts can be scoped to either `ORDER` or `LINE_ITEM`. For discounts scoped to `LINE_ITEM`,<br>an `OrderLineItemAppliedDiscount` must be added to each line item that the discount applies to.<br>For discounts with `ORDER` scope, the server generates an `OrderLineItemAppliedDiscount`<br>for every line item.<br><br>__IMPORTANT__: If `LINE_ITEM` scope is set on any discounts in this field, using the deprecated<br>`line_items.discounts` field results in an error. Use `line_items.applied_discounts`<br>instead. | getDiscounts(): ?array | setDiscounts(?array discounts): void |
| `serviceCharges` | [`?(OrderServiceCharge[])`](../../doc/models/order-service-charge.md) | Optional | A list of service charges applied to the order. | getServiceCharges(): ?array | setServiceCharges(?array serviceCharges): void |
| `fulfillments` | [`?(Fulfillment[])`](../../doc/models/fulfillment.md) | Optional | Details about order fulfillment.<br><br>Orders can only be created with at most one fulfillment. However, orders returned<br>by the API might contain multiple fulfillments. | getFulfillments(): ?array | setFulfillments(?array fulfillments): void |
| `returns` | [`?(OrderReturn[])`](../../doc/models/order-return.md) | Optional | A collection of items from sale orders being returned in this one. Normally part of an<br>itemized return or exchange. There is exactly one `Return` object per sale `Order` being<br>referenced. | getReturns(): ?array | setReturns(?array returns): void |
| `returnAmounts` | [`?OrderMoneyAmounts`](../../doc/models/order-money-amounts.md) | Optional | A collection of various money amounts. | getReturnAmounts(): ?OrderMoneyAmounts | setReturnAmounts(?OrderMoneyAmounts returnAmounts): void |
| `netAmounts` | [`?OrderMoneyAmounts`](../../doc/models/order-money-amounts.md) | Optional | A collection of various money amounts. | getNetAmounts(): ?OrderMoneyAmounts | setNetAmounts(?OrderMoneyAmounts netAmounts): void |
| `roundingAdjustment` | [`?OrderRoundingAdjustment`](../../doc/models/order-rounding-adjustment.md) | Optional | A rounding adjustment of the money being returned. Commonly used to apply cash rounding<br>when the minimum unit of the account is smaller than the lowest physical denomination of the currency. | getRoundingAdjustment(): ?OrderRoundingAdjustment | setRoundingAdjustment(?OrderRoundingAdjustment roundingAdjustment): void |
| `tenders` | [`?(Tender[])`](../../doc/models/tender.md) | Optional | The tenders that were used to pay for the order. | getTenders(): ?array | setTenders(?array tenders): void |
| `refunds` | [`?(Refund[])`](../../doc/models/refund.md) | Optional | The refunds that are part of this order. | getRefunds(): ?array | setRefunds(?array refunds): void |
| `metadata` | `?array<string,string>` | Optional | Application-defined data attached to this order. Metadata fields are intended<br>to store descriptive references or associations with an entity in another system or store brief<br>information about the object. Square does not process this field; it only stores and returns it<br>in relevant API calls. Do not use metadata to store any sensitive information (such as personally<br>identifiable information or card details).<br><br>Keys written by applications must be 60 characters or less and must be in the character set<br>`[a-zA-Z0-9_-]`. Entries can also include metadata generated by Square. These keys are prefixed<br>with a namespace, separated from the key with a ':' character.<br><br>Values have a maximum length of 255 characters.<br><br>An application can have up to 10 entries per metadata field.<br><br>Entries written by applications are private and can only be read or modified by the same<br>application.<br><br>For more information, see  [Metadata](https://developer.squareup.com/docs/build-basics/metadata). | getMetadata(): ?array | setMetadata(?array metadata): void |
| `createdAt` | `?string` | Optional | The timestamp for when the order was created, in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z"). | getCreatedAt(): ?string | setCreatedAt(?string createdAt): void |
| `updatedAt` | `?string` | Optional | The timestamp for when the order was last updated, in RFC 3339 format (for example, "2016-09-04T23:59:33.123Z"). | getUpdatedAt(): ?string | setUpdatedAt(?string updatedAt): void |
| `closedAt` | `?string` | Optional | The timestamp for when the order reached a terminal [state](entity:OrderState), in RFC 3339 format (for example "2016-09-04T23:59:33.123Z"). | getClosedAt(): ?string | setClosedAt(?string closedAt): void |
| `state` | [`?string (OrderState)`](../../doc/models/order-state.md) | Optional | The state of the order. | getState(): ?string | setState(?string state): void |
| `version` | `?int` | Optional | The version number, which is incremented each time an update is committed to the order.<br>Orders not created through the API do not include a version number and<br>therefore cannot be updated.<br><br>[Read more about working with versions](https://developer.squareup.com/docs/orders-api/manage-orders/update-orders). | getVersion(): ?int | setVersion(?int version): void |
| `totalMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalMoney(): ?Money | setTotalMoney(?Money totalMoney): void |
| `totalTaxMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalTaxMoney(): ?Money | setTotalTaxMoney(?Money totalTaxMoney): void |
| `totalDiscountMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalDiscountMoney(): ?Money | setTotalDiscountMoney(?Money totalDiscountMoney): void |
| `totalTipMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalTipMoney(): ?Money | setTotalTipMoney(?Money totalTipMoney): void |
| `totalServiceChargeMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getTotalServiceChargeMoney(): ?Money | setTotalServiceChargeMoney(?Money totalServiceChargeMoney): void |
| `ticketName` | `?string` | Optional | A short-term identifier for the order (such as a customer first name,<br>table number, or auto-generated order number that resets daily).<br>**Constraints**: *Maximum Length*: `30` | getTicketName(): ?string | setTicketName(?string ticketName): void |
| `pricingOptions` | [`?OrderPricingOptions`](../../doc/models/order-pricing-options.md) | Optional | Pricing options for an order. The options affect how the order's price is calculated.<br>They can be used, for example, to apply automatic price adjustments that are based on preconfigured<br>[pricing rules](../../doc/models/catalog-pricing-rule.md). | getPricingOptions(): ?OrderPricingOptions | setPricingOptions(?OrderPricingOptions pricingOptions): void |
| `rewards` | [`?(OrderReward[])`](../../doc/models/order-reward.md) | Optional | A set-like list of Rewards that have been added to the Order. | getRewards(): ?array | setRewards(?array rewards): void |
| `netAmountDueMoney` | [`?Money`](../../doc/models/money.md) | Optional | Represents an amount of money. `Money` fields can be signed or unsigned.<br>Fields that do not explicitly define whether they are signed or unsigned are<br>considered unsigned and can only hold positive amounts. For signed fields, the<br>sign of the value indicates the purpose of the money transfer. See<br>[Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts)<br>for more information. | getNetAmountDueMoney(): ?Money | setNetAmountDueMoney(?Money netAmountDueMoney): void |

## Example (as JSON)

```json
{
  "id": "id0",
  "location_id": "location_id4",
  "reference_id": "reference_id2",
  "source": {
    "name": "name4"
  },
  "customer_id": "customer_id8",
  "line_items": [
    {
      "uid": "uid9",
      "name": "name9",
      "quantity": "quantity5",
      "quantity_unit": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name7",
            "abbreviation": "abbreviation9"
          },
          "area_unit": "IMPERIAL_SQUARE_YARD",
          "length_unit": "METRIC_CENTIMETER",
          "volume_unit": "GENERIC_PINT",
          "weight_unit": "METRIC_KILOGRAM",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_MINUTE",
          "type": "TYPE_GENERIC"
        },
        "precision": 199,
        "catalog_object_id": "catalog_object_id9",
        "catalog_version": 133
      },
      "note": "note5",
      "catalog_object_id": "catalog_object_id7",
      "catalog_version": 237,
      "variation_name": "variation_name9",
      "item_type": "CUSTOM_AMOUNT",
      "metadata": {
        "key0": "metadata4",
        "key1": "metadata5"
      },
      "modifiers": [
        {
          "uid": "uid0",
          "catalog_object_id": "catalog_object_id4",
          "catalog_version": 80,
          "name": "name0",
          "quantity": "quantity6",
          "base_price_money": {
            "amount": 64,
            "currency": "MRO"
          },
          "total_price_money": {
            "amount": 62,
            "currency": "AED"
          },
          "metadata": {
            "key0": "metadata7",
            "key1": "metadata6"
          }
        },
        {
          "uid": "uid1",
          "catalog_object_id": "catalog_object_id5",
          "catalog_version": 81,
          "name": "name1",
          "quantity": "quantity7",
          "base_price_money": {
            "amount": 65,
            "currency": "MUR"
          },
          "total_price_money": {
            "amount": 63,
            "currency": "AFN"
          },
          "metadata": {
            "key0": "metadata8"
          }
        },
        {
          "uid": "uid2",
          "catalog_object_id": "catalog_object_id6",
          "catalog_version": 82,
          "name": "name2",
          "quantity": "quantity8",
          "base_price_money": {
            "amount": 66,
            "currency": "MVR"
          },
          "total_price_money": {
            "amount": 64,
            "currency": "ALL"
          },
          "metadata": {
            "key0": "metadata9",
            "key1": "metadata8",
            "key2": "metadata7"
          }
        }
      ],
      "applied_taxes": [
        {
          "uid": "uid9",
          "tax_uid": "tax_uid5",
          "applied_money": {}
        },
        {
          "uid": "uid0",
          "tax_uid": "tax_uid6",
          "applied_money": {}
        },
        {
          "uid": "uid1",
          "tax_uid": "tax_uid7",
          "applied_money": {}
        }
      ],
      "applied_discounts": [
        {
          "uid": "uid3",
          "discount_uid": "discount_uid1",
          "applied_money": {}
        }
      ],
      "applied_service_charges": [
        {
          "uid": "uid4",
          "service_charge_uid": "service_charge_uid4",
          "applied_money": {}
        },
        {
          "uid": "uid3",
          "service_charge_uid": "service_charge_uid3",
          "applied_money": {}
        },
        {
          "uid": "uid2",
          "service_charge_uid": "service_charge_uid2",
          "applied_money": {}
        }
      ],
      "base_price_money": {},
      "variation_total_price_money": {},
      "gross_sales_money": {},
      "total_tax_money": {},
      "total_discount_money": {},
      "total_money": {},
      "pricing_blocklists": {
        "blocked_discounts": [
          {
            "uid": "uid2",
            "discount_uid": "discount_uid8",
            "discount_catalog_object_id": "discount_catalog_object_id4"
          },
          {
            "uid": "uid3",
            "discount_uid": "discount_uid9",
            "discount_catalog_object_id": "discount_catalog_object_id5"
          }
        ],
        "blocked_taxes": [
          {
            "uid": "uid4",
            "tax_uid": "tax_uid0",
            "tax_catalog_object_id": "tax_catalog_object_id8"
          },
          {
            "uid": "uid3",
            "tax_uid": "tax_uid1",
            "tax_catalog_object_id": "tax_catalog_object_id7"
          }
        ]
      },
      "total_service_charge_money": {}
    },
    {
      "uid": "uid0",
      "name": "name0",
      "quantity": "quantity6",
      "quantity_unit": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name8",
            "abbreviation": "abbreviation0"
          },
          "area_unit": "IMPERIAL_SQUARE_MILE",
          "length_unit": "METRIC_MILLIMETER",
          "volume_unit": "GENERIC_QUART",
          "weight_unit": "METRIC_GRAM",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_SECOND",
          "type": "TYPE_WEIGHT"
        },
        "precision": 200,
        "catalog_object_id": "catalog_object_id0",
        "catalog_version": 134
      },
      "note": "note6",
      "catalog_object_id": "catalog_object_id6",
      "catalog_version": 236,
      "variation_name": "variation_name0",
      "item_type": "GIFT_CARD",
      "metadata": {
        "key0": "metadata3"
      },
      "modifiers": [
        {
          "uid": "uid1",
          "catalog_object_id": "catalog_object_id5",
          "catalog_version": 81,
          "name": "name1",
          "quantity": "quantity7",
          "base_price_money": {
            "amount": 65,
            "currency": "MUR"
          },
          "total_price_money": {
            "amount": 63,
            "currency": "AFN"
          },
          "metadata": {
            "key0": "metadata8"
          }
        }
      ],
      "applied_taxes": [
        {
          "uid": "uid0",
          "tax_uid": "tax_uid6",
          "applied_money": {}
        }
      ],
      "applied_discounts": [
        {
          "uid": "uid4",
          "discount_uid": "discount_uid0",
          "applied_money": {}
        },
        {
          "uid": "uid5",
          "discount_uid": "discount_uid9",
          "applied_money": {}
        }
      ],
      "applied_service_charges": [
        {
          "uid": "uid3",
          "service_charge_uid": "service_charge_uid3",
          "applied_money": {}
        }
      ],
      "base_price_money": {},
      "variation_total_price_money": {},
      "gross_sales_money": {},
      "total_tax_money": {},
      "total_discount_money": {},
      "total_money": {},
      "pricing_blocklists": {
        "blocked_discounts": [
          {
            "uid": "uid3",
            "discount_uid": "discount_uid9",
            "discount_catalog_object_id": "discount_catalog_object_id5"
          },
          {
            "uid": "uid4",
            "discount_uid": "discount_uid0",
            "discount_catalog_object_id": "discount_catalog_object_id6"
          },
          {
            "uid": "uid5",
            "discount_uid": "discount_uid1",
            "discount_catalog_object_id": "discount_catalog_object_id7"
          }
        ],
        "blocked_taxes": [
          {
            "uid": "uid3",
            "tax_uid": "tax_uid1",
            "tax_catalog_object_id": "tax_catalog_object_id7"
          },
          {
            "uid": "uid2",
            "tax_uid": "tax_uid2",
            "tax_catalog_object_id": "tax_catalog_object_id6"
          },
          {
            "uid": "uid1",
            "tax_uid": "tax_uid3",
            "tax_catalog_object_id": "tax_catalog_object_id5"
          }
        ]
      },
      "total_service_charge_money": {}
    },
    {
      "uid": "uid1",
      "name": "name1",
      "quantity": "quantity7",
      "quantity_unit": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name9",
            "abbreviation": "abbreviation1"
          },
          "area_unit": "METRIC_SQUARE_CENTIMETER",
          "length_unit": "IMPERIAL_MILE",
          "volume_unit": "GENERIC_GALLON",
          "weight_unit": "METRIC_MILLIGRAM",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_MILLISECOND",
          "type": "TYPE_VOLUME"
        },
        "precision": 201,
        "catalog_object_id": "catalog_object_id1",
        "catalog_version": 135
      },
      "note": "note7",
      "catalog_object_id": "catalog_object_id5",
      "catalog_version": 235,
      "variation_name": "variation_name1",
      "item_type": "ITEM",
      "metadata": {
        "key0": "metadata2",
        "key1": "metadata3",
        "key2": "metadata4"
      },
      "modifiers": [
        {
          "uid": "uid2",
          "catalog_object_id": "catalog_object_id6",
          "catalog_version": 82,
          "name": "name2",
          "quantity": "quantity8",
          "base_price_money": {
            "amount": 66,
            "currency": "MVR"
          },
          "total_price_money": {
            "amount": 64,
            "currency": "ALL"
          },
          "metadata": {
            "key0": "metadata9",
            "key1": "metadata8",
            "key2": "metadata7"
          }
        },
        {
          "uid": "uid3",
          "catalog_object_id": "catalog_object_id7",
          "catalog_version": 83,
          "name": "name3",
          "quantity": "quantity9",
          "base_price_money": {
            "amount": 67,
            "currency": "MWK"
          },
          "total_price_money": {
            "amount": 65,
            "currency": "AMD"
          },
          "metadata": {
            "key0": "metadata0",
            "key1": "metadata9"
          }
        }
      ],
      "applied_taxes": [
        {
          "uid": "uid1",
          "tax_uid": "tax_uid7",
          "applied_money": {}
        },
        {
          "uid": "uid2",
          "tax_uid": "tax_uid8",
          "applied_money": {}
        }
      ],
      "applied_discounts": [
        {
          "uid": "uid5",
          "discount_uid": "discount_uid9",
          "applied_money": {}
        },
        {
          "uid": "uid6",
          "discount_uid": "discount_uid8",
          "applied_money": {}
        },
        {
          "uid": "uid7",
          "discount_uid": "discount_uid7",
          "applied_money": {}
        }
      ],
      "applied_service_charges": [
        {
          "uid": "uid2",
          "service_charge_uid": "service_charge_uid2",
          "applied_money": {}
        },
        {
          "uid": "uid1",
          "service_charge_uid": "service_charge_uid1",
          "applied_money": {}
        }
      ],
      "base_price_money": {},
      "variation_total_price_money": {},
      "gross_sales_money": {},
      "total_tax_money": {},
      "total_discount_money": {},
      "total_money": {},
      "pricing_blocklists": {
        "blocked_discounts": [
          {
            "uid": "uid4",
            "discount_uid": "discount_uid0",
            "discount_catalog_object_id": "discount_catalog_object_id6"
          }
        ],
        "blocked_taxes": [
          {
            "uid": "uid2",
            "tax_uid": "tax_uid2",
            "tax_catalog_object_id": "tax_catalog_object_id6"
          }
        ]
      },
      "total_service_charge_money": {}
    }
  ],
  "taxes": [
    {
      "uid": "uid5",
      "catalog_object_id": "catalog_object_id1",
      "catalog_version": 39,
      "name": "name5",
      "type": "UNKNOWN_TAX",
      "percentage": "percentage3",
      "metadata": {
        "key0": "metadata8"
      },
      "applied_money": {
        "amount": 109,
        "currency": "BTC"
      },
      "scope": "OTHER_TAX_SCOPE",
      "auto_applied": true
    },
    {
      "uid": "uid6",
      "catalog_object_id": "catalog_object_id0",
      "catalog_version": 38,
      "name": "name6",
      "type": "INCLUSIVE",
      "percentage": "percentage4",
      "metadata": {
        "key0": "metadata7",
        "key1": "metadata8",
        "key2": "metadata9"
      },
      "applied_money": {
        "amount": 108,
        "currency": "ZMW"
      },
      "scope": "ORDER",
      "auto_applied": false
    }
  ],
  "discounts": [
    {
      "uid": "uid1",
      "catalog_object_id": "catalog_object_id5",
      "catalog_version": 65,
      "name": "name1",
      "type": "FIXED_PERCENTAGE",
      "percentage": "percentage9",
      "amount_money": {
        "amount": 121,
        "currency": "NGN"
      },
      "applied_money": {
        "amount": 97,
        "currency": "NIO"
      },
      "metadata": {
        "key0": "metadata8",
        "key1": "metadata7",
        "key2": "metadata6"
      },
      "scope": "LINE_ITEM",
      "reward_ids": [
        "reward_ids8"
      ],
      "pricing_rule_id": "pricing_rule_id3"
    },
    {
      "uid": "uid2",
      "catalog_object_id": "catalog_object_id6",
      "catalog_version": 66,
      "name": "name2",
      "type": "FIXED_AMOUNT",
      "percentage": "percentage0",
      "amount_money": {
        "amount": 122,
        "currency": "NIO"
      },
      "applied_money": {
        "amount": 96,
        "currency": "NGN"
      },
      "metadata": {
        "key0": "metadata9",
        "key1": "metadata8"
      },
      "scope": "ORDER",
      "reward_ids": [
        "reward_ids9",
        "reward_ids0"
      ],
      "pricing_rule_id": "pricing_rule_id4"
    },
    {
      "uid": "uid3",
      "catalog_object_id": "catalog_object_id7",
      "catalog_version": 67,
      "name": "name3",
      "type": "VARIABLE_PERCENTAGE",
      "percentage": "percentage1",
      "amount_money": {
        "amount": 123,
        "currency": "NOK"
      },
      "applied_money": {
        "amount": 95,
        "currency": "NAD"
      },
      "metadata": {
        "key0": "metadata0"
      },
      "scope": "OTHER_DISCOUNT_SCOPE",
      "reward_ids": [
        "reward_ids0",
        "reward_ids1",
        "reward_ids2"
      ],
      "pricing_rule_id": "pricing_rule_id5"
    }
  ],
  "service_charges": [
    {
      "uid": "uid9",
      "name": "name9",
      "catalog_object_id": "catalog_object_id7",
      "catalog_version": 1,
      "percentage": "percentage7",
      "amount_money": {
        "amount": 55,
        "currency": "MGA"
      },
      "applied_money": {
        "amount": 71,
        "currency": "SLL"
      },
      "total_money": {},
      "total_tax_money": {},
      "calculation_phase": "APPORTIONED_AMOUNT_PHASE",
      "taxable": true,
      "applied_taxes": [
        {
          "uid": "uid9",
          "tax_uid": "tax_uid5",
          "applied_money": {}
        },
        {
          "uid": "uid0",
          "tax_uid": "tax_uid4",
          "applied_money": {}
        },
        {
          "uid": "uid1",
          "tax_uid": "tax_uid3",
          "applied_money": {}
        }
      ],
      "metadata": {
        "key0": "metadata4",
        "key1": "metadata5"
      },
      "type": "CUSTOM",
      "treatment_type": "APPORTIONED_TREATMENT",
      "scope": "LINE_ITEM"
    },
    {
      "uid": "uid0",
      "name": "name0",
      "catalog_object_id": "catalog_object_id6",
      "catalog_version": 0,
      "percentage": "percentage8",
      "amount_money": {
        "amount": 56,
        "currency": "MKD"
      },
      "applied_money": {
        "amount": 70,
        "currency": "SHP"
      },
      "total_money": {},
      "total_tax_money": {},
      "calculation_phase": "SUBTOTAL_PHASE",
      "taxable": false,
      "applied_taxes": [
        {
          "uid": "uid0",
          "tax_uid": "tax_uid4",
          "applied_money": {}
        }
      ],
      "metadata": {
        "key0": "metadata3"
      },
      "type": "AUTO_GRATUITY",
      "treatment_type": "LINE_ITEM_TREATMENT",
      "scope": "OTHER_SERVICE_CHARGE_SCOPE"
    },
    {
      "uid": "uid1",
      "name": "name1",
      "catalog_object_id": "catalog_object_id5",
      "catalog_version": 255,
      "percentage": "percentage9",
      "amount_money": {
        "amount": 57,
        "currency": "MMK"
      },
      "applied_money": {
        "amount": 69,
        "currency": "SGD"
      },
      "total_money": {},
      "total_tax_money": {},
      "calculation_phase": "TOTAL_PHASE",
      "taxable": true,
      "applied_taxes": [
        {
          "uid": "uid1",
          "tax_uid": "tax_uid3",
          "applied_money": {}
        },
        {
          "uid": "uid2",
          "tax_uid": "tax_uid2",
          "applied_money": {}
        }
      ],
      "metadata": {
        "key0": "metadata2",
        "key1": "metadata3",
        "key2": "metadata4"
      },
      "type": "CUSTOM",
      "treatment_type": "APPORTIONED_TREATMENT",
      "scope": "ORDER"
    }
  ],
  "fulfillments": [
    {
      "uid": "uid6",
      "type": "DELIVERY",
      "state": "CANCELED",
      "line_item_application": "ALL",
      "entries": [
        {
          "uid": "uid9",
          "line_item_uid": "line_item_uid9",
          "quantity": "quantity5",
          "metadata": {
            "key0": "metadata4",
            "key1": "metadata5",
            "key2": "metadata6"
          }
        }
      ],
      "metadata": {
        "key0": "metadata3",
        "key1": "metadata2",
        "key2": "metadata1"
      },
      "pickup_details": {
        "recipient": {
          "customer_id": "customer_id4",
          "display_name": "display_name6",
          "email_address": "email_address4",
          "phone_number": "phone_number4",
          "address": {
            "address_line_1": "address_line_12",
            "address_line_2": "address_line_22",
            "address_line_3": "address_line_38",
            "locality": "locality2",
            "sublocality": "sublocality2",
            "sublocality_2": "sublocality_20",
            "sublocality_3": "sublocality_32",
            "administrative_district_level_1": "administrative_district_level_16",
            "administrative_district_level_2": "administrative_district_level_28",
            "administrative_district_level_3": "administrative_district_level_30",
            "postal_code": "postal_code4",
            "country": "CL",
            "first_name": "first_name2",
            "last_name": "last_name0"
          }
        },
        "expires_at": "expires_at8",
        "auto_complete_duration": "auto_complete_duration8",
        "schedule_type": "SCHEDULED",
        "pickup_at": "pickup_at0",
        "pickup_window_duration": "pickup_window_duration4",
        "prep_time_duration": "prep_time_duration6",
        "note": "note0",
        "placed_at": "placed_at4",
        "accepted_at": "accepted_at8",
        "rejected_at": "rejected_at6",
        "ready_at": "ready_at4",
        "expired_at": "expired_at4",
        "picked_up_at": "picked_up_at4",
        "canceled_at": "canceled_at0",
        "cancel_reason": "cancel_reason0",
        "is_curbside_pickup": false,
        "curbside_pickup_details": {
          "curbside_details": "curbside_details6",
          "buyer_arrived_at": "buyer_arrived_at2"
        }
      },
      "shipment_details": {
        "recipient": {
          "customer_id": "customer_id8",
          "display_name": "display_name0",
          "email_address": "email_address2",
          "phone_number": "phone_number2",
          "address": {
            "address_line_1": "address_line_16",
            "address_line_2": "address_line_26",
            "address_line_3": "address_line_32",
            "locality": "locality6",
            "sublocality": "sublocality6",
            "sublocality_2": "sublocality_24",
            "sublocality_3": "sublocality_36",
            "administrative_district_level_1": "administrative_district_level_10",
            "administrative_district_level_2": "administrative_district_level_22",
            "administrative_district_level_3": "administrative_district_level_34",
            "postal_code": "postal_code8",
            "country": "FI",
            "first_name": "first_name6",
            "last_name": "last_name4"
          }
        },
        "carrier": "carrier0",
        "shipping_note": "shipping_note4",
        "shipping_type": "shipping_type8",
        "tracking_number": "tracking_number6",
        "tracking_url": "tracking_url2",
        "placed_at": "placed_at2",
        "in_progress_at": "in_progress_at6",
        "packaged_at": "packaged_at2",
        "expected_shipped_at": "expected_shipped_at2",
        "shipped_at": "shipped_at6",
        "canceled_at": "canceled_at6",
        "cancel_reason": "cancel_reason6",
        "failed_at": "failed_at2",
        "failure_reason": "failure_reason2"
      },
      "delivery_details": {
        "recipient": {},
        "schedule_type": "SCHEDULED",
        "placed_at": "placed_at2",
        "deliver_at": "deliver_at0",
        "prep_time_duration": "prep_time_duration4",
        "delivery_window_duration": "delivery_window_duration6",
        "note": "note8",
        "completed_at": "completed_at4",
        "in_progress_at": "in_progress_at8",
        "rejected_at": "rejected_at4",
        "ready_at": "ready_at2",
        "delivered_at": "delivered_at0",
        "canceled_at": "canceled_at8",
        "cancel_reason": "cancel_reason8",
        "courier_pickup_at": "courier_pickup_at4",
        "courier_pickup_window_duration": "courier_pickup_window_duration6",
        "is_no_contact_delivery": false,
        "dropoff_notes": "dropoff_notes6",
        "courier_provider_name": "courier_provider_name0",
        "courier_support_phone_number": "courier_support_phone_number8",
        "square_delivery_id": "square_delivery_id2",
        "external_delivery_id": "external_delivery_id6",
        "managed_delivery": false
      }
    },
    {
      "uid": "uid7",
      "type": "SHIPMENT",
      "state": "FAILED",
      "line_item_application": "ENTRY_LIST",
      "entries": [
        {
          "uid": "uid8",
          "line_item_uid": "line_item_uid8",
          "quantity": "quantity4",
          "metadata": {
            "key0": "metadata5"
          }
        },
        {
          "uid": "uid7",
          "line_item_uid": "line_item_uid7",
          "quantity": "quantity3",
          "metadata": {
            "key0": "metadata6",
            "key1": "metadata7"
          }
        }
      ],
      "metadata": {
        "key0": "metadata4",
        "key1": "metadata3"
      },
      "pickup_details": {
        "recipient": {
          "customer_id": "customer_id5",
          "display_name": "display_name7",
          "email_address": "email_address5",
          "phone_number": "phone_number5",
          "address": {
            "address_line_1": "address_line_13",
            "address_line_2": "address_line_23",
            "address_line_3": "address_line_39",
            "locality": "locality3",
            "sublocality": "sublocality3",
            "sublocality_2": "sublocality_21",
            "sublocality_3": "sublocality_33",
            "administrative_district_level_1": "administrative_district_level_17",
            "administrative_district_level_2": "administrative_district_level_29",
            "administrative_district_level_3": "administrative_district_level_31",
            "postal_code": "postal_code5",
            "country": "CM",
            "first_name": "first_name3",
            "last_name": "last_name1"
          }
        },
        "expires_at": "expires_at9",
        "auto_complete_duration": "auto_complete_duration9",
        "schedule_type": "ASAP",
        "pickup_at": "pickup_at1",
        "pickup_window_duration": "pickup_window_duration5",
        "prep_time_duration": "prep_time_duration7",
        "note": "note1",
        "placed_at": "placed_at5",
        "accepted_at": "accepted_at9",
        "rejected_at": "rejected_at7",
        "ready_at": "ready_at5",
        "expired_at": "expired_at5",
        "picked_up_at": "picked_up_at5",
        "canceled_at": "canceled_at1",
        "cancel_reason": "cancel_reason1",
        "is_curbside_pickup": true,
        "curbside_pickup_details": {
          "curbside_details": "curbside_details7",
          "buyer_arrived_at": "buyer_arrived_at3"
        }
      },
      "shipment_details": {
        "recipient": {
          "customer_id": "customer_id9",
          "display_name": "display_name1",
          "email_address": "email_address1",
          "phone_number": "phone_number1",
          "address": {
            "address_line_1": "address_line_17",
            "address_line_2": "address_line_27",
            "address_line_3": "address_line_33",
            "locality": "locality7",
            "sublocality": "sublocality7",
            "sublocality_2": "sublocality_25",
            "sublocality_3": "sublocality_37",
            "administrative_district_level_1": "administrative_district_level_11",
            "administrative_district_level_2": "administrative_district_level_23",
            "administrative_district_level_3": "administrative_district_level_35",
            "postal_code": "postal_code9",
            "country": "FJ",
            "first_name": "first_name7",
            "last_name": "last_name5"
          }
        },
        "carrier": "carrier1",
        "shipping_note": "shipping_note5",
        "shipping_type": "shipping_type7",
        "tracking_number": "tracking_number7",
        "tracking_url": "tracking_url1",
        "placed_at": "placed_at1",
        "in_progress_at": "in_progress_at5",
        "packaged_at": "packaged_at3",
        "expected_shipped_at": "expected_shipped_at3",
        "shipped_at": "shipped_at7",
        "canceled_at": "canceled_at5",
        "cancel_reason": "cancel_reason5",
        "failed_at": "failed_at3",
        "failure_reason": "failure_reason1"
      },
      "delivery_details": {
        "recipient": {},
        "schedule_type": "ASAP",
        "placed_at": "placed_at3",
        "deliver_at": "deliver_at1",
        "prep_time_duration": "prep_time_duration5",
        "delivery_window_duration": "delivery_window_duration7",
        "note": "note9",
        "completed_at": "completed_at5",
        "in_progress_at": "in_progress_at9",
        "rejected_at": "rejected_at5",
        "ready_at": "ready_at3",
        "delivered_at": "delivered_at1",
        "canceled_at": "canceled_at9",
        "cancel_reason": "cancel_reason9",
        "courier_pickup_at": "courier_pickup_at5",
        "courier_pickup_window_duration": "courier_pickup_window_duration7",
        "is_no_contact_delivery": true,
        "dropoff_notes": "dropoff_notes7",
        "courier_provider_name": "courier_provider_name1",
        "courier_support_phone_number": "courier_support_phone_number9",
        "square_delivery_id": "square_delivery_id3",
        "external_delivery_id": "external_delivery_id7",
        "managed_delivery": true
      }
    },
    {
      "uid": "uid8",
      "type": "PICKUP",
      "state": "PROPOSED",
      "line_item_application": "ALL",
      "entries": [
        {
          "uid": "uid7",
          "line_item_uid": "line_item_uid7",
          "quantity": "quantity3",
          "metadata": {
            "key0": "metadata6",
            "key1": "metadata7"
          }
        },
        {
          "uid": "uid6",
          "line_item_uid": "line_item_uid6",
          "quantity": "quantity2",
          "metadata": {
            "key0": "metadata7",
            "key1": "metadata8",
            "key2": "metadata9"
          }
        },
        {
          "uid": "uid5",
          "line_item_uid": "line_item_uid5",
          "quantity": "quantity1",
          "metadata": {
            "key0": "metadata8"
          }
        }
      ],
      "metadata": {
        "key0": "metadata5"
      },
      "pickup_details": {
        "recipient": {
          "customer_id": "customer_id6",
          "display_name": "display_name8",
          "email_address": "email_address6",
          "phone_number": "phone_number6",
          "address": {
            "address_line_1": "address_line_14",
            "address_line_2": "address_line_24",
            "address_line_3": "address_line_30",
            "locality": "locality4",
            "sublocality": "sublocality4",
            "sublocality_2": "sublocality_22",
            "sublocality_3": "sublocality_34",
            "administrative_district_level_1": "administrative_district_level_18",
            "administrative_district_level_2": "administrative_district_level_20",
            "administrative_district_level_3": "administrative_district_level_32",
            "postal_code": "postal_code6",
            "country": "CN",
            "first_name": "first_name4",
            "last_name": "last_name2"
          }
        },
        "expires_at": "expires_at0",
        "auto_complete_duration": "auto_complete_duration0",
        "schedule_type": "SCHEDULED",
        "pickup_at": "pickup_at2",
        "pickup_window_duration": "pickup_window_duration6",
        "prep_time_duration": "prep_time_duration8",
        "note": "note2",
        "placed_at": "placed_at6",
        "accepted_at": "accepted_at0",
        "rejected_at": "rejected_at8",
        "ready_at": "ready_at6",
        "expired_at": "expired_at6",
        "picked_up_at": "picked_up_at6",
        "canceled_at": "canceled_at2",
        "cancel_reason": "cancel_reason2",
        "is_curbside_pickup": false,
        "curbside_pickup_details": {
          "curbside_details": "curbside_details8",
          "buyer_arrived_at": "buyer_arrived_at4"
        }
      },
      "shipment_details": {
        "recipient": {
          "customer_id": "customer_id0",
          "display_name": "display_name2",
          "email_address": "email_address0",
          "phone_number": "phone_number0",
          "address": {
            "address_line_1": "address_line_18",
            "address_line_2": "address_line_28",
            "address_line_3": "address_line_34",
            "locality": "locality8",
            "sublocality": "sublocality8",
            "sublocality_2": "sublocality_26",
            "sublocality_3": "sublocality_38",
            "administrative_district_level_1": "administrative_district_level_12",
            "administrative_district_level_2": "administrative_district_level_24",
            "administrative_district_level_3": "administrative_district_level_36",
            "postal_code": "postal_code0",
            "country": "FK",
            "first_name": "first_name8",
            "last_name": "last_name6"
          }
        },
        "carrier": "carrier2",
        "shipping_note": "shipping_note6",
        "shipping_type": "shipping_type6",
        "tracking_number": "tracking_number8",
        "tracking_url": "tracking_url0",
        "placed_at": "placed_at0",
        "in_progress_at": "in_progress_at4",
        "packaged_at": "packaged_at4",
        "expected_shipped_at": "expected_shipped_at4",
        "shipped_at": "shipped_at8",
        "canceled_at": "canceled_at4",
        "cancel_reason": "cancel_reason4",
        "failed_at": "failed_at4",
        "failure_reason": "failure_reason0"
      },
      "delivery_details": {
        "recipient": {},
        "schedule_type": "SCHEDULED",
        "placed_at": "placed_at4",
        "deliver_at": "deliver_at2",
        "prep_time_duration": "prep_time_duration6",
        "delivery_window_duration": "delivery_window_duration8",
        "note": "note0",
        "completed_at": "completed_at6",
        "in_progress_at": "in_progress_at0",
        "rejected_at": "rejected_at6",
        "ready_at": "ready_at4",
        "delivered_at": "delivered_at2",
        "canceled_at": "canceled_at0",
        "cancel_reason": "cancel_reason0",
        "courier_pickup_at": "courier_pickup_at6",
        "courier_pickup_window_duration": "courier_pickup_window_duration8",
        "is_no_contact_delivery": false,
        "dropoff_notes": "dropoff_notes8",
        "courier_provider_name": "courier_provider_name2",
        "courier_support_phone_number": "courier_support_phone_number0",
        "square_delivery_id": "square_delivery_id4",
        "external_delivery_id": "external_delivery_id8",
        "managed_delivery": false
      }
    }
  ],
  "returns": [
    {
      "uid": "uid9",
      "source_order_id": "source_order_id3",
      "return_line_items": [
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
              "area_unit": "IMPERIAL_SQUARE_MILE",
              "length_unit": "METRIC_MILLIMETER",
              "volume_unit": "METRIC_LITER",
              "weight_unit": "IMPERIAL_STONE",
              "generic_unit": "UNIT",
              "time_unit": "GENERIC_MILLISECOND",
              "type": "TYPE_LENGTH"
            },
            "precision": 200,
            "catalog_object_id": "catalog_object_id4",
            "catalog_version": 122
          },
          "note": "note8",
          "catalog_object_id": "catalog_object_id0",
          "catalog_version": 236,
          "variation_name": "variation_name6",
          "item_type": "CUSTOM_AMOUNT",
          "return_modifiers": [
            {
              "uid": "uid5",
              "source_modifier_uid": "source_modifier_uid1",
              "catalog_object_id": "catalog_object_id1",
              "catalog_version": 219,
              "name": "name5",
              "base_price_money": {
                "amount": 21,
                "currency": "LBP"
              },
              "total_price_money": {
                "amount": 111,
                "currency": "VND"
              },
              "quantity": "quantity1"
            },
            {
              "uid": "uid6",
              "source_modifier_uid": "source_modifier_uid0",
              "catalog_object_id": "catalog_object_id0",
              "catalog_version": 218,
              "name": "name6",
              "base_price_money": {
                "amount": 22,
                "currency": "LKR"
              },
              "total_price_money": {
                "amount": 112,
                "currency": "VUV"
              },
              "quantity": "quantity2"
            },
            {
              "uid": "uid7",
              "source_modifier_uid": "source_modifier_uid9",
              "catalog_object_id": "catalog_object_id9",
              "catalog_version": 217,
              "name": "name7",
              "base_price_money": {
                "amount": 23,
                "currency": "LRD"
              },
              "total_price_money": {
                "amount": 113,
                "currency": "WST"
              },
              "quantity": "quantity3"
            }
          ],
          "applied_taxes": [
            {
              "uid": "uid6",
              "tax_uid": "tax_uid8",
              "applied_money": {}
            },
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
              "uid": "uid0",
              "discount_uid": "discount_uid4",
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
            },
            {
              "uid": "uid6",
              "service_charge_uid": "service_charge_uid6",
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
              "area_unit": "METRIC_SQUARE_CENTIMETER",
              "length_unit": "IMPERIAL_MILE",
              "volume_unit": "GENERIC_FLUID_OUNCE",
              "weight_unit": "IMPERIAL_POUND",
              "generic_unit": "UNIT",
              "time_unit": "GENERIC_DAY",
              "type": "TYPE_AREA"
            },
            "precision": 201,
            "catalog_object_id": "catalog_object_id3",
            "catalog_version": 121
          },
          "note": "note7",
          "catalog_object_id": "catalog_object_id9",
          "catalog_version": 235,
          "variation_name": "variation_name7",
          "item_type": "GIFT_CARD",
          "return_modifiers": [
            {
              "uid": "uid4",
              "source_modifier_uid": "source_modifier_uid2",
              "catalog_object_id": "catalog_object_id2",
              "catalog_version": 220,
              "name": "name4",
              "base_price_money": {
                "amount": 20,
                "currency": "LAK"
              },
              "total_price_money": {
                "amount": 110,
                "currency": "VEF"
              },
              "quantity": "quantity0"
            },
            {
              "uid": "uid5",
              "source_modifier_uid": "source_modifier_uid1",
              "catalog_object_id": "catalog_object_id1",
              "catalog_version": 219,
              "name": "name5",
              "base_price_money": {
                "amount": 21,
                "currency": "LBP"
              },
              "total_price_money": {
                "amount": 111,
                "currency": "VND"
              },
              "quantity": "quantity1"
            }
          ],
          "applied_taxes": [
            {
              "uid": "uid7",
              "tax_uid": "tax_uid7",
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
            }
          ],
          "total_service_charge_money": {}
        },
        {
          "uid": "uid8",
          "source_line_item_uid": "source_line_item_uid4",
          "name": "name8",
          "quantity": "quantity4",
          "quantity_unit": {
            "measurement_unit": {
              "custom_unit": {
                "name": "name6",
                "abbreviation": "abbreviation8"
              },
              "area_unit": "METRIC_SQUARE_METER",
              "length_unit": "IMPERIAL_YARD",
              "volume_unit": "GENERIC_SHOT",
              "weight_unit": "IMPERIAL_WEIGHT_OUNCE",
              "generic_unit": "UNIT",
              "time_unit": "GENERIC_HOUR",
              "type": "TYPE_CUSTOM"
            },
            "precision": 202,
            "catalog_object_id": "catalog_object_id2",
            "catalog_version": 120
          },
          "note": "note6",
          "catalog_object_id": "catalog_object_id8",
          "catalog_version": 234,
          "variation_name": "variation_name8",
          "item_type": "ITEM",
          "return_modifiers": [
            {
              "uid": "uid3",
              "source_modifier_uid": "source_modifier_uid3",
              "catalog_object_id": "catalog_object_id3",
              "catalog_version": 221,
              "name": "name3",
              "base_price_money": {
                "amount": 19,
                "currency": "KZT"
              },
              "total_price_money": {
                "amount": 109,
                "currency": "UZS"
              },
              "quantity": "quantity9"
            }
          ],
          "applied_taxes": [
            {
              "uid": "uid8",
              "tax_uid": "tax_uid6",
              "applied_money": {}
            },
            {
              "uid": "uid9",
              "tax_uid": "tax_uid5",
              "applied_money": {}
            }
          ],
          "applied_discounts": [
            {
              "uid": "uid2",
              "discount_uid": "discount_uid2",
              "applied_money": {}
            },
            {
              "uid": "uid3",
              "discount_uid": "discount_uid1",
              "applied_money": {}
            },
            {
              "uid": "uid4",
              "discount_uid": "discount_uid0",
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
              "uid": "uid3",
              "service_charge_uid": "service_charge_uid3",
              "applied_money": {}
            },
            {
              "uid": "uid4",
              "service_charge_uid": "service_charge_uid4",
              "applied_money": {}
            },
            {
              "uid": "uid5",
              "service_charge_uid": "service_charge_uid5",
              "applied_money": {}
            }
          ],
          "total_service_charge_money": {}
        }
      ],
      "return_service_charges": [
        {
          "uid": "uid4",
          "source_service_charge_uid": "source_service_charge_uid2",
          "name": "name4",
          "catalog_object_id": "catalog_object_id2",
          "catalog_version": 70,
          "percentage": "percentage2",
          "amount_money": {},
          "applied_money": {},
          "total_money": {},
          "total_tax_money": {},
          "calculation_phase": "APPORTIONED_PERCENTAGE_PHASE",
          "taxable": false,
          "applied_taxes": [
            {}
          ],
          "treatment_type": "LINE_ITEM_TREATMENT",
          "scope": "OTHER_SERVICE_CHARGE_SCOPE"
        },
        {
          "uid": "uid5",
          "source_service_charge_uid": "source_service_charge_uid1",
          "name": "name5",
          "catalog_object_id": "catalog_object_id1",
          "catalog_version": 69,
          "percentage": "percentage3",
          "amount_money": {},
          "applied_money": {},
          "total_money": {},
          "total_tax_money": {},
          "calculation_phase": "APPORTIONED_AMOUNT_PHASE",
          "taxable": true,
          "applied_taxes": [
            {},
            {}
          ],
          "treatment_type": "APPORTIONED_TREATMENT",
          "scope": "ORDER"
        }
      ],
      "return_taxes": [
        {
          "uid": "uid7",
          "source_tax_uid": "source_tax_uid5",
          "catalog_object_id": "catalog_object_id9",
          "catalog_version": 245,
          "name": "name7",
          "type": "INCLUSIVE",
          "percentage": "percentage5",
          "applied_money": {},
          "scope": "ORDER"
        }
      ],
      "return_discounts": [
        {
          "uid": "uid7",
          "source_discount_uid": "source_discount_uid7",
          "catalog_object_id": "catalog_object_id9",
          "catalog_version": 187,
          "name": "name7",
          "type": "VARIABLE_PERCENTAGE",
          "percentage": "percentage5",
          "amount_money": {},
          "applied_money": {},
          "scope": "OTHER_DISCOUNT_SCOPE"
        },
        {
          "uid": "uid8",
          "source_discount_uid": "source_discount_uid8",
          "catalog_object_id": "catalog_object_id8",
          "catalog_version": 186,
          "name": "name8",
          "type": "FIXED_AMOUNT",
          "percentage": "percentage6",
          "amount_money": {},
          "applied_money": {},
          "scope": "ORDER"
        }
      ],
      "rounding_adjustment": {
        "uid": "uid1",
        "name": "name1",
        "amount_money": {}
      },
      "return_amounts": {
        "total_money": {},
        "tax_money": {},
        "discount_money": {},
        "tip_money": {},
        "service_charge_money": {}
      }
    }
  ],
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
  },
  "net_amounts": {
    "total_money": {
      "amount": 228,
      "currency": "PAB"
    },
    "tax_money": {
      "amount": 36,
      "currency": "BGN"
    },
    "discount_money": {},
    "tip_money": {},
    "service_charge_money": {}
  },
  "rounding_adjustment": {
    "uid": "uid2",
    "name": "name2",
    "amount_money": {
      "amount": 142,
      "currency": "TJS"
    }
  },
  "tenders": [
    {
      "id": "id2",
      "location_id": "location_id6",
      "transaction_id": "transaction_id0",
      "created_at": "created_at0",
      "note": "note8",
      "amount_money": {
        "amount": 214,
        "currency": "TJS"
      },
      "tip_money": {
        "amount": 218,
        "currency": "HTG"
      },
      "processing_fee_money": {},
      "customer_id": "customer_id0",
      "type": "OTHER",
      "card_details": {
        "status": "AUTHORIZED",
        "card": {
          "id": "id6",
          "card_brand": "INTERAC",
          "last_4": "last_48",
          "exp_month": 148,
          "exp_year": 148,
          "cardholder_name": "cardholder_name8",
          "billing_address": {
            "address_line_1": "address_line_18",
            "address_line_2": "address_line_22",
            "address_line_3": "address_line_38",
            "locality": "locality8",
            "sublocality": "sublocality2",
            "sublocality_2": "sublocality_20",
            "sublocality_3": "sublocality_38",
            "administrative_district_level_1": "administrative_district_level_16",
            "administrative_district_level_2": "administrative_district_level_22",
            "administrative_district_level_3": "administrative_district_level_30",
            "postal_code": "postal_code4",
            "country": "PY",
            "first_name": "first_name2",
            "last_name": "last_name0"
          },
          "fingerprint": "fingerprint2",
          "customer_id": "customer_id4",
          "merchant_id": "merchant_id6",
          "reference_id": "reference_id6",
          "enabled": false,
          "card_type": "DEBIT",
          "prepaid_type": "UNKNOWN_PREPAID_TYPE",
          "bin": "bin6",
          "version": 234,
          "card_co_brand": "UNKNOWN"
        },
        "entry_method": "KEYED"
      },
      "cash_details": {
        "buyer_tendered_money": {},
        "change_back_money": {}
      },
      "additional_recipients": [
        {
          "location_id": "location_id5",
          "description": "description1",
          "amount_money": {},
          "receivable_id": "receivable_id1"
        },
        {
          "location_id": "location_id6",
          "description": "description2",
          "amount_money": {},
          "receivable_id": "receivable_id2"
        },
        {
          "location_id": "location_id7",
          "description": "description3",
          "amount_money": {},
          "receivable_id": "receivable_id3"
        }
      ],
      "payment_id": "payment_id2"
    },
    {
      "id": "id3",
      "location_id": "location_id7",
      "transaction_id": "transaction_id1",
      "created_at": "created_at1",
      "note": "note9",
      "amount_money": {
        "amount": 215,
        "currency": "TMT"
      },
      "tip_money": {
        "amount": 219,
        "currency": "HUF"
      },
      "processing_fee_money": {},
      "customer_id": "customer_id1",
      "type": "CARD",
      "card_details": {
        "status": "FAILED",
        "card": {
          "id": "id5",
          "card_brand": "EFTPOS",
          "last_4": "last_47",
          "exp_month": 149,
          "exp_year": 147,
          "cardholder_name": "cardholder_name9",
          "billing_address": {
            "address_line_1": "address_line_17",
            "address_line_2": "address_line_23",
            "address_line_3": "address_line_39",
            "locality": "locality7",
            "sublocality": "sublocality3",
            "sublocality_2": "sublocality_21",
            "sublocality_3": "sublocality_37",
            "administrative_district_level_1": "administrative_district_level_17",
            "administrative_district_level_2": "administrative_district_level_21",
            "administrative_district_level_3": "administrative_district_level_31",
            "postal_code": "postal_code5",
            "country": "QA",
            "first_name": "first_name3",
            "last_name": "last_name1"
          },
          "fingerprint": "fingerprint1",
          "customer_id": "customer_id3",
          "merchant_id": "merchant_id5",
          "reference_id": "reference_id7",
          "enabled": true,
          "card_type": "UNKNOWN_CARD_TYPE",
          "prepaid_type": "PREPAID",
          "bin": "bin5",
          "version": 233,
          "card_co_brand": "AFTERPAY"
        },
        "entry_method": "EMV"
      },
      "cash_details": {
        "buyer_tendered_money": {},
        "change_back_money": {}
      },
      "additional_recipients": [
        {
          "location_id": "location_id6",
          "description": "description2",
          "amount_money": {},
          "receivable_id": "receivable_id2"
        }
      ],
      "payment_id": "payment_id3"
    },
    {
      "id": "id4",
      "location_id": "location_id8",
      "transaction_id": "transaction_id2",
      "created_at": "created_at2",
      "note": "note0",
      "amount_money": {
        "amount": 216,
        "currency": "TND"
      },
      "tip_money": {
        "amount": 220,
        "currency": "IDR"
      },
      "processing_fee_money": {},
      "customer_id": "customer_id2",
      "type": "CASH",
      "card_details": {
        "status": "VOIDED",
        "card": {
          "id": "id4",
          "card_brand": "FELICA",
          "last_4": "last_46",
          "exp_month": 150,
          "exp_year": 146,
          "cardholder_name": "cardholder_name0",
          "billing_address": {
            "address_line_1": "address_line_16",
            "address_line_2": "address_line_24",
            "address_line_3": "address_line_30",
            "locality": "locality6",
            "sublocality": "sublocality4",
            "sublocality_2": "sublocality_22",
            "sublocality_3": "sublocality_36",
            "administrative_district_level_1": "administrative_district_level_18",
            "administrative_district_level_2": "administrative_district_level_20",
            "administrative_district_level_3": "administrative_district_level_32",
            "postal_code": "postal_code6",
            "country": "RE",
            "first_name": "first_name4",
            "last_name": "last_name2"
          },
          "fingerprint": "fingerprint0",
          "customer_id": "customer_id2",
          "merchant_id": "merchant_id4",
          "reference_id": "reference_id8",
          "enabled": false,
          "card_type": "CREDIT",
          "prepaid_type": "NOT_PREPAID",
          "bin": "bin4",
          "version": 232,
          "card_co_brand": "CLEARPAY"
        },
        "entry_method": "ON_FILE"
      },
      "cash_details": {
        "buyer_tendered_money": {},
        "change_back_money": {}
      },
      "additional_recipients": [
        {
          "location_id": "location_id7",
          "description": "description3",
          "amount_money": {},
          "receivable_id": "receivable_id3"
        },
        {
          "location_id": "location_id8",
          "description": "description4",
          "amount_money": {},
          "receivable_id": "receivable_id4"
        }
      ],
      "payment_id": "payment_id4"
    }
  ],
  "refunds": [
    {
      "id": "id4",
      "location_id": "location_id8",
      "transaction_id": "transaction_id2",
      "tender_id": "tender_id2",
      "created_at": "created_at2",
      "reason": "reason0",
      "amount_money": {
        "amount": 186,
        "currency": "YER"
      },
      "status": "PENDING",
      "processing_fee_money": {
        "amount": 112,
        "currency": "GEL"
      },
      "additional_recipients": [
        {
          "location_id": "location_id7",
          "description": "description3",
          "amount_money": {},
          "receivable_id": "receivable_id3"
        }
      ]
    },
    {
      "id": "id5",
      "location_id": "location_id9",
      "transaction_id": "transaction_id3",
      "tender_id": "tender_id3",
      "created_at": "created_at3",
      "reason": "reason9",
      "amount_money": {
        "amount": 187,
        "currency": "ZAR"
      },
      "status": "APPROVED",
      "processing_fee_money": {
        "amount": 113,
        "currency": "GHS"
      },
      "additional_recipients": [
        {
          "location_id": "location_id8",
          "description": "description4",
          "amount_money": {},
          "receivable_id": "receivable_id4"
        },
        {
          "location_id": "location_id9",
          "description": "description5",
          "amount_money": {},
          "receivable_id": "receivable_id5"
        }
      ]
    },
    {
      "id": "id6",
      "location_id": "location_id0",
      "transaction_id": "transaction_id4",
      "tender_id": "tender_id4",
      "created_at": "created_at4",
      "reason": "reason8",
      "amount_money": {
        "amount": 188,
        "currency": "ZMK"
      },
      "status": "REJECTED",
      "processing_fee_money": {
        "amount": 114,
        "currency": "GIP"
      },
      "additional_recipients": [
        {
          "location_id": "location_id9",
          "description": "description5",
          "amount_money": {},
          "receivable_id": "receivable_id5"
        },
        {
          "location_id": "location_id0",
          "description": "description6",
          "amount_money": {},
          "receivable_id": "receivable_id6"
        },
        {
          "location_id": "location_id1",
          "description": "description7",
          "amount_money": {},
          "receivable_id": "receivable_id7"
        }
      ]
    }
  ],
  "metadata": {
    "key0": "metadata3",
    "key1": "metadata4",
    "key2": "metadata5"
  },
  "created_at": "created_at2",
  "updated_at": "updated_at4",
  "closed_at": "closed_at2",
  "state": "OPEN",
  "version": 172,
  "total_money": {
    "amount": 250,
    "currency": "UNKNOWN_CURRENCY"
  },
  "total_tax_money": {
    "amount": 58,
    "currency": "SDG"
  },
  "total_discount_money": {
    "amount": 132,
    "currency": "TRY"
  },
  "total_tip_money": {
    "amount": 216,
    "currency": "KES"
  },
  "total_service_charge_money": {
    "amount": 62,
    "currency": "NZD"
  },
  "ticket_name": "ticket_name6",
  "pricing_options": {
    "auto_apply_discounts": false,
    "auto_apply_taxes": false
  },
  "rewards": [
    {
      "id": "id5",
      "reward_tier_id": "reward_tier_id1"
    }
  ],
  "net_amount_due_money": {
    "amount": 174,
    "currency": "MKD"
  }
}
```

