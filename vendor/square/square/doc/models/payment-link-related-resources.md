
# Payment Link Related Resources

## Structure

`PaymentLinkRelatedResources`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `orders` | [`?(Order[])`](../../doc/models/order.md) | Optional | The order associated with the payment link. | getOrders(): ?array | setOrders(?array orders): void |
| `subscriptionPlans` | [`?(CatalogObject[])`](../../doc/models/catalog-object.md) | Optional | The subscription plan associated with the payment link. | getSubscriptionPlans(): ?array | setSubscriptionPlans(?array subscriptionPlans): void |

## Example (as JSON)

```json
{
  "orders": [
    {
      "id": "id6",
      "location_id": "location_id0",
      "reference_id": "reference_id6",
      "source": {
        "name": "name8"
      },
      "customer_id": "customer_id4",
      "line_items": [
        {
          "uid": "uid3",
          "name": "name3",
          "quantity": "quantity9",
          "quantity_unit": {
            "measurement_unit": {
              "custom_unit": {
                "name": "name1",
                "abbreviation": "abbreviation3"
              },
              "area_unit": "METRIC_SQUARE_CENTIMETER",
              "length_unit": "IMPERIAL_MILE",
              "volume_unit": "METRIC_MILLILITER",
              "weight_unit": "IMPERIAL_POUND",
              "generic_unit": "UNIT",
              "time_unit": "GENERIC_HOUR",
              "type": "TYPE_AREA"
            },
            "precision": 217,
            "catalog_object_id": "catalog_object_id7",
            "catalog_version": 105
          },
          "note": "note1",
          "catalog_object_id": "catalog_object_id3",
          "catalog_version": 219,
          "variation_name": "variation_name3",
          "item_type": "GIFT_CARD",
          "metadata": {
            "key0": "metadata0"
          },
          "modifiers": [
            {
              "uid": "uid4",
              "catalog_object_id": "catalog_object_id8",
              "catalog_version": 158,
              "name": "name4",
              "quantity": "quantity0",
              "base_price_money": {
                "amount": 82,
                "currency": "COP"
              },
              "total_price_money": {
                "amount": 80,
                "currency": "PYG"
              },
              "metadata": {
                "key0": "metadata1"
              }
            }
          ],
          "applied_taxes": [
            {
              "uid": "uid3",
              "tax_uid": "tax_uid1",
              "applied_money": {}
            }
          ],
          "applied_discounts": [
            {
              "uid": "uid7",
              "discount_uid": "discount_uid7",
              "applied_money": {}
            },
            {
              "uid": "uid8",
              "discount_uid": "discount_uid6",
              "applied_money": {}
            }
          ],
          "applied_service_charges": [
            {
              "uid": "uid8",
              "service_charge_uid": "service_charge_uid8",
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
                "uid": "uid6",
                "discount_uid": "discount_uid2",
                "discount_catalog_object_id": "discount_catalog_object_id8"
              },
              {
                "uid": "uid7",
                "discount_uid": "discount_uid3",
                "discount_catalog_object_id": "discount_catalog_object_id9"
              },
              {
                "uid": "uid8",
                "discount_uid": "discount_uid4",
                "discount_catalog_object_id": "discount_catalog_object_id0"
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
        }
      ],
      "taxes": [
        {
          "uid": "uid9",
          "catalog_object_id": "catalog_object_id7",
          "catalog_version": 21,
          "name": "name9",
          "type": "INCLUSIVE",
          "percentage": "percentage7",
          "metadata": {
            "key0": "metadata4",
            "key1": "metadata5",
            "key2": "metadata6"
          },
          "applied_money": {},
          "scope": "ORDER",
          "auto_applied": true
        },
        {
          "uid": "uid0",
          "catalog_object_id": "catalog_object_id6",
          "catalog_version": 20,
          "name": "name0",
          "type": "ADDITIVE",
          "percentage": "percentage8",
          "metadata": {
            "key0": "metadata3",
            "key1": "metadata4"
          },
          "applied_money": {},
          "scope": "LINE_ITEM",
          "auto_applied": false
        },
        {
          "uid": "uid1",
          "catalog_object_id": "catalog_object_id5",
          "catalog_version": 19,
          "name": "name1",
          "type": "UNKNOWN_TAX",
          "percentage": "percentage9",
          "metadata": {
            "key0": "metadata2"
          },
          "applied_money": {},
          "scope": "OTHER_TAX_SCOPE",
          "auto_applied": true
        }
      ],
      "discounts": [
        {
          "uid": "uid7",
          "catalog_object_id": "catalog_object_id1",
          "catalog_version": 47,
          "name": "name7",
          "type": "FIXED_AMOUNT",
          "percentage": "percentage5",
          "amount_money": {},
          "applied_money": {},
          "metadata": {
            "key0": "metadata2"
          },
          "scope": "OTHER_DISCOUNT_SCOPE",
          "reward_ids": [
            "reward_ids4",
            "reward_ids5",
            "reward_ids6"
          ],
          "pricing_rule_id": "pricing_rule_id9"
        },
        {
          "uid": "uid8",
          "catalog_object_id": "catalog_object_id2",
          "catalog_version": 48,
          "name": "name8",
          "type": "VARIABLE_PERCENTAGE",
          "percentage": "percentage6",
          "amount_money": {},
          "applied_money": {},
          "metadata": {
            "key0": "metadata1",
            "key1": "metadata0"
          },
          "scope": "LINE_ITEM",
          "reward_ids": [
            "reward_ids5"
          ],
          "pricing_rule_id": "pricing_rule_id0"
        }
      ],
      "service_charges": [
        {
          "uid": "uid7",
          "name": "name7",
          "catalog_object_id": "catalog_object_id9",
          "catalog_version": 13,
          "percentage": "percentage5",
          "amount_money": {},
          "applied_money": {},
          "total_money": {},
          "total_tax_money": {},
          "calculation_phase": "APPORTIONED_AMOUNT_PHASE",
          "taxable": true,
          "applied_taxes": [
            {},
            {},
            {}
          ],
          "metadata": {
            "key0": "metadata6",
            "key1": "metadata7"
          },
          "type": "CUSTOM",
          "treatment_type": "APPORTIONED_TREATMENT",
          "scope": "LINE_ITEM"
        }
      ],
      "fulfillments": [
        {
          "uid": "uid2",
          "type": "PICKUP",
          "state": "PROPOSED",
          "line_item_application": "ALL",
          "entries": [
            {
              "uid": "uid7",
              "line_item_uid": "line_item_uid7",
              "quantity": "quantity3",
              "metadata": {
                "key0": "metadata6"
              }
            },
            {
              "uid": "uid8",
              "line_item_uid": "line_item_uid8",
              "quantity": "quantity4",
              "metadata": {
                "key0": "metadata5",
                "key1": "metadata6",
                "key2": "metadata7"
              }
            },
            {
              "uid": "uid9",
              "line_item_uid": "line_item_uid9",
              "quantity": "quantity5",
              "metadata": {
                "key0": "metadata4",
                "key1": "metadata5"
              }
            }
          ],
          "metadata": {
            "key0": "metadata9"
          },
          "pickup_details": {
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
                "country": "LS",
                "first_name": "first_name8",
                "last_name": "last_name6"
              }
            },
            "expires_at": "expires_at4",
            "auto_complete_duration": "auto_complete_duration4",
            "schedule_type": "SCHEDULED",
            "pickup_at": "pickup_at6",
            "pickup_window_duration": "pickup_window_duration0",
            "prep_time_duration": "prep_time_duration2",
            "note": "note6",
            "placed_at": "placed_at0",
            "accepted_at": "accepted_at4",
            "rejected_at": "rejected_at2",
            "ready_at": "ready_at0",
            "expired_at": "expired_at0",
            "picked_up_at": "picked_up_at0",
            "canceled_at": "canceled_at6",
            "cancel_reason": "cancel_reason6",
            "is_curbside_pickup": false,
            "curbside_pickup_details": {
              "curbside_details": "curbside_details2",
              "buyer_arrived_at": "buyer_arrived_at8"
            }
          },
          "shipment_details": {
            "recipient": {
              "customer_id": "customer_id4",
              "display_name": "display_name6",
              "email_address": "email_address4",
              "phone_number": "phone_number6",
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
                "country": "MW",
                "first_name": "first_name2",
                "last_name": "last_name0"
              }
            },
            "carrier": "carrier6",
            "shipping_note": "shipping_note0",
            "shipping_type": "shipping_type2",
            "tracking_number": "tracking_number2",
            "tracking_url": "tracking_url4",
            "placed_at": "placed_at6",
            "in_progress_at": "in_progress_at0",
            "packaged_at": "packaged_at8",
            "expected_shipped_at": "expected_shipped_at8",
            "shipped_at": "shipped_at2",
            "canceled_at": "canceled_at0",
            "cancel_reason": "cancel_reason0",
            "failed_at": "failed_at8",
            "failure_reason": "failure_reason6"
          },
          "delivery_details": {
            "recipient": {},
            "schedule_type": "SCHEDULED",
            "placed_at": "placed_at8",
            "deliver_at": "deliver_at6",
            "prep_time_duration": "prep_time_duration0",
            "delivery_window_duration": "delivery_window_duration2",
            "note": "note4",
            "completed_at": "completed_at0",
            "in_progress_at": "in_progress_at4",
            "rejected_at": "rejected_at0",
            "ready_at": "ready_at8",
            "delivered_at": "delivered_at6",
            "canceled_at": "canceled_at4",
            "cancel_reason": "cancel_reason4",
            "courier_pickup_at": "courier_pickup_at0",
            "courier_pickup_window_duration": "courier_pickup_window_duration2",
            "is_no_contact_delivery": false,
            "dropoff_notes": "dropoff_notes2",
            "courier_provider_name": "courier_provider_name6",
            "courier_support_phone_number": "courier_support_phone_number4",
            "square_delivery_id": "square_delivery_id8",
            "external_delivery_id": "external_delivery_id2",
            "managed_delivery": false
          }
        },
        {
          "uid": "uid3",
          "type": "SHIPMENT",
          "state": "RESERVED",
          "line_item_application": "ENTRY_LIST",
          "entries": [
            {
              "uid": "uid8",
              "line_item_uid": "line_item_uid8",
              "quantity": "quantity4",
              "metadata": {
                "key0": "metadata5",
                "key1": "metadata6",
                "key2": "metadata7"
              }
            }
          ],
          "metadata": {
            "key0": "metadata0",
            "key1": "metadata9",
            "key2": "metadata8"
          },
          "pickup_details": {
            "recipient": {
              "customer_id": "customer_id1",
              "display_name": "display_name3",
              "email_address": "email_address1",
              "phone_number": "phone_number1",
              "address": {
                "address_line_1": "address_line_19",
                "address_line_2": "address_line_29",
                "address_line_3": "address_line_35",
                "locality": "locality9",
                "sublocality": "sublocality9",
                "sublocality_2": "sublocality_27",
                "sublocality_3": "sublocality_39",
                "administrative_district_level_1": "administrative_district_level_13",
                "administrative_district_level_2": "administrative_district_level_25",
                "administrative_district_level_3": "administrative_district_level_37",
                "postal_code": "postal_code1",
                "country": "LT",
                "first_name": "first_name9",
                "last_name": "last_name7"
              }
            },
            "expires_at": "expires_at5",
            "auto_complete_duration": "auto_complete_duration5",
            "schedule_type": "ASAP",
            "pickup_at": "pickup_at7",
            "pickup_window_duration": "pickup_window_duration1",
            "prep_time_duration": "prep_time_duration3",
            "note": "note7",
            "placed_at": "placed_at1",
            "accepted_at": "accepted_at5",
            "rejected_at": "rejected_at3",
            "ready_at": "ready_at1",
            "expired_at": "expired_at1",
            "picked_up_at": "picked_up_at1",
            "canceled_at": "canceled_at7",
            "cancel_reason": "cancel_reason7",
            "is_curbside_pickup": true,
            "curbside_pickup_details": {
              "curbside_details": "curbside_details3",
              "buyer_arrived_at": "buyer_arrived_at9"
            }
          },
          "shipment_details": {
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
                "country": "MX",
                "first_name": "first_name3",
                "last_name": "last_name1"
              }
            },
            "carrier": "carrier7",
            "shipping_note": "shipping_note1",
            "shipping_type": "shipping_type1",
            "tracking_number": "tracking_number3",
            "tracking_url": "tracking_url5",
            "placed_at": "placed_at5",
            "in_progress_at": "in_progress_at9",
            "packaged_at": "packaged_at9",
            "expected_shipped_at": "expected_shipped_at9",
            "shipped_at": "shipped_at3",
            "canceled_at": "canceled_at1",
            "cancel_reason": "cancel_reason1",
            "failed_at": "failed_at9",
            "failure_reason": "failure_reason5"
          },
          "delivery_details": {
            "recipient": {},
            "schedule_type": "ASAP",
            "placed_at": "placed_at9",
            "deliver_at": "deliver_at7",
            "prep_time_duration": "prep_time_duration1",
            "delivery_window_duration": "delivery_window_duration3",
            "note": "note5",
            "completed_at": "completed_at1",
            "in_progress_at": "in_progress_at5",
            "rejected_at": "rejected_at1",
            "ready_at": "ready_at9",
            "delivered_at": "delivered_at7",
            "canceled_at": "canceled_at5",
            "cancel_reason": "cancel_reason5",
            "courier_pickup_at": "courier_pickup_at1",
            "courier_pickup_window_duration": "courier_pickup_window_duration3",
            "is_no_contact_delivery": true,
            "dropoff_notes": "dropoff_notes3",
            "courier_provider_name": "courier_provider_name7",
            "courier_support_phone_number": "courier_support_phone_number5",
            "square_delivery_id": "square_delivery_id9",
            "external_delivery_id": "external_delivery_id3",
            "managed_delivery": true
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
              "quantity_unit": {},
              "note": "note8",
              "catalog_object_id": "catalog_object_id0",
              "catalog_version": 176,
              "variation_name": "variation_name6",
              "item_type": "CUSTOM_AMOUNT",
              "return_modifiers": [
                {
                  "uid": "uid5",
                  "source_modifier_uid": "source_modifier_uid1",
                  "catalog_object_id": "catalog_object_id1",
                  "catalog_version": 23,
                  "name": "name5",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity1"
                },
                {
                  "uid": "uid6",
                  "source_modifier_uid": "source_modifier_uid0",
                  "catalog_object_id": "catalog_object_id0",
                  "catalog_version": 22,
                  "name": "name6",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity2"
                },
                {
                  "uid": "uid7",
                  "source_modifier_uid": "source_modifier_uid9",
                  "catalog_object_id": "catalog_object_id9",
                  "catalog_version": 21,
                  "name": "name7",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity3"
                }
              ],
              "applied_taxes": [
                {},
                {},
                {}
              ],
              "applied_discounts": [
                {}
              ],
              "base_price_money": {},
              "variation_total_price_money": {},
              "gross_return_money": {},
              "total_tax_money": {},
              "total_discount_money": {},
              "total_money": {},
              "applied_service_charges": [
                {},
                {}
              ],
              "total_service_charge_money": {}
            }
          ],
          "return_service_charges": [
            {
              "uid": "uid0",
              "source_service_charge_uid": "source_service_charge_uid6",
              "name": "name0",
              "catalog_object_id": "catalog_object_id6",
              "catalog_version": 62,
              "percentage": "percentage8",
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
              "uid": "uid1",
              "source_service_charge_uid": "source_service_charge_uid5",
              "name": "name1",
              "catalog_object_id": "catalog_object_id5",
              "catalog_version": 61,
              "percentage": "percentage9",
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
              "uid": "uid9",
              "source_tax_uid": "source_tax_uid7",
              "catalog_object_id": "catalog_object_id7",
              "catalog_version": 203,
              "name": "name9",
              "type": "ADDITIVE",
              "percentage": "percentage7",
              "applied_money": {},
              "scope": "LINE_ITEM"
            },
            {
              "uid": "uid8",
              "source_tax_uid": "source_tax_uid6",
              "catalog_object_id": "catalog_object_id8",
              "catalog_version": 204,
              "name": "name8",
              "type": "INCLUSIVE",
              "percentage": "percentage6",
              "applied_money": {},
              "scope": "ORDER"
            },
            {
              "uid": "uid7",
              "source_tax_uid": "source_tax_uid5",
              "catalog_object_id": "catalog_object_id9",
              "catalog_version": 205,
              "name": "name7",
              "type": "UNKNOWN_TAX",
              "percentage": "percentage5",
              "applied_money": {},
              "scope": "OTHER_TAX_SCOPE"
            }
          ],
          "return_discounts": [
            {
              "uid": "uid7",
              "source_discount_uid": "source_discount_uid3",
              "catalog_object_id": "catalog_object_id9",
              "catalog_version": 165,
              "name": "name7",
              "type": "VARIABLE_PERCENTAGE",
              "percentage": "percentage5",
              "amount_money": {},
              "applied_money": {},
              "scope": "ORDER"
            },
            {
              "uid": "uid8",
              "source_discount_uid": "source_discount_uid2",
              "catalog_object_id": "catalog_object_id8",
              "catalog_version": 164,
              "name": "name8",
              "type": "FIXED_AMOUNT",
              "percentage": "percentage6",
              "amount_money": {},
              "applied_money": {},
              "scope": "LINE_ITEM"
            },
            {
              "uid": "uid9",
              "source_discount_uid": "source_discount_uid1",
              "catalog_object_id": "catalog_object_id7",
              "catalog_version": 163,
              "name": "name9",
              "type": "FIXED_PERCENTAGE",
              "percentage": "percentage7",
              "amount_money": {},
              "applied_money": {},
              "scope": "OTHER_DISCOUNT_SCOPE"
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
        },
        {
          "uid": "uid0",
          "source_order_id": "source_order_id2",
          "return_line_items": [
            {
              "uid": "uid5",
              "source_line_item_uid": "source_line_item_uid7",
              "name": "name5",
              "quantity": "quantity1",
              "quantity_unit": {},
              "note": "note9",
              "catalog_object_id": "catalog_object_id1",
              "catalog_version": 177,
              "variation_name": "variation_name5",
              "item_type": "ITEM",
              "return_modifiers": [
                {
                  "uid": "uid6",
                  "source_modifier_uid": "source_modifier_uid0",
                  "catalog_object_id": "catalog_object_id0",
                  "catalog_version": 22,
                  "name": "name6",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity2"
                }
              ],
              "applied_taxes": [
                {},
                {}
              ],
              "applied_discounts": [
                {},
                {},
                {}
              ],
              "base_price_money": {},
              "variation_total_price_money": {},
              "gross_return_money": {},
              "total_tax_money": {},
              "total_discount_money": {},
              "total_money": {},
              "applied_service_charges": [
                {},
                {},
                {}
              ],
              "total_service_charge_money": {}
            },
            {
              "uid": "uid4",
              "source_line_item_uid": "source_line_item_uid8",
              "name": "name4",
              "quantity": "quantity0",
              "quantity_unit": {},
              "note": "note0",
              "catalog_object_id": "catalog_object_id2",
              "catalog_version": 178,
              "variation_name": "variation_name4",
              "item_type": "GIFT_CARD",
              "return_modifiers": [
                {
                  "uid": "uid7",
                  "source_modifier_uid": "source_modifier_uid9",
                  "catalog_object_id": "catalog_object_id9",
                  "catalog_version": 21,
                  "name": "name7",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity3"
                },
                {
                  "uid": "uid8",
                  "source_modifier_uid": "source_modifier_uid8",
                  "catalog_object_id": "catalog_object_id8",
                  "catalog_version": 20,
                  "name": "name8",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity4"
                }
              ],
              "applied_taxes": [
                {}
              ],
              "applied_discounts": [
                {},
                {}
              ],
              "base_price_money": {},
              "variation_total_price_money": {},
              "gross_return_money": {},
              "total_tax_money": {},
              "total_discount_money": {},
              "total_money": {},
              "applied_service_charges": [
                {}
              ],
              "total_service_charge_money": {}
            }
          ],
          "return_service_charges": [
            {
              "uid": "uid1",
              "source_service_charge_uid": "source_service_charge_uid5",
              "name": "name1",
              "catalog_object_id": "catalog_object_id5",
              "catalog_version": 61,
              "percentage": "percentage9",
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
            },
            {
              "uid": "uid2",
              "source_service_charge_uid": "source_service_charge_uid4",
              "name": "name2",
              "catalog_object_id": "catalog_object_id4",
              "catalog_version": 60,
              "percentage": "percentage0",
              "amount_money": {},
              "applied_money": {},
              "total_money": {},
              "total_tax_money": {},
              "calculation_phase": "SUBTOTAL_PHASE",
              "taxable": false,
              "applied_taxes": [
                {},
                {},
                {}
              ],
              "treatment_type": "LINE_ITEM_TREATMENT",
              "scope": "LINE_ITEM"
            },
            {
              "uid": "uid3",
              "source_service_charge_uid": "source_service_charge_uid3",
              "name": "name3",
              "catalog_object_id": "catalog_object_id3",
              "catalog_version": 59,
              "percentage": "percentage1",
              "amount_money": {},
              "applied_money": {},
              "total_money": {},
              "total_tax_money": {},
              "calculation_phase": "TOTAL_PHASE",
              "taxable": true,
              "applied_taxes": [
                {}
              ],
              "treatment_type": "APPORTIONED_TREATMENT",
              "scope": "OTHER_SERVICE_CHARGE_SCOPE"
            }
          ],
          "return_taxes": [
            {
              "uid": "uid8",
              "source_tax_uid": "source_tax_uid6",
              "catalog_object_id": "catalog_object_id8",
              "catalog_version": 204,
              "name": "name8",
              "type": "INCLUSIVE",
              "percentage": "percentage6",
              "applied_money": {},
              "scope": "ORDER"
            }
          ],
          "return_discounts": [
            {
              "uid": "uid6",
              "source_discount_uid": "source_discount_uid4",
              "catalog_object_id": "catalog_object_id0",
              "catalog_version": 166,
              "name": "name6",
              "type": "VARIABLE_AMOUNT",
              "percentage": "percentage4",
              "amount_money": {},
              "applied_money": {},
              "scope": "OTHER_DISCOUNT_SCOPE"
            },
            {
              "uid": "uid7",
              "source_discount_uid": "source_discount_uid3",
              "catalog_object_id": "catalog_object_id9",
              "catalog_version": 165,
              "name": "name7",
              "type": "VARIABLE_PERCENTAGE",
              "percentage": "percentage5",
              "amount_money": {},
              "applied_money": {},
              "scope": "ORDER"
            }
          ],
          "rounding_adjustment": {
            "uid": "uid2",
            "name": "name2",
            "amount_money": {}
          },
          "return_amounts": {
            "total_money": {},
            "tax_money": {},
            "discount_money": {},
            "tip_money": {},
            "service_charge_money": {}
          }
        },
        {
          "uid": "uid1",
          "source_order_id": "source_order_id1",
          "return_line_items": [
            {
              "uid": "uid4",
              "source_line_item_uid": "source_line_item_uid8",
              "name": "name4",
              "quantity": "quantity0",
              "quantity_unit": {},
              "note": "note0",
              "catalog_object_id": "catalog_object_id2",
              "catalog_version": 178,
              "variation_name": "variation_name4",
              "item_type": "GIFT_CARD",
              "return_modifiers": [
                {
                  "uid": "uid7",
                  "source_modifier_uid": "source_modifier_uid9",
                  "catalog_object_id": "catalog_object_id9",
                  "catalog_version": 21,
                  "name": "name7",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity3"
                },
                {
                  "uid": "uid8",
                  "source_modifier_uid": "source_modifier_uid8",
                  "catalog_object_id": "catalog_object_id8",
                  "catalog_version": 20,
                  "name": "name8",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity4"
                }
              ],
              "applied_taxes": [
                {}
              ],
              "applied_discounts": [
                {},
                {}
              ],
              "base_price_money": {},
              "variation_total_price_money": {},
              "gross_return_money": {},
              "total_tax_money": {},
              "total_discount_money": {},
              "total_money": {},
              "applied_service_charges": [
                {}
              ],
              "total_service_charge_money": {}
            },
            {
              "uid": "uid3",
              "source_line_item_uid": "source_line_item_uid9",
              "name": "name3",
              "quantity": "quantity9",
              "quantity_unit": {},
              "note": "note1",
              "catalog_object_id": "catalog_object_id3",
              "catalog_version": 179,
              "variation_name": "variation_name3",
              "item_type": "CUSTOM_AMOUNT",
              "return_modifiers": [
                {
                  "uid": "uid8",
                  "source_modifier_uid": "source_modifier_uid8",
                  "catalog_object_id": "catalog_object_id8",
                  "catalog_version": 20,
                  "name": "name8",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity4"
                },
                {
                  "uid": "uid9",
                  "source_modifier_uid": "source_modifier_uid7",
                  "catalog_object_id": "catalog_object_id7",
                  "catalog_version": 19,
                  "name": "name9",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity5"
                },
                {
                  "uid": "uid0",
                  "source_modifier_uid": "source_modifier_uid6",
                  "catalog_object_id": "catalog_object_id6",
                  "catalog_version": 18,
                  "name": "name0",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity6"
                }
              ],
              "applied_taxes": [
                {},
                {},
                {}
              ],
              "applied_discounts": [
                {}
              ],
              "base_price_money": {},
              "variation_total_price_money": {},
              "gross_return_money": {},
              "total_tax_money": {},
              "total_discount_money": {},
              "total_money": {},
              "applied_service_charges": [
                {},
                {}
              ],
              "total_service_charge_money": {}
            },
            {
              "uid": "uid2",
              "source_line_item_uid": "source_line_item_uid0",
              "name": "name2",
              "quantity": "quantity8",
              "quantity_unit": {},
              "note": "note2",
              "catalog_object_id": "catalog_object_id4",
              "catalog_version": 180,
              "variation_name": "variation_name2",
              "item_type": "ITEM",
              "return_modifiers": [
                {
                  "uid": "uid9",
                  "source_modifier_uid": "source_modifier_uid7",
                  "catalog_object_id": "catalog_object_id7",
                  "catalog_version": 19,
                  "name": "name9",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity5"
                }
              ],
              "applied_taxes": [
                {},
                {}
              ],
              "applied_discounts": [
                {},
                {},
                {}
              ],
              "base_price_money": {},
              "variation_total_price_money": {},
              "gross_return_money": {},
              "total_tax_money": {},
              "total_discount_money": {},
              "total_money": {},
              "applied_service_charges": [
                {},
                {},
                {}
              ],
              "total_service_charge_money": {}
            }
          ],
          "return_service_charges": [
            {
              "uid": "uid2",
              "source_service_charge_uid": "source_service_charge_uid4",
              "name": "name2",
              "catalog_object_id": "catalog_object_id4",
              "catalog_version": 60,
              "percentage": "percentage0",
              "amount_money": {},
              "applied_money": {},
              "total_money": {},
              "total_tax_money": {},
              "calculation_phase": "SUBTOTAL_PHASE",
              "taxable": false,
              "applied_taxes": [
                {},
                {},
                {}
              ],
              "treatment_type": "LINE_ITEM_TREATMENT",
              "scope": "LINE_ITEM"
            }
          ],
          "return_taxes": [
            {
              "uid": "uid7",
              "source_tax_uid": "source_tax_uid5",
              "catalog_object_id": "catalog_object_id9",
              "catalog_version": 205,
              "name": "name7",
              "type": "UNKNOWN_TAX",
              "percentage": "percentage5",
              "applied_money": {},
              "scope": "OTHER_TAX_SCOPE"
            },
            {
              "uid": "uid6",
              "source_tax_uid": "source_tax_uid4",
              "catalog_object_id": "catalog_object_id0",
              "catalog_version": 206,
              "name": "name6",
              "type": "ADDITIVE",
              "percentage": "percentage4",
              "applied_money": {},
              "scope": "LINE_ITEM"
            }
          ],
          "return_discounts": [
            {
              "uid": "uid5",
              "source_discount_uid": "source_discount_uid5",
              "catalog_object_id": "catalog_object_id1",
              "catalog_version": 167,
              "name": "name5",
              "type": "UNKNOWN_DISCOUNT",
              "percentage": "percentage3",
              "amount_money": {},
              "applied_money": {},
              "scope": "LINE_ITEM"
            }
          ],
          "rounding_adjustment": {
            "uid": "uid3",
            "name": "name3",
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
      "return_amounts": {},
      "net_amounts": {},
      "rounding_adjustment": {},
      "tenders": [
        {
          "id": "id8",
          "location_id": "location_id2",
          "transaction_id": "transaction_id6",
          "created_at": "created_at6",
          "note": "note4",
          "amount_money": {},
          "tip_money": {},
          "processing_fee_money": {},
          "customer_id": "customer_id6",
          "type": "CARD",
          "card_details": {
            "status": "VOIDED",
            "card": {
              "id": "id0",
              "card_brand": "INTERAC",
              "last_4": "last_42",
              "exp_month": 210,
              "exp_year": 86,
              "cardholder_name": "cardholder_name4",
              "billing_address": {},
              "fingerprint": "fingerprint6",
              "customer_id": "customer_id8",
              "merchant_id": "merchant_id0",
              "reference_id": "reference_id2",
              "enabled": false,
              "card_type": "UNKNOWN_CARD_TYPE",
              "prepaid_type": "PREPAID",
              "bin": "bin0",
              "version": 84,
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
              "location_id": "location_id1",
              "description": "description7",
              "amount_money": {},
              "receivable_id": "receivable_id7"
            },
            {
              "location_id": "location_id2",
              "description": "description8",
              "amount_money": {},
              "receivable_id": "receivable_id8"
            }
          ],
          "payment_id": "payment_id8"
        },
        {
          "id": "id9",
          "location_id": "location_id3",
          "transaction_id": "transaction_id7",
          "created_at": "created_at7",
          "note": "note5",
          "amount_money": {},
          "tip_money": {},
          "processing_fee_money": {},
          "customer_id": "customer_id7",
          "type": "CASH",
          "card_details": {
            "status": "CAPTURED",
            "card": {
              "id": "id1",
              "card_brand": "SQUARE_CAPITAL_CARD",
              "last_4": "last_43",
              "exp_month": 209,
              "exp_year": 87,
              "cardholder_name": "cardholder_name3",
              "billing_address": {},
              "fingerprint": "fingerprint7",
              "customer_id": "customer_id9",
              "merchant_id": "merchant_id1",
              "reference_id": "reference_id1",
              "enabled": true,
              "card_type": "DEBIT",
              "prepaid_type": "UNKNOWN_PREPAID_TYPE",
              "bin": "bin1",
              "version": 83,
              "card_co_brand": "UNKNOWN"
            },
            "entry_method": "ON_FILE"
          },
          "cash_details": {
            "buyer_tendered_money": {},
            "change_back_money": {}
          },
          "additional_recipients": [
            {
              "location_id": "location_id2",
              "description": "description8",
              "amount_money": {},
              "receivable_id": "receivable_id8"
            },
            {
              "location_id": "location_id3",
              "description": "description9",
              "amount_money": {},
              "receivable_id": "receivable_id9"
            },
            {
              "location_id": "location_id4",
              "description": "description0",
              "amount_money": {},
              "receivable_id": "receivable_id0"
            }
          ],
          "payment_id": "payment_id9"
        }
      ],
      "refunds": [
        {
          "id": "id8",
          "location_id": "location_id2",
          "transaction_id": "transaction_id6",
          "tender_id": "tender_id6",
          "created_at": "created_at6",
          "reason": "reason6",
          "amount_money": {},
          "status": "REJECTED",
          "processing_fee_money": {},
          "additional_recipients": [
            {},
            {}
          ]
        }
      ],
      "metadata": {
        "key0": "metadata7"
      },
      "created_at": "created_at4",
      "updated_at": "updated_at8",
      "closed_at": "closed_at8",
      "state": "CANCELED",
      "version": 66,
      "total_money": {},
      "total_tax_money": {},
      "total_discount_money": {},
      "total_tip_money": {},
      "total_service_charge_money": {},
      "ticket_name": "ticket_name0",
      "pricing_options": {
        "auto_apply_discounts": false,
        "auto_apply_taxes": false
      },
      "rewards": [
        {
          "id": "id1",
          "reward_tier_id": "reward_tier_id7"
        },
        {
          "id": "id2",
          "reward_tier_id": "reward_tier_id8"
        },
        {
          "id": "id3",
          "reward_tier_id": "reward_tier_id9"
        }
      ],
      "net_amount_due_money": {}
    },
    {
      "id": "id7",
      "location_id": "location_id1",
      "reference_id": "reference_id5",
      "source": {
        "name": "name7"
      },
      "customer_id": "customer_id5",
      "line_items": [
        {
          "uid": "uid2",
          "name": "name2",
          "quantity": "quantity8",
          "quantity_unit": {
            "measurement_unit": {
              "custom_unit": {
                "name": "name0",
                "abbreviation": "abbreviation2"
              },
              "area_unit": "IMPERIAL_SQUARE_MILE",
              "length_unit": "METRIC_MILLIMETER",
              "volume_unit": "IMPERIAL_CUBIC_YARD",
              "weight_unit": "IMPERIAL_STONE",
              "generic_unit": "UNIT",
              "time_unit": "GENERIC_DAY",
              "type": "TYPE_LENGTH"
            },
            "precision": 216,
            "catalog_object_id": "catalog_object_id8",
            "catalog_version": 106
          },
          "note": "note2",
          "catalog_object_id": "catalog_object_id4",
          "catalog_version": 220,
          "variation_name": "variation_name2",
          "item_type": "CUSTOM_AMOUNT",
          "metadata": {
            "key0": "metadata1",
            "key1": "metadata2"
          },
          "modifiers": [
            {
              "uid": "uid3",
              "catalog_object_id": "catalog_object_id7",
              "catalog_version": 159,
              "name": "name3",
              "quantity": "quantity9",
              "base_price_money": {
                "amount": 81,
                "currency": "CNY"
              },
              "total_price_money": {
                "amount": 79,
                "currency": "PLN"
              },
              "metadata": {
                "key0": "metadata0",
                "key1": "metadata9"
              }
            },
            {
              "uid": "uid4",
              "catalog_object_id": "catalog_object_id8",
              "catalog_version": 158,
              "name": "name4",
              "quantity": "quantity0",
              "base_price_money": {
                "amount": 82,
                "currency": "COP"
              },
              "total_price_money": {
                "amount": 80,
                "currency": "PYG"
              },
              "metadata": {
                "key0": "metadata1"
              }
            },
            {
              "uid": "uid5",
              "catalog_object_id": "catalog_object_id9",
              "catalog_version": 157,
              "name": "name5",
              "quantity": "quantity1",
              "base_price_money": {
                "amount": 83,
                "currency": "COU"
              },
              "total_price_money": {
                "amount": 81,
                "currency": "QAR"
              },
              "metadata": {
                "key0": "metadata2",
                "key1": "metadata1",
                "key2": "metadata0"
              }
            }
          ],
          "applied_taxes": [
            {
              "uid": "uid2",
              "tax_uid": "tax_uid2",
              "applied_money": {}
            },
            {
              "uid": "uid3",
              "tax_uid": "tax_uid1",
              "applied_money": {}
            },
            {
              "uid": "uid4",
              "tax_uid": "tax_uid0",
              "applied_money": {}
            }
          ],
          "applied_discounts": [
            {
              "uid": "uid6",
              "discount_uid": "discount_uid8",
              "applied_money": {}
            }
          ],
          "applied_service_charges": [
            {
              "uid": "uid9",
              "service_charge_uid": "service_charge_uid9",
              "applied_money": {}
            },
            {
              "uid": "uid0",
              "service_charge_uid": "service_charge_uid0",
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
                "uid": "uid5",
                "discount_uid": "discount_uid1",
                "discount_catalog_object_id": "discount_catalog_object_id7"
              },
              {
                "uid": "uid6",
                "discount_uid": "discount_uid2",
                "discount_catalog_object_id": "discount_catalog_object_id8"
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
          "uid": "uid3",
          "name": "name3",
          "quantity": "quantity9",
          "quantity_unit": {
            "measurement_unit": {
              "custom_unit": {
                "name": "name1",
                "abbreviation": "abbreviation3"
              },
              "area_unit": "METRIC_SQUARE_CENTIMETER",
              "length_unit": "IMPERIAL_MILE",
              "volume_unit": "METRIC_MILLILITER",
              "weight_unit": "IMPERIAL_POUND",
              "generic_unit": "UNIT",
              "time_unit": "GENERIC_HOUR",
              "type": "TYPE_AREA"
            },
            "precision": 217,
            "catalog_object_id": "catalog_object_id7",
            "catalog_version": 105
          },
          "note": "note1",
          "catalog_object_id": "catalog_object_id3",
          "catalog_version": 219,
          "variation_name": "variation_name3",
          "item_type": "GIFT_CARD",
          "metadata": {
            "key0": "metadata0"
          },
          "modifiers": [
            {
              "uid": "uid4",
              "catalog_object_id": "catalog_object_id8",
              "catalog_version": 158,
              "name": "name4",
              "quantity": "quantity0",
              "base_price_money": {
                "amount": 82,
                "currency": "COP"
              },
              "total_price_money": {
                "amount": 80,
                "currency": "PYG"
              },
              "metadata": {
                "key0": "metadata1"
              }
            }
          ],
          "applied_taxes": [
            {
              "uid": "uid3",
              "tax_uid": "tax_uid1",
              "applied_money": {}
            }
          ],
          "applied_discounts": [
            {
              "uid": "uid7",
              "discount_uid": "discount_uid7",
              "applied_money": {}
            },
            {
              "uid": "uid8",
              "discount_uid": "discount_uid6",
              "applied_money": {}
            }
          ],
          "applied_service_charges": [
            {
              "uid": "uid8",
              "service_charge_uid": "service_charge_uid8",
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
                "uid": "uid6",
                "discount_uid": "discount_uid2",
                "discount_catalog_object_id": "discount_catalog_object_id8"
              },
              {
                "uid": "uid7",
                "discount_uid": "discount_uid3",
                "discount_catalog_object_id": "discount_catalog_object_id9"
              },
              {
                "uid": "uid8",
                "discount_uid": "discount_uid4",
                "discount_catalog_object_id": "discount_catalog_object_id0"
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
          "uid": "uid4",
          "name": "name4",
          "quantity": "quantity0",
          "quantity_unit": {
            "measurement_unit": {
              "custom_unit": {
                "name": "name2",
                "abbreviation": "abbreviation4"
              },
              "area_unit": "METRIC_SQUARE_METER",
              "length_unit": "IMPERIAL_YARD",
              "volume_unit": "METRIC_LITER",
              "weight_unit": "IMPERIAL_WEIGHT_OUNCE",
              "generic_unit": "UNIT",
              "time_unit": "GENERIC_MINUTE",
              "type": "TYPE_CUSTOM"
            },
            "precision": 218,
            "catalog_object_id": "catalog_object_id6",
            "catalog_version": 104
          },
          "note": "note0",
          "catalog_object_id": "catalog_object_id2",
          "catalog_version": 218,
          "variation_name": "variation_name4",
          "item_type": "ITEM",
          "metadata": {
            "key0": "metadata9",
            "key1": "metadata0",
            "key2": "metadata1"
          },
          "modifiers": [
            {
              "uid": "uid5",
              "catalog_object_id": "catalog_object_id9",
              "catalog_version": 157,
              "name": "name5",
              "quantity": "quantity1",
              "base_price_money": {
                "amount": 83,
                "currency": "COU"
              },
              "total_price_money": {
                "amount": 81,
                "currency": "QAR"
              },
              "metadata": {
                "key0": "metadata2",
                "key1": "metadata1",
                "key2": "metadata0"
              }
            },
            {
              "uid": "uid6",
              "catalog_object_id": "catalog_object_id0",
              "catalog_version": 156,
              "name": "name6",
              "quantity": "quantity2",
              "base_price_money": {
                "amount": 84,
                "currency": "CRC"
              },
              "total_price_money": {
                "amount": 82,
                "currency": "RON"
              },
              "metadata": {
                "key0": "metadata3",
                "key1": "metadata2"
              }
            }
          ],
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
          "applied_discounts": [
            {
              "uid": "uid8",
              "discount_uid": "discount_uid6",
              "applied_money": {}
            },
            {
              "uid": "uid9",
              "discount_uid": "discount_uid5",
              "applied_money": {}
            },
            {
              "uid": "uid0",
              "discount_uid": "discount_uid4",
              "applied_money": {}
            }
          ],
          "applied_service_charges": [
            {
              "uid": "uid7",
              "service_charge_uid": "service_charge_uid7",
              "applied_money": {}
            },
            {
              "uid": "uid8",
              "service_charge_uid": "service_charge_uid8",
              "applied_money": {}
            },
            {
              "uid": "uid9",
              "service_charge_uid": "service_charge_uid9",
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
                "uid": "uid7",
                "discount_uid": "discount_uid3",
                "discount_catalog_object_id": "discount_catalog_object_id9"
              }
            ],
            "blocked_taxes": [
              {
                "uid": "uid5",
                "tax_uid": "tax_uid9",
                "tax_catalog_object_id": "tax_catalog_object_id9"
              }
            ]
          },
          "total_service_charge_money": {}
        }
      ],
      "taxes": [
        {
          "uid": "uid8",
          "catalog_object_id": "catalog_object_id8",
          "catalog_version": 22,
          "name": "name8",
          "type": "UNKNOWN_TAX",
          "percentage": "percentage6",
          "metadata": {
            "key0": "metadata5"
          },
          "applied_money": {},
          "scope": "OTHER_TAX_SCOPE",
          "auto_applied": false
        },
        {
          "uid": "uid9",
          "catalog_object_id": "catalog_object_id7",
          "catalog_version": 21,
          "name": "name9",
          "type": "INCLUSIVE",
          "percentage": "percentage7",
          "metadata": {
            "key0": "metadata4",
            "key1": "metadata5",
            "key2": "metadata6"
          },
          "applied_money": {},
          "scope": "ORDER",
          "auto_applied": true
        }
      ],
      "discounts": [
        {
          "uid": "uid8",
          "catalog_object_id": "catalog_object_id2",
          "catalog_version": 48,
          "name": "name8",
          "type": "VARIABLE_PERCENTAGE",
          "percentage": "percentage6",
          "amount_money": {},
          "applied_money": {},
          "metadata": {
            "key0": "metadata1",
            "key1": "metadata0"
          },
          "scope": "LINE_ITEM",
          "reward_ids": [
            "reward_ids5"
          ],
          "pricing_rule_id": "pricing_rule_id0"
        },
        {
          "uid": "uid9",
          "catalog_object_id": "catalog_object_id3",
          "catalog_version": 49,
          "name": "name9",
          "type": "VARIABLE_AMOUNT",
          "percentage": "percentage7",
          "amount_money": {},
          "applied_money": {},
          "metadata": {
            "key0": "metadata0",
            "key1": "metadata9",
            "key2": "metadata8"
          },
          "scope": "ORDER",
          "reward_ids": [
            "reward_ids6",
            "reward_ids7"
          ],
          "pricing_rule_id": "pricing_rule_id1"
        },
        {
          "uid": "uid0",
          "catalog_object_id": "catalog_object_id4",
          "catalog_version": 50,
          "name": "name0",
          "type": "UNKNOWN_DISCOUNT",
          "percentage": "percentage8",
          "amount_money": {},
          "applied_money": {},
          "metadata": {
            "key0": "metadata9"
          },
          "scope": "OTHER_DISCOUNT_SCOPE",
          "reward_ids": [
            "reward_ids7",
            "reward_ids8",
            "reward_ids9"
          ],
          "pricing_rule_id": "pricing_rule_id2"
        }
      ],
      "service_charges": [
        {
          "uid": "uid8",
          "name": "name8",
          "catalog_object_id": "catalog_object_id8",
          "catalog_version": 12,
          "percentage": "percentage6",
          "amount_money": {},
          "applied_money": {},
          "total_money": {},
          "total_tax_money": {},
          "calculation_phase": "SUBTOTAL_PHASE",
          "taxable": false,
          "applied_taxes": [
            {}
          ],
          "metadata": {
            "key0": "metadata5"
          },
          "type": "AUTO_GRATUITY",
          "treatment_type": "LINE_ITEM_TREATMENT",
          "scope": "OTHER_SERVICE_CHARGE_SCOPE"
        },
        {
          "uid": "uid7",
          "name": "name7",
          "catalog_object_id": "catalog_object_id9",
          "catalog_version": 13,
          "percentage": "percentage5",
          "amount_money": {},
          "applied_money": {},
          "total_money": {},
          "total_tax_money": {},
          "calculation_phase": "APPORTIONED_AMOUNT_PHASE",
          "taxable": true,
          "applied_taxes": [
            {},
            {},
            {}
          ],
          "metadata": {
            "key0": "metadata6",
            "key1": "metadata7"
          },
          "type": "CUSTOM",
          "treatment_type": "APPORTIONED_TREATMENT",
          "scope": "LINE_ITEM"
        },
        {
          "uid": "uid6",
          "name": "name6",
          "catalog_object_id": "catalog_object_id0",
          "catalog_version": 14,
          "percentage": "percentage4",
          "amount_money": {},
          "applied_money": {},
          "total_money": {},
          "total_tax_money": {},
          "calculation_phase": "APPORTIONED_PERCENTAGE_PHASE",
          "taxable": false,
          "applied_taxes": [
            {},
            {}
          ],
          "metadata": {
            "key0": "metadata7",
            "key1": "metadata8",
            "key2": "metadata9"
          },
          "type": "AUTO_GRATUITY",
          "treatment_type": "LINE_ITEM_TREATMENT",
          "scope": "ORDER"
        }
      ],
      "fulfillments": [
        {
          "uid": "uid3",
          "type": "SHIPMENT",
          "state": "RESERVED",
          "line_item_application": "ENTRY_LIST",
          "entries": [
            {
              "uid": "uid8",
              "line_item_uid": "line_item_uid8",
              "quantity": "quantity4",
              "metadata": {
                "key0": "metadata5",
                "key1": "metadata6",
                "key2": "metadata7"
              }
            }
          ],
          "metadata": {
            "key0": "metadata0",
            "key1": "metadata9",
            "key2": "metadata8"
          },
          "pickup_details": {
            "recipient": {
              "customer_id": "customer_id1",
              "display_name": "display_name3",
              "email_address": "email_address1",
              "phone_number": "phone_number1",
              "address": {
                "address_line_1": "address_line_19",
                "address_line_2": "address_line_29",
                "address_line_3": "address_line_35",
                "locality": "locality9",
                "sublocality": "sublocality9",
                "sublocality_2": "sublocality_27",
                "sublocality_3": "sublocality_39",
                "administrative_district_level_1": "administrative_district_level_13",
                "administrative_district_level_2": "administrative_district_level_25",
                "administrative_district_level_3": "administrative_district_level_37",
                "postal_code": "postal_code1",
                "country": "LT",
                "first_name": "first_name9",
                "last_name": "last_name7"
              }
            },
            "expires_at": "expires_at5",
            "auto_complete_duration": "auto_complete_duration5",
            "schedule_type": "ASAP",
            "pickup_at": "pickup_at7",
            "pickup_window_duration": "pickup_window_duration1",
            "prep_time_duration": "prep_time_duration3",
            "note": "note7",
            "placed_at": "placed_at1",
            "accepted_at": "accepted_at5",
            "rejected_at": "rejected_at3",
            "ready_at": "ready_at1",
            "expired_at": "expired_at1",
            "picked_up_at": "picked_up_at1",
            "canceled_at": "canceled_at7",
            "cancel_reason": "cancel_reason7",
            "is_curbside_pickup": true,
            "curbside_pickup_details": {
              "curbside_details": "curbside_details3",
              "buyer_arrived_at": "buyer_arrived_at9"
            }
          },
          "shipment_details": {
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
                "country": "MX",
                "first_name": "first_name3",
                "last_name": "last_name1"
              }
            },
            "carrier": "carrier7",
            "shipping_note": "shipping_note1",
            "shipping_type": "shipping_type1",
            "tracking_number": "tracking_number3",
            "tracking_url": "tracking_url5",
            "placed_at": "placed_at5",
            "in_progress_at": "in_progress_at9",
            "packaged_at": "packaged_at9",
            "expected_shipped_at": "expected_shipped_at9",
            "shipped_at": "shipped_at3",
            "canceled_at": "canceled_at1",
            "cancel_reason": "cancel_reason1",
            "failed_at": "failed_at9",
            "failure_reason": "failure_reason5"
          },
          "delivery_details": {
            "recipient": {},
            "schedule_type": "ASAP",
            "placed_at": "placed_at9",
            "deliver_at": "deliver_at7",
            "prep_time_duration": "prep_time_duration1",
            "delivery_window_duration": "delivery_window_duration3",
            "note": "note5",
            "completed_at": "completed_at1",
            "in_progress_at": "in_progress_at5",
            "rejected_at": "rejected_at1",
            "ready_at": "ready_at9",
            "delivered_at": "delivered_at7",
            "canceled_at": "canceled_at5",
            "cancel_reason": "cancel_reason5",
            "courier_pickup_at": "courier_pickup_at1",
            "courier_pickup_window_duration": "courier_pickup_window_duration3",
            "is_no_contact_delivery": true,
            "dropoff_notes": "dropoff_notes3",
            "courier_provider_name": "courier_provider_name7",
            "courier_support_phone_number": "courier_support_phone_number5",
            "square_delivery_id": "square_delivery_id9",
            "external_delivery_id": "external_delivery_id3",
            "managed_delivery": true
          }
        },
        {
          "uid": "uid4",
          "type": "DELIVERY",
          "state": "PREPARED",
          "line_item_application": "ALL",
          "entries": [
            {
              "uid": "uid9",
              "line_item_uid": "line_item_uid9",
              "quantity": "quantity5",
              "metadata": {
                "key0": "metadata4",
                "key1": "metadata5"
              }
            },
            {
              "uid": "uid0",
              "line_item_uid": "line_item_uid0",
              "quantity": "quantity6",
              "metadata": {
                "key0": "metadata3"
              }
            }
          ],
          "metadata": {
            "key0": "metadata1",
            "key1": "metadata0"
          },
          "pickup_details": {
            "recipient": {
              "customer_id": "customer_id2",
              "display_name": "display_name4",
              "email_address": "email_address2",
              "phone_number": "phone_number2",
              "address": {
                "address_line_1": "address_line_10",
                "address_line_2": "address_line_20",
                "address_line_3": "address_line_36",
                "locality": "locality0",
                "sublocality": "sublocality0",
                "sublocality_2": "sublocality_28",
                "sublocality_3": "sublocality_30",
                "administrative_district_level_1": "administrative_district_level_14",
                "administrative_district_level_2": "administrative_district_level_26",
                "administrative_district_level_3": "administrative_district_level_38",
                "postal_code": "postal_code2",
                "country": "LU",
                "first_name": "first_name0",
                "last_name": "last_name8"
              }
            },
            "expires_at": "expires_at6",
            "auto_complete_duration": "auto_complete_duration6",
            "schedule_type": "SCHEDULED",
            "pickup_at": "pickup_at8",
            "pickup_window_duration": "pickup_window_duration2",
            "prep_time_duration": "prep_time_duration4",
            "note": "note8",
            "placed_at": "placed_at2",
            "accepted_at": "accepted_at6",
            "rejected_at": "rejected_at4",
            "ready_at": "ready_at2",
            "expired_at": "expired_at2",
            "picked_up_at": "picked_up_at2",
            "canceled_at": "canceled_at8",
            "cancel_reason": "cancel_reason8",
            "is_curbside_pickup": false,
            "curbside_pickup_details": {
              "curbside_details": "curbside_details4",
              "buyer_arrived_at": "buyer_arrived_at0"
            }
          },
          "shipment_details": {
            "recipient": {
              "customer_id": "customer_id6",
              "display_name": "display_name8",
              "email_address": "email_address6",
              "phone_number": "phone_number4",
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
                "country": "MY",
                "first_name": "first_name4",
                "last_name": "last_name2"
              }
            },
            "carrier": "carrier8",
            "shipping_note": "shipping_note2",
            "shipping_type": "shipping_type0",
            "tracking_number": "tracking_number4",
            "tracking_url": "tracking_url6",
            "placed_at": "placed_at4",
            "in_progress_at": "in_progress_at8",
            "packaged_at": "packaged_at0",
            "expected_shipped_at": "expected_shipped_at0",
            "shipped_at": "shipped_at4",
            "canceled_at": "canceled_at2",
            "cancel_reason": "cancel_reason2",
            "failed_at": "failed_at0",
            "failure_reason": "failure_reason4"
          },
          "delivery_details": {
            "recipient": {},
            "schedule_type": "SCHEDULED",
            "placed_at": "placed_at0",
            "deliver_at": "deliver_at8",
            "prep_time_duration": "prep_time_duration2",
            "delivery_window_duration": "delivery_window_duration4",
            "note": "note6",
            "completed_at": "completed_at2",
            "in_progress_at": "in_progress_at6",
            "rejected_at": "rejected_at2",
            "ready_at": "ready_at0",
            "delivered_at": "delivered_at8",
            "canceled_at": "canceled_at6",
            "cancel_reason": "cancel_reason6",
            "courier_pickup_at": "courier_pickup_at2",
            "courier_pickup_window_duration": "courier_pickup_window_duration4",
            "is_no_contact_delivery": false,
            "dropoff_notes": "dropoff_notes4",
            "courier_provider_name": "courier_provider_name8",
            "courier_support_phone_number": "courier_support_phone_number6",
            "square_delivery_id": "square_delivery_id0",
            "external_delivery_id": "external_delivery_id4",
            "managed_delivery": false
          }
        },
        {
          "uid": "uid5",
          "type": "PICKUP",
          "state": "COMPLETED",
          "line_item_application": "ENTRY_LIST",
          "entries": [
            {
              "uid": "uid0",
              "line_item_uid": "line_item_uid0",
              "quantity": "quantity6",
              "metadata": {
                "key0": "metadata3"
              }
            },
            {
              "uid": "uid1",
              "line_item_uid": "line_item_uid1",
              "quantity": "quantity7",
              "metadata": {
                "key0": "metadata2",
                "key1": "metadata3",
                "key2": "metadata4"
              }
            },
            {
              "uid": "uid2",
              "line_item_uid": "line_item_uid2",
              "quantity": "quantity8",
              "metadata": {
                "key0": "metadata1",
                "key1": "metadata2"
              }
            }
          ],
          "metadata": {
            "key0": "metadata2"
          },
          "pickup_details": {
            "recipient": {
              "customer_id": "customer_id3",
              "display_name": "display_name5",
              "email_address": "email_address3",
              "phone_number": "phone_number3",
              "address": {
                "address_line_1": "address_line_11",
                "address_line_2": "address_line_21",
                "address_line_3": "address_line_37",
                "locality": "locality1",
                "sublocality": "sublocality1",
                "sublocality_2": "sublocality_29",
                "sublocality_3": "sublocality_31",
                "administrative_district_level_1": "administrative_district_level_15",
                "administrative_district_level_2": "administrative_district_level_27",
                "administrative_district_level_3": "administrative_district_level_39",
                "postal_code": "postal_code3",
                "country": "LV",
                "first_name": "first_name1",
                "last_name": "last_name9"
              }
            },
            "expires_at": "expires_at7",
            "auto_complete_duration": "auto_complete_duration7",
            "schedule_type": "ASAP",
            "pickup_at": "pickup_at9",
            "pickup_window_duration": "pickup_window_duration3",
            "prep_time_duration": "prep_time_duration5",
            "note": "note9",
            "placed_at": "placed_at3",
            "accepted_at": "accepted_at7",
            "rejected_at": "rejected_at5",
            "ready_at": "ready_at3",
            "expired_at": "expired_at3",
            "picked_up_at": "picked_up_at3",
            "canceled_at": "canceled_at9",
            "cancel_reason": "cancel_reason9",
            "is_curbside_pickup": true,
            "curbside_pickup_details": {
              "curbside_details": "curbside_details5",
              "buyer_arrived_at": "buyer_arrived_at1"
            }
          },
          "shipment_details": {
            "recipient": {
              "customer_id": "customer_id7",
              "display_name": "display_name9",
              "email_address": "email_address7",
              "phone_number": "phone_number3",
              "address": {
                "address_line_1": "address_line_15",
                "address_line_2": "address_line_25",
                "address_line_3": "address_line_31",
                "locality": "locality5",
                "sublocality": "sublocality5",
                "sublocality_2": "sublocality_23",
                "sublocality_3": "sublocality_35",
                "administrative_district_level_1": "administrative_district_level_19",
                "administrative_district_level_2": "administrative_district_level_21",
                "administrative_district_level_3": "administrative_district_level_33",
                "postal_code": "postal_code7",
                "country": "MZ",
                "first_name": "first_name5",
                "last_name": "last_name3"
              }
            },
            "carrier": "carrier9",
            "shipping_note": "shipping_note3",
            "shipping_type": "shipping_type9",
            "tracking_number": "tracking_number5",
            "tracking_url": "tracking_url7",
            "placed_at": "placed_at3",
            "in_progress_at": "in_progress_at7",
            "packaged_at": "packaged_at1",
            "expected_shipped_at": "expected_shipped_at1",
            "shipped_at": "shipped_at5",
            "canceled_at": "canceled_at3",
            "cancel_reason": "cancel_reason3",
            "failed_at": "failed_at1",
            "failure_reason": "failure_reason3"
          },
          "delivery_details": {
            "recipient": {},
            "schedule_type": "ASAP",
            "placed_at": "placed_at1",
            "deliver_at": "deliver_at9",
            "prep_time_duration": "prep_time_duration3",
            "delivery_window_duration": "delivery_window_duration5",
            "note": "note7",
            "completed_at": "completed_at3",
            "in_progress_at": "in_progress_at7",
            "rejected_at": "rejected_at3",
            "ready_at": "ready_at1",
            "delivered_at": "delivered_at9",
            "canceled_at": "canceled_at7",
            "cancel_reason": "cancel_reason7",
            "courier_pickup_at": "courier_pickup_at3",
            "courier_pickup_window_duration": "courier_pickup_window_duration5",
            "is_no_contact_delivery": true,
            "dropoff_notes": "dropoff_notes5",
            "courier_provider_name": "courier_provider_name9",
            "courier_support_phone_number": "courier_support_phone_number7",
            "square_delivery_id": "square_delivery_id1",
            "external_delivery_id": "external_delivery_id5",
            "managed_delivery": true
          }
        }
      ],
      "returns": [
        {
          "uid": "uid0",
          "source_order_id": "source_order_id2",
          "return_line_items": [
            {
              "uid": "uid5",
              "source_line_item_uid": "source_line_item_uid7",
              "name": "name5",
              "quantity": "quantity1",
              "quantity_unit": {},
              "note": "note9",
              "catalog_object_id": "catalog_object_id1",
              "catalog_version": 177,
              "variation_name": "variation_name5",
              "item_type": "ITEM",
              "return_modifiers": [
                {
                  "uid": "uid6",
                  "source_modifier_uid": "source_modifier_uid0",
                  "catalog_object_id": "catalog_object_id0",
                  "catalog_version": 22,
                  "name": "name6",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity2"
                }
              ],
              "applied_taxes": [
                {},
                {}
              ],
              "applied_discounts": [
                {},
                {},
                {}
              ],
              "base_price_money": {},
              "variation_total_price_money": {},
              "gross_return_money": {},
              "total_tax_money": {},
              "total_discount_money": {},
              "total_money": {},
              "applied_service_charges": [
                {},
                {},
                {}
              ],
              "total_service_charge_money": {}
            },
            {
              "uid": "uid4",
              "source_line_item_uid": "source_line_item_uid8",
              "name": "name4",
              "quantity": "quantity0",
              "quantity_unit": {},
              "note": "note0",
              "catalog_object_id": "catalog_object_id2",
              "catalog_version": 178,
              "variation_name": "variation_name4",
              "item_type": "GIFT_CARD",
              "return_modifiers": [
                {
                  "uid": "uid7",
                  "source_modifier_uid": "source_modifier_uid9",
                  "catalog_object_id": "catalog_object_id9",
                  "catalog_version": 21,
                  "name": "name7",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity3"
                },
                {
                  "uid": "uid8",
                  "source_modifier_uid": "source_modifier_uid8",
                  "catalog_object_id": "catalog_object_id8",
                  "catalog_version": 20,
                  "name": "name8",
                  "base_price_money": {},
                  "total_price_money": {},
                  "quantity": "quantity4"
                }
              ],
              "applied_taxes": [
                {}
              ],
              "applied_discounts": [
                {},
                {}
              ],
              "base_price_money": {},
              "variation_total_price_money": {},
              "gross_return_money": {},
              "total_tax_money": {},
              "total_discount_money": {},
              "total_money": {},
              "applied_service_charges": [
                {}
              ],
              "total_service_charge_money": {}
            }
          ],
          "return_service_charges": [
            {
              "uid": "uid1",
              "source_service_charge_uid": "source_service_charge_uid5",
              "name": "name1",
              "catalog_object_id": "catalog_object_id5",
              "catalog_version": 61,
              "percentage": "percentage9",
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
            },
            {
              "uid": "uid2",
              "source_service_charge_uid": "source_service_charge_uid4",
              "name": "name2",
              "catalog_object_id": "catalog_object_id4",
              "catalog_version": 60,
              "percentage": "percentage0",
              "amount_money": {},
              "applied_money": {},
              "total_money": {},
              "total_tax_money": {},
              "calculation_phase": "SUBTOTAL_PHASE",
              "taxable": false,
              "applied_taxes": [
                {},
                {},
                {}
              ],
              "treatment_type": "LINE_ITEM_TREATMENT",
              "scope": "LINE_ITEM"
            },
            {
              "uid": "uid3",
              "source_service_charge_uid": "source_service_charge_uid3",
              "name": "name3",
              "catalog_object_id": "catalog_object_id3",
              "catalog_version": 59,
              "percentage": "percentage1",
              "amount_money": {},
              "applied_money": {},
              "total_money": {},
              "total_tax_money": {},
              "calculation_phase": "TOTAL_PHASE",
              "taxable": true,
              "applied_taxes": [
                {}
              ],
              "treatment_type": "APPORTIONED_TREATMENT",
              "scope": "OTHER_SERVICE_CHARGE_SCOPE"
            }
          ],
          "return_taxes": [
            {
              "uid": "uid8",
              "source_tax_uid": "source_tax_uid6",
              "catalog_object_id": "catalog_object_id8",
              "catalog_version": 204,
              "name": "name8",
              "type": "INCLUSIVE",
              "percentage": "percentage6",
              "applied_money": {},
              "scope": "ORDER"
            }
          ],
          "return_discounts": [
            {
              "uid": "uid6",
              "source_discount_uid": "source_discount_uid4",
              "catalog_object_id": "catalog_object_id0",
              "catalog_version": 166,
              "name": "name6",
              "type": "VARIABLE_AMOUNT",
              "percentage": "percentage4",
              "amount_money": {},
              "applied_money": {},
              "scope": "OTHER_DISCOUNT_SCOPE"
            },
            {
              "uid": "uid7",
              "source_discount_uid": "source_discount_uid3",
              "catalog_object_id": "catalog_object_id9",
              "catalog_version": 165,
              "name": "name7",
              "type": "VARIABLE_PERCENTAGE",
              "percentage": "percentage5",
              "amount_money": {},
              "applied_money": {},
              "scope": "ORDER"
            }
          ],
          "rounding_adjustment": {
            "uid": "uid2",
            "name": "name2",
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
      "return_amounts": {},
      "net_amounts": {},
      "rounding_adjustment": {},
      "tenders": [
        {
          "id": "id9",
          "location_id": "location_id3",
          "transaction_id": "transaction_id7",
          "created_at": "created_at7",
          "note": "note5",
          "amount_money": {},
          "tip_money": {},
          "processing_fee_money": {},
          "customer_id": "customer_id7",
          "type": "CASH",
          "card_details": {
            "status": "CAPTURED",
            "card": {
              "id": "id1",
              "card_brand": "SQUARE_CAPITAL_CARD",
              "last_4": "last_43",
              "exp_month": 209,
              "exp_year": 87,
              "cardholder_name": "cardholder_name3",
              "billing_address": {},
              "fingerprint": "fingerprint7",
              "customer_id": "customer_id9",
              "merchant_id": "merchant_id1",
              "reference_id": "reference_id1",
              "enabled": true,
              "card_type": "DEBIT",
              "prepaid_type": "UNKNOWN_PREPAID_TYPE",
              "bin": "bin1",
              "version": 83,
              "card_co_brand": "UNKNOWN"
            },
            "entry_method": "ON_FILE"
          },
          "cash_details": {
            "buyer_tendered_money": {},
            "change_back_money": {}
          },
          "additional_recipients": [
            {
              "location_id": "location_id2",
              "description": "description8",
              "amount_money": {},
              "receivable_id": "receivable_id8"
            },
            {
              "location_id": "location_id3",
              "description": "description9",
              "amount_money": {},
              "receivable_id": "receivable_id9"
            },
            {
              "location_id": "location_id4",
              "description": "description0",
              "amount_money": {},
              "receivable_id": "receivable_id0"
            }
          ],
          "payment_id": "payment_id9"
        },
        {
          "id": "id0",
          "location_id": "location_id4",
          "transaction_id": "transaction_id8",
          "created_at": "created_at8",
          "note": "note6",
          "amount_money": {},
          "tip_money": {},
          "processing_fee_money": {},
          "customer_id": "customer_id8",
          "type": "THIRD_PARTY_CARD",
          "card_details": {
            "status": "AUTHORIZED",
            "card": {
              "id": "id2",
              "card_brand": "SQUARE_GIFT_CARD",
              "last_4": "last_44",
              "exp_month": 208,
              "exp_year": 88,
              "cardholder_name": "cardholder_name2",
              "billing_address": {},
              "fingerprint": "fingerprint8",
              "customer_id": "customer_id0",
              "merchant_id": "merchant_id2",
              "reference_id": "reference_id0",
              "enabled": false,
              "card_type": "CREDIT",
              "prepaid_type": "NOT_PREPAID",
              "bin": "bin2",
              "version": 82,
              "card_co_brand": "CLEARPAY"
            },
            "entry_method": "CONTACTLESS"
          },
          "cash_details": {
            "buyer_tendered_money": {},
            "change_back_money": {}
          },
          "additional_recipients": [
            {
              "location_id": "location_id3",
              "description": "description9",
              "amount_money": {},
              "receivable_id": "receivable_id9"
            }
          ],
          "payment_id": "payment_id0"
        },
        {
          "id": "id1",
          "location_id": "location_id5",
          "transaction_id": "transaction_id9",
          "created_at": "created_at9",
          "note": "note7",
          "amount_money": {},
          "tip_money": {},
          "processing_fee_money": {},
          "customer_id": "customer_id9",
          "type": "SQUARE_GIFT_CARD",
          "card_details": {
            "status": "FAILED",
            "card": {
              "id": "id3",
              "card_brand": "CHINA_UNIONPAY",
              "last_4": "last_45",
              "exp_month": 207,
              "exp_year": 89,
              "cardholder_name": "cardholder_name1",
              "billing_address": {},
              "fingerprint": "fingerprint9",
              "customer_id": "customer_id1",
              "merchant_id": "merchant_id3",
              "reference_id": "reference_id9",
              "enabled": true,
              "card_type": "UNKNOWN_CARD_TYPE",
              "prepaid_type": "PREPAID",
              "bin": "bin3",
              "version": 81,
              "card_co_brand": "AFTERPAY"
            },
            "entry_method": "SWIPED"
          },
          "cash_details": {
            "buyer_tendered_money": {},
            "change_back_money": {}
          },
          "additional_recipients": [
            {
              "location_id": "location_id4",
              "description": "description0",
              "amount_money": {},
              "receivable_id": "receivable_id0"
            },
            {
              "location_id": "location_id5",
              "description": "description1",
              "amount_money": {},
              "receivable_id": "receivable_id1"
            }
          ],
          "payment_id": "payment_id1"
        }
      ],
      "refunds": [
        {
          "id": "id7",
          "location_id": "location_id1",
          "transaction_id": "transaction_id5",
          "tender_id": "tender_id5",
          "created_at": "created_at5",
          "reason": "reason7",
          "amount_money": {},
          "status": "FAILED",
          "processing_fee_money": {},
          "additional_recipients": [
            {}
          ]
        },
        {
          "id": "id8",
          "location_id": "location_id2",
          "transaction_id": "transaction_id6",
          "tender_id": "tender_id6",
          "created_at": "created_at6",
          "reason": "reason6",
          "amount_money": {},
          "status": "REJECTED",
          "processing_fee_money": {},
          "additional_recipients": [
            {},
            {}
          ]
        },
        {
          "id": "id9",
          "location_id": "location_id3",
          "transaction_id": "transaction_id7",
          "tender_id": "tender_id7",
          "created_at": "created_at7",
          "reason": "reason5",
          "amount_money": {},
          "status": "APPROVED",
          "processing_fee_money": {},
          "additional_recipients": [
            {},
            {},
            {}
          ]
        }
      ],
      "metadata": {
        "key0": "metadata6",
        "key1": "metadata7",
        "key2": "metadata8"
      },
      "created_at": "created_at5",
      "updated_at": "updated_at7",
      "closed_at": "closed_at9",
      "state": "COMPLETED",
      "version": 67,
      "total_money": {},
      "total_tax_money": {},
      "total_discount_money": {},
      "total_tip_money": {},
      "total_service_charge_money": {},
      "ticket_name": "ticket_name9",
      "pricing_options": {
        "auto_apply_discounts": true,
        "auto_apply_taxes": true
      },
      "rewards": [
        {
          "id": "id2",
          "reward_tier_id": "reward_tier_id8"
        }
      ],
      "net_amount_due_money": {}
    }
  ],
  "subscription_plans": [
    {
      "type": "QUICK_AMOUNTS_SETTINGS",
      "id": "id6",
      "updated_at": "updated_at2",
      "version": 126,
      "is_deleted": false,
      "custom_attribute_values": {
        "key0": {
          "name": "name7",
          "string_value": "string_value1",
          "custom_attribute_definition_id": "custom_attribute_definition_id5",
          "type": "BOOLEAN",
          "number_value": "number_value7",
          "boolean_value": true,
          "selection_uid_values": [
            "selection_uid_values4"
          ],
          "key": "key7"
        }
      },
      "catalog_v1_ids": [
        {
          "catalog_v1_id": "catalog_v1_id0",
          "location_id": "location_id0"
        },
        {
          "catalog_v1_id": "catalog_v1_id1",
          "location_id": "location_id1"
        }
      ],
      "present_at_all_locations": false,
      "present_at_location_ids": [
        "present_at_location_ids6"
      ],
      "absent_at_location_ids": [
        "absent_at_location_ids7",
        "absent_at_location_ids8"
      ],
      "item_data": {
        "name": "name2",
        "description": "description2",
        "abbreviation": "abbreviation4",
        "label_color": "label_color4",
        "available_online": false,
        "available_for_pickup": false,
        "available_electronically": false,
        "category_id": "category_id6",
        "tax_ids": [
          "tax_ids5",
          "tax_ids6",
          "tax_ids7"
        ],
        "modifier_list_info": [
          {
            "modifier_list_id": "modifier_list_id2",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id5",
                "on_by_default": true
              },
              {
                "modifier_id": "modifier_id6",
                "on_by_default": false
              }
            ],
            "min_selected_modifiers": 34,
            "max_selected_modifiers": 14,
            "enabled": false
          },
          {
            "modifier_list_id": "modifier_list_id3",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id6",
                "on_by_default": false
              },
              {
                "modifier_id": "modifier_id7",
                "on_by_default": true
              },
              {
                "modifier_id": "modifier_id8",
                "on_by_default": false
              }
            ],
            "min_selected_modifiers": 35,
            "max_selected_modifiers": 15,
            "enabled": true
          },
          {
            "modifier_list_id": "modifier_list_id4",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id7",
                "on_by_default": true
              }
            ],
            "min_selected_modifiers": 36,
            "max_selected_modifiers": 16,
            "enabled": false
          }
        ],
        "variations": [
          {
            "type": "PRICING_RULE",
            "id": "id5",
            "updated_at": "updated_at9",
            "version": 229,
            "is_deleted": true,
            "custom_attribute_values": {
              "key0": {}
            },
            "catalog_v1_ids": [
              {},
              {}
            ],
            "present_at_all_locations": true,
            "present_at_location_ids": [
              "present_at_location_ids5"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids6",
              "absent_at_location_ids7"
            ],
            "item_data": {
              "name": "name3",
              "description": "description3",
              "abbreviation": "abbreviation5",
              "label_color": "label_color5",
              "available_online": true,
              "available_for_pickup": true,
              "available_electronically": true,
              "category_id": "category_id5",
              "tax_ids": [
                "tax_ids6",
                "tax_ids5",
                "tax_ids4"
              ],
              "modifier_list_info": [
                {},
                {},
                {}
              ],
              "variations": [
                {},
                {}
              ],
              "product_type": "GIFT_CARD",
              "skip_modifier_screen": true,
              "item_options": [
                {
                  "item_option_id": "item_option_id8"
                },
                {
                  "item_option_id": "item_option_id7"
                }
              ],
              "image_ids": [
                "image_ids2",
                "image_ids1",
                "image_ids0"
              ],
              "sort_name": "sort_name5",
              "description_html": "description_html3",
              "description_plaintext": "description_plaintext3"
            },
            "category_data": {
              "name": "name9",
              "image_ids": [
                "image_ids4"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id9",
              "name": "name1",
              "sku": "sku3",
              "upc": "upc1",
              "ordinal": 23,
              "pricing_type": "VARIABLE_PRICING",
              "price_money": {
                "amount": 3,
                "currency": "MXN"
              },
              "location_overrides": [
                {
                  "location_id": "location_id6",
                  "price_money": {
                    "amount": 98,
                    "currency": "UGX"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 218,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until0"
                }
              ],
              "track_inventory": true,
              "inventory_alert_type": "LOW_QUANTITY",
              "inventory_alert_threshold": 231,
              "user_data": "user_data5",
              "service_duration": 113,
              "available_for_booking": true,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id0",
                  "item_option_value_id": "item_option_value_id2"
                },
                {
                  "item_option_id": "item_option_id1",
                  "item_option_value_id": "item_option_value_id1"
                }
              ],
              "measurement_unit_id": "measurement_unit_id9",
              "sellable": true,
              "stockable": true,
              "image_ids": [
                "image_ids4",
                "image_ids5"
              ],
              "team_member_ids": [
                "team_member_ids8",
                "team_member_ids9",
                "team_member_ids0"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id1",
                "stockable_quantity": "stockable_quantity1",
                "nonstockable_quantity": "nonstockable_quantity3"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids0",
                "item_variation_vendor_info_ids1"
              ]
            },
            "tax_data": {
              "name": "name1",
              "calculation_phase": "TAX_TOTAL_PHASE",
              "inclusion_type": "INCLUSIVE",
              "percentage": "percentage9",
              "applies_to_custom_amounts": true,
              "enabled": true
            },
            "discount_data": {
              "name": "name7",
              "discount_type": "FIXED_AMOUNT",
              "percentage": "percentage5",
              "amount_money": {},
              "pin_required": true,
              "label_color": "label_color9",
              "modify_tax_basis": "DO_NOT_MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name1",
              "ordinal": 41,
              "selection_type": "MULTIPLE",
              "modifiers": [
                {},
                {},
                {}
              ],
              "image_ids": [
                "image_ids4",
                "image_ids3",
                "image_ids2"
              ]
            },
            "modifier_data": {
              "name": "name7",
              "price_money": {},
              "ordinal": 19,
              "modifier_list_id": "modifier_list_id3",
              "image_id": "image_id1"
            },
            "time_period_data": {
              "event": "event1"
            },
            "product_set_data": {
              "name": "name3",
              "product_ids_any": [
                "product_ids_any5",
                "product_ids_any4"
              ],
              "product_ids_all": [
                "product_ids_all4",
                "product_ids_all3"
              ],
              "quantity_exact": 121,
              "quantity_min": 255,
              "quantity_max": 229,
              "all_products": true
            },
            "pricing_rule_data": {
              "name": "name5",
              "time_period_ids": [
                "time_period_ids7"
              ],
              "discount_id": "discount_id3",
              "match_products_id": "match_products_id7",
              "apply_products_id": "apply_products_id1",
              "exclude_products_id": "exclude_products_id1",
              "valid_from_date": "valid_from_date7",
              "valid_from_local_time": "valid_from_local_time5",
              "valid_until_date": "valid_until_date9",
              "valid_until_local_time": "valid_until_local_time9",
              "exclude_strategy": "MOST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any4"
              ]
            },
            "image_data": {
              "name": "name5",
              "url": "url9",
              "caption": "caption9",
              "photo_studio_order_id": "photo_studio_order_id7"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name9",
                  "abbreviation": "abbreviation1"
                },
                "area_unit": "IMPERIAL_SQUARE_YARD",
                "length_unit": "METRIC_CENTIMETER",
                "volume_unit": "METRIC_LITER",
                "weight_unit": "METRIC_KILOGRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_MILLISECOND",
                "type": "TYPE_GENERIC"
              },
              "precision": 159
            },
            "subscription_plan_data": {
              "name": "name5",
              "phases": [
                {
                  "uid": "uid0",
                  "cadence": "EVERY_TWO_YEARS",
                  "periods": 228,
                  "recurring_price_money": {},
                  "ordinal": 194
                },
                {
                  "uid": "uid9",
                  "cadence": "DAILY",
                  "periods": 227,
                  "recurring_price_money": {},
                  "ordinal": 193
                },
                {
                  "uid": "uid8",
                  "cadence": "WEEKLY",
                  "periods": 226,
                  "recurring_price_money": {},
                  "ordinal": 192
                }
              ]
            },
            "item_option_data": {
              "name": "name1",
              "display_name": "display_name1",
              "description": "description9",
              "show_colors": true,
              "values": [
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id7",
              "name": "name5",
              "description": "description5",
              "color": "color9",
              "ordinal": 205
            },
            "custom_attribute_definition_data": {
              "type": "SELECTION",
              "name": "name3",
              "description": "description3",
              "source_application": {
                "product": "ONLINE_STORE",
                "application_id": "application_id1",
                "name": "name5"
              },
              "allowed_object_types": [
                "ITEM",
                "SUBSCRIPTION_PLAN"
              ],
              "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
              "app_visibility": "APP_VISIBILITY_HIDDEN",
              "string_config": {
                "enforce_uniqueness": true
              },
              "number_config": {
                "precision": 201
              },
              "selection_config": {
                "max_allowed_selections": 195,
                "allowed_selections": [
                  {
                    "uid": "uid2",
                    "name": "name2"
                  }
                ]
              },
              "custom_attribute_usage_count": 31,
              "key": "key3"
            },
            "quick_amounts_settings_data": {
              "option": "DISABLED",
              "eligible_for_auto_amounts": true,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 121,
                  "ordinal": 53
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 122,
                  "ordinal": 54
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 123,
                  "ordinal": 55
                }
              ]
            }
          },
          {
            "type": "MODIFIER",
            "id": "id6",
            "updated_at": "updated_at8",
            "version": 230,
            "is_deleted": false,
            "custom_attribute_values": {
              "key0": {},
              "key1": {},
              "key2": {}
            },
            "catalog_v1_ids": [
              {},
              {},
              {}
            ],
            "present_at_all_locations": false,
            "present_at_location_ids": [
              "present_at_location_ids6",
              "present_at_location_ids7"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids7",
              "absent_at_location_ids8",
              "absent_at_location_ids9"
            ],
            "item_data": {
              "name": "name2",
              "description": "description2",
              "abbreviation": "abbreviation4",
              "label_color": "label_color4",
              "available_online": false,
              "available_for_pickup": false,
              "available_electronically": false,
              "category_id": "category_id6",
              "tax_ids": [
                "tax_ids5"
              ],
              "modifier_list_info": [
                {},
                {}
              ],
              "variations": [
                {},
                {},
                {}
              ],
              "product_type": "REGULAR",
              "skip_modifier_screen": false,
              "item_options": [
                {
                  "item_option_id": "item_option_id9"
                }
              ],
              "image_ids": [
                "image_ids3",
                "image_ids2"
              ],
              "sort_name": "sort_name6",
              "description_html": "description_html2",
              "description_plaintext": "description_plaintext2"
            },
            "category_data": {
              "name": "name0",
              "image_ids": [
                "image_ids5",
                "image_ids6"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id8",
              "name": "name2",
              "sku": "sku2",
              "upc": "upc0",
              "ordinal": 24,
              "pricing_type": "FIXED_PRICING",
              "price_money": {
                "amount": 2,
                "currency": "MWK"
              },
              "location_overrides": [
                {
                  "location_id": "location_id7",
                  "price_money": {
                    "amount": 99,
                    "currency": "USD"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 219,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until1"
                },
                {
                  "location_id": "location_id8",
                  "price_money": {
                    "amount": 100,
                    "currency": "USN"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 220,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until2"
                }
              ],
              "track_inventory": false,
              "inventory_alert_type": "NONE",
              "inventory_alert_threshold": 230,
              "user_data": "user_data4",
              "service_duration": 114,
              "available_for_booking": false,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id9",
                  "item_option_value_id": "item_option_value_id3"
                }
              ],
              "measurement_unit_id": "measurement_unit_id8",
              "sellable": false,
              "stockable": false,
              "image_ids": [
                "image_ids3"
              ],
              "team_member_ids": [
                "team_member_ids9"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id0",
                "stockable_quantity": "stockable_quantity2",
                "nonstockable_quantity": "nonstockable_quantity4"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids1",
                "item_variation_vendor_info_ids2",
                "item_variation_vendor_info_ids3"
              ]
            },
            "tax_data": {
              "name": "name0",
              "calculation_phase": "TAX_SUBTOTAL_PHASE",
              "inclusion_type": "ADDITIVE",
              "percentage": "percentage8",
              "applies_to_custom_amounts": false,
              "enabled": false
            },
            "discount_data": {
              "name": "name6",
              "discount_type": "FIXED_PERCENTAGE",
              "percentage": "percentage4",
              "amount_money": {},
              "pin_required": false,
              "label_color": "label_color8",
              "modify_tax_basis": "MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name0",
              "ordinal": 40,
              "selection_type": "SINGLE",
              "modifiers": [
                {},
                {}
              ],
              "image_ids": [
                "image_ids5",
                "image_ids4"
              ]
            },
            "modifier_data": {
              "name": "name6",
              "price_money": {},
              "ordinal": 18,
              "modifier_list_id": "modifier_list_id2",
              "image_id": "image_id0"
            },
            "time_period_data": {
              "event": "event0"
            },
            "product_set_data": {
              "name": "name4",
              "product_ids_any": [
                "product_ids_any6"
              ],
              "product_ids_all": [
                "product_ids_all5"
              ],
              "quantity_exact": 122,
              "quantity_min": 0,
              "quantity_max": 230,
              "all_products": false
            },
            "pricing_rule_data": {
              "name": "name4",
              "time_period_ids": [
                "time_period_ids6",
                "time_period_ids7",
                "time_period_ids8"
              ],
              "discount_id": "discount_id2",
              "match_products_id": "match_products_id8",
              "apply_products_id": "apply_products_id2",
              "exclude_products_id": "exclude_products_id0",
              "valid_from_date": "valid_from_date8",
              "valid_from_local_time": "valid_from_local_time6",
              "valid_until_date": "valid_until_date0",
              "valid_until_local_time": "valid_until_local_time0",
              "exclude_strategy": "LEAST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any3",
                "customer_group_ids_any4",
                "customer_group_ids_any5"
              ]
            },
            "image_data": {
              "name": "name6",
              "url": "url0",
              "caption": "caption0",
              "photo_studio_order_id": "photo_studio_order_id8"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name8",
                  "abbreviation": "abbreviation0"
                },
                "area_unit": "IMPERIAL_SQUARE_FOOT",
                "length_unit": "METRIC_METER",
                "volume_unit": "METRIC_MILLILITER",
                "weight_unit": "IMPERIAL_WEIGHT_OUNCE",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_DAY",
                "type": "TYPE_CUSTOM"
              },
              "precision": 158
            },
            "subscription_plan_data": {
              "name": "name4",
              "phases": [
                {
                  "uid": "uid1",
                  "cadence": "ANNUAL",
                  "periods": 229,
                  "recurring_price_money": {},
                  "ordinal": 195
                },
                {
                  "uid": "uid0",
                  "cadence": "EVERY_TWO_YEARS",
                  "periods": 228,
                  "recurring_price_money": {},
                  "ordinal": 194
                }
              ]
            },
            "item_option_data": {
              "name": "name0",
              "display_name": "display_name0",
              "description": "description0",
              "show_colors": false,
              "values": [
                {},
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id8",
              "name": "name6",
              "description": "description6",
              "color": "color0",
              "ordinal": 206
            },
            "custom_attribute_definition_data": {
              "type": "NUMBER",
              "name": "name4",
              "description": "description4",
              "source_application": {
                "product": "PAYROLL",
                "application_id": "application_id2",
                "name": "name6"
              },
              "allowed_object_types": [
                "SUBSCRIPTION_PLAN",
                "QUICK_AMOUNTS_SETTINGS",
                "CUSTOM_ATTRIBUTE_DEFINITION"
              ],
              "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
              "app_visibility": "APP_VISIBILITY_READ_ONLY",
              "string_config": {
                "enforce_uniqueness": false
              },
              "number_config": {
                "precision": 200
              },
              "selection_config": {
                "max_allowed_selections": 196,
                "allowed_selections": [
                  {
                    "uid": "uid3",
                    "name": "name3"
                  },
                  {
                    "uid": "uid4",
                    "name": "name4"
                  }
                ]
              },
              "custom_attribute_usage_count": 32,
              "key": "key4"
            },
            "quick_amounts_settings_data": {
              "option": "MANUAL",
              "eligible_for_auto_amounts": false,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 122,
                  "ordinal": 54
                }
              ]
            }
          }
        ],
        "product_type": "GIFT_CARD",
        "skip_modifier_screen": false,
        "item_options": [
          {},
          {},
          {}
        ],
        "image_ids": [
          "image_ids7",
          "image_ids6"
        ],
        "sort_name": "sort_name6",
        "description_html": "description_html2",
        "description_plaintext": "description_plaintext2"
      },
      "category_data": {
        "name": "name0",
        "image_ids": [
          "image_ids5"
        ]
      },
      "item_variation_data": {
        "item_id": "item_id8",
        "name": "name2",
        "sku": "sku8",
        "upc": "upc0",
        "ordinal": 176,
        "pricing_type": "FIXED_PRICING",
        "price_money": {},
        "location_overrides": [
          {}
        ],
        "track_inventory": false,
        "inventory_alert_type": "NONE",
        "inventory_alert_threshold": 178,
        "user_data": "user_data4",
        "service_duration": 10,
        "available_for_booking": false,
        "item_option_values": [
          {},
          {}
        ],
        "measurement_unit_id": "measurement_unit_id8",
        "sellable": false,
        "stockable": false,
        "image_ids": [
          "image_ids3",
          "image_ids2",
          "image_ids1"
        ],
        "team_member_ids": [
          "team_member_ids9",
          "team_member_ids0",
          "team_member_ids1"
        ],
        "stockable_conversion": {
          "stockable_item_variation_id": "stockable_item_variation_id0",
          "stockable_quantity": "stockable_quantity2",
          "nonstockable_quantity": "nonstockable_quantity4"
        },
        "item_variation_vendor_info_ids": [
          "item_variation_vendor_info_ids1",
          "item_variation_vendor_info_ids2"
        ]
      },
      "tax_data": {
        "name": "name0",
        "calculation_phase": "TAX_SUBTOTAL_PHASE",
        "inclusion_type": "ADDITIVE",
        "percentage": "percentage8",
        "applies_to_custom_amounts": false,
        "enabled": false
      },
      "discount_data": {
        "name": "name4",
        "discount_type": "FIXED_PERCENTAGE",
        "percentage": "percentage2",
        "amount_money": {},
        "pin_required": false,
        "label_color": "label_color6",
        "modify_tax_basis": "MODIFY_TAX_BASIS",
        "maximum_amount_money": {}
      },
      "modifier_list_data": {
        "name": "name0",
        "ordinal": 144,
        "selection_type": "SINGLE",
        "modifiers": [
          {},
          {},
          {}
        ],
        "image_ids": [
          "image_ids5",
          "image_ids6"
        ]
      },
      "modifier_data": {
        "name": "name4",
        "price_money": {},
        "ordinal": 38,
        "modifier_list_id": "modifier_list_id0",
        "image_id": "image_id8"
      },
      "time_period_data": {
        "event": "event0"
      },
      "product_set_data": {
        "name": "name4",
        "product_ids_any": [
          "product_ids_any0",
          "product_ids_any9",
          "product_ids_any8"
        ],
        "product_ids_all": [
          "product_ids_all7",
          "product_ids_all8",
          "product_ids_all9"
        ],
        "quantity_exact": 18,
        "quantity_min": 152,
        "quantity_max": 126,
        "all_products": false
      },
      "pricing_rule_data": {
        "name": "name6",
        "time_period_ids": [
          "time_period_ids8",
          "time_period_ids9"
        ],
        "discount_id": "discount_id4",
        "match_products_id": "match_products_id6",
        "apply_products_id": "apply_products_id0",
        "exclude_products_id": "exclude_products_id2",
        "valid_from_date": "valid_from_date6",
        "valid_from_local_time": "valid_from_local_time4",
        "valid_until_date": "valid_until_date8",
        "valid_until_local_time": "valid_until_local_time8",
        "exclude_strategy": "LEAST_EXPENSIVE",
        "minimum_order_subtotal_money": {},
        "customer_group_ids_any": [
          "customer_group_ids_any5",
          "customer_group_ids_any6"
        ]
      },
      "image_data": {
        "name": "name6",
        "url": "url0",
        "caption": "caption0",
        "photo_studio_order_id": "photo_studio_order_id8"
      },
      "measurement_unit_data": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name8",
            "abbreviation": "abbreviation0"
          },
          "area_unit": "IMPERIAL_SQUARE_FOOT",
          "length_unit": "METRIC_METER",
          "volume_unit": "IMPERIAL_CUBIC_YARD",
          "weight_unit": "IMPERIAL_STONE",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_SECOND",
          "type": "TYPE_LENGTH"
        },
        "precision": 6
      },
      "subscription_plan_data": {
        "name": "name4",
        "phases": [
          {},
          {}
        ]
      },
      "item_option_data": {
        "name": "name0",
        "display_name": "display_name0",
        "description": "description0",
        "show_colors": false,
        "values": [
          {},
          {}
        ]
      },
      "item_option_value_data": {
        "item_option_id": "item_option_id8",
        "name": "name6",
        "description": "description6",
        "color": "color0",
        "ordinal": 102
      },
      "custom_attribute_definition_data": {
        "type": "NUMBER",
        "name": "name4",
        "description": "description4",
        "source_application": {
          "product": "PAYROLL",
          "application_id": "application_id2",
          "name": "name6"
        },
        "allowed_object_types": [
          "TIME_PERIOD",
          "MEASUREMENT_UNIT"
        ],
        "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
        "app_visibility": "APP_VISIBILITY_HIDDEN",
        "string_config": {
          "enforce_uniqueness": false
        },
        "number_config": {
          "precision": 48
        },
        "selection_config": {
          "max_allowed_selections": 92,
          "allowed_selections": [
            {}
          ]
        },
        "custom_attribute_usage_count": 184,
        "key": "key4"
      },
      "quick_amounts_settings_data": {
        "option": "DISABLED",
        "eligible_for_auto_amounts": false,
        "amounts": [
          {},
          {},
          {}
        ]
      }
    },
    {
      "type": "CUSTOM_ATTRIBUTE_DEFINITION",
      "id": "id7",
      "updated_at": "updated_at3",
      "version": 127,
      "is_deleted": true,
      "custom_attribute_values": {
        "key0": {
          "name": "name8",
          "string_value": "string_value2",
          "custom_attribute_definition_id": "custom_attribute_definition_id4",
          "type": "STRING",
          "number_value": "number_value8",
          "boolean_value": false,
          "selection_uid_values": [
            "selection_uid_values5",
            "selection_uid_values6"
          ],
          "key": "key8"
        },
        "key1": {
          "name": "name7",
          "string_value": "string_value1",
          "custom_attribute_definition_id": "custom_attribute_definition_id5",
          "type": "BOOLEAN",
          "number_value": "number_value7",
          "boolean_value": true,
          "selection_uid_values": [
            "selection_uid_values4"
          ],
          "key": "key7"
        },
        "key2": {
          "name": "name6",
          "string_value": "string_value0",
          "custom_attribute_definition_id": "custom_attribute_definition_id6",
          "type": "NUMBER",
          "number_value": "number_value6",
          "boolean_value": false,
          "selection_uid_values": [
            "selection_uid_values3",
            "selection_uid_values4",
            "selection_uid_values5"
          ],
          "key": "key6"
        }
      },
      "catalog_v1_ids": [
        {
          "catalog_v1_id": "catalog_v1_id1",
          "location_id": "location_id1"
        },
        {
          "catalog_v1_id": "catalog_v1_id2",
          "location_id": "location_id2"
        },
        {
          "catalog_v1_id": "catalog_v1_id3",
          "location_id": "location_id3"
        }
      ],
      "present_at_all_locations": true,
      "present_at_location_ids": [
        "present_at_location_ids7",
        "present_at_location_ids8"
      ],
      "absent_at_location_ids": [
        "absent_at_location_ids8",
        "absent_at_location_ids9",
        "absent_at_location_ids0"
      ],
      "item_data": {
        "name": "name1",
        "description": "description1",
        "abbreviation": "abbreviation3",
        "label_color": "label_color3",
        "available_online": true,
        "available_for_pickup": true,
        "available_electronically": true,
        "category_id": "category_id7",
        "tax_ids": [
          "tax_ids6"
        ],
        "modifier_list_info": [
          {
            "modifier_list_id": "modifier_list_id1",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id4",
                "on_by_default": false
              }
            ],
            "min_selected_modifiers": 33,
            "max_selected_modifiers": 13,
            "enabled": true
          },
          {
            "modifier_list_id": "modifier_list_id2",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id5",
                "on_by_default": true
              },
              {
                "modifier_id": "modifier_id6",
                "on_by_default": false
              }
            ],
            "min_selected_modifiers": 34,
            "max_selected_modifiers": 14,
            "enabled": false
          }
        ],
        "variations": [
          {
            "type": "MODIFIER",
            "id": "id6",
            "updated_at": "updated_at8",
            "version": 230,
            "is_deleted": false,
            "custom_attribute_values": {
              "key0": {},
              "key1": {},
              "key2": {}
            },
            "catalog_v1_ids": [
              {},
              {},
              {}
            ],
            "present_at_all_locations": false,
            "present_at_location_ids": [
              "present_at_location_ids6",
              "present_at_location_ids7"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids7",
              "absent_at_location_ids8",
              "absent_at_location_ids9"
            ],
            "item_data": {
              "name": "name2",
              "description": "description2",
              "abbreviation": "abbreviation4",
              "label_color": "label_color4",
              "available_online": false,
              "available_for_pickup": false,
              "available_electronically": false,
              "category_id": "category_id6",
              "tax_ids": [
                "tax_ids5"
              ],
              "modifier_list_info": [
                {},
                {}
              ],
              "variations": [
                {},
                {},
                {}
              ],
              "product_type": "REGULAR",
              "skip_modifier_screen": false,
              "item_options": [
                {
                  "item_option_id": "item_option_id9"
                }
              ],
              "image_ids": [
                "image_ids3",
                "image_ids2"
              ],
              "sort_name": "sort_name6",
              "description_html": "description_html2",
              "description_plaintext": "description_plaintext2"
            },
            "category_data": {
              "name": "name0",
              "image_ids": [
                "image_ids5",
                "image_ids6"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id8",
              "name": "name2",
              "sku": "sku2",
              "upc": "upc0",
              "ordinal": 24,
              "pricing_type": "FIXED_PRICING",
              "price_money": {
                "amount": 2,
                "currency": "MWK"
              },
              "location_overrides": [
                {
                  "location_id": "location_id7",
                  "price_money": {
                    "amount": 99,
                    "currency": "USD"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 219,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until1"
                },
                {
                  "location_id": "location_id8",
                  "price_money": {
                    "amount": 100,
                    "currency": "USN"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 220,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until2"
                }
              ],
              "track_inventory": false,
              "inventory_alert_type": "NONE",
              "inventory_alert_threshold": 230,
              "user_data": "user_data4",
              "service_duration": 114,
              "available_for_booking": false,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id9",
                  "item_option_value_id": "item_option_value_id3"
                }
              ],
              "measurement_unit_id": "measurement_unit_id8",
              "sellable": false,
              "stockable": false,
              "image_ids": [
                "image_ids3"
              ],
              "team_member_ids": [
                "team_member_ids9"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id0",
                "stockable_quantity": "stockable_quantity2",
                "nonstockable_quantity": "nonstockable_quantity4"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids1",
                "item_variation_vendor_info_ids2",
                "item_variation_vendor_info_ids3"
              ]
            },
            "tax_data": {
              "name": "name0",
              "calculation_phase": "TAX_SUBTOTAL_PHASE",
              "inclusion_type": "ADDITIVE",
              "percentage": "percentage8",
              "applies_to_custom_amounts": false,
              "enabled": false
            },
            "discount_data": {
              "name": "name6",
              "discount_type": "FIXED_PERCENTAGE",
              "percentage": "percentage4",
              "amount_money": {},
              "pin_required": false,
              "label_color": "label_color8",
              "modify_tax_basis": "MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name0",
              "ordinal": 40,
              "selection_type": "SINGLE",
              "modifiers": [
                {},
                {}
              ],
              "image_ids": [
                "image_ids5",
                "image_ids4"
              ]
            },
            "modifier_data": {
              "name": "name6",
              "price_money": {},
              "ordinal": 18,
              "modifier_list_id": "modifier_list_id2",
              "image_id": "image_id0"
            },
            "time_period_data": {
              "event": "event0"
            },
            "product_set_data": {
              "name": "name4",
              "product_ids_any": [
                "product_ids_any6"
              ],
              "product_ids_all": [
                "product_ids_all5"
              ],
              "quantity_exact": 122,
              "quantity_min": 0,
              "quantity_max": 230,
              "all_products": false
            },
            "pricing_rule_data": {
              "name": "name4",
              "time_period_ids": [
                "time_period_ids6",
                "time_period_ids7",
                "time_period_ids8"
              ],
              "discount_id": "discount_id2",
              "match_products_id": "match_products_id8",
              "apply_products_id": "apply_products_id2",
              "exclude_products_id": "exclude_products_id0",
              "valid_from_date": "valid_from_date8",
              "valid_from_local_time": "valid_from_local_time6",
              "valid_until_date": "valid_until_date0",
              "valid_until_local_time": "valid_until_local_time0",
              "exclude_strategy": "LEAST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any3",
                "customer_group_ids_any4",
                "customer_group_ids_any5"
              ]
            },
            "image_data": {
              "name": "name6",
              "url": "url0",
              "caption": "caption0",
              "photo_studio_order_id": "photo_studio_order_id8"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name8",
                  "abbreviation": "abbreviation0"
                },
                "area_unit": "IMPERIAL_SQUARE_FOOT",
                "length_unit": "METRIC_METER",
                "volume_unit": "METRIC_MILLILITER",
                "weight_unit": "IMPERIAL_WEIGHT_OUNCE",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_DAY",
                "type": "TYPE_CUSTOM"
              },
              "precision": 158
            },
            "subscription_plan_data": {
              "name": "name4",
              "phases": [
                {
                  "uid": "uid1",
                  "cadence": "ANNUAL",
                  "periods": 229,
                  "recurring_price_money": {},
                  "ordinal": 195
                },
                {
                  "uid": "uid0",
                  "cadence": "EVERY_TWO_YEARS",
                  "periods": 228,
                  "recurring_price_money": {},
                  "ordinal": 194
                }
              ]
            },
            "item_option_data": {
              "name": "name0",
              "display_name": "display_name0",
              "description": "description0",
              "show_colors": false,
              "values": [
                {},
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id8",
              "name": "name6",
              "description": "description6",
              "color": "color0",
              "ordinal": 206
            },
            "custom_attribute_definition_data": {
              "type": "NUMBER",
              "name": "name4",
              "description": "description4",
              "source_application": {
                "product": "PAYROLL",
                "application_id": "application_id2",
                "name": "name6"
              },
              "allowed_object_types": [
                "SUBSCRIPTION_PLAN",
                "QUICK_AMOUNTS_SETTINGS",
                "CUSTOM_ATTRIBUTE_DEFINITION"
              ],
              "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
              "app_visibility": "APP_VISIBILITY_READ_ONLY",
              "string_config": {
                "enforce_uniqueness": false
              },
              "number_config": {
                "precision": 200
              },
              "selection_config": {
                "max_allowed_selections": 196,
                "allowed_selections": [
                  {
                    "uid": "uid3",
                    "name": "name3"
                  },
                  {
                    "uid": "uid4",
                    "name": "name4"
                  }
                ]
              },
              "custom_attribute_usage_count": 32,
              "key": "key4"
            },
            "quick_amounts_settings_data": {
              "option": "MANUAL",
              "eligible_for_auto_amounts": false,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 122,
                  "ordinal": 54
                }
              ]
            }
          },
          {
            "type": "MODIFIER_LIST",
            "id": "id7",
            "updated_at": "updated_at7",
            "version": 231,
            "is_deleted": true,
            "custom_attribute_values": {
              "key0": {},
              "key1": {}
            },
            "catalog_v1_ids": [
              {}
            ],
            "present_at_all_locations": true,
            "present_at_location_ids": [
              "present_at_location_ids7",
              "present_at_location_ids8",
              "present_at_location_ids9"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids8"
            ],
            "item_data": {
              "name": "name1",
              "description": "description1",
              "abbreviation": "abbreviation3",
              "label_color": "label_color3",
              "available_online": true,
              "available_for_pickup": true,
              "available_electronically": true,
              "category_id": "category_id7",
              "tax_ids": [
                "tax_ids4",
                "tax_ids3"
              ],
              "modifier_list_info": [
                {}
              ],
              "variations": [
                {}
              ],
              "product_type": "APPOINTMENTS_SERVICE",
              "skip_modifier_screen": true,
              "item_options": [
                {
                  "item_option_id": "item_option_id0"
                },
                {
                  "item_option_id": "item_option_id9"
                },
                {
                  "item_option_id": "item_option_id8"
                }
              ],
              "image_ids": [
                "image_ids4"
              ],
              "sort_name": "sort_name7",
              "description_html": "description_html1",
              "description_plaintext": "description_plaintext1"
            },
            "category_data": {
              "name": "name1",
              "image_ids": [
                "image_ids6",
                "image_ids7",
                "image_ids8"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id7",
              "name": "name3",
              "sku": "sku1",
              "upc": "upc9",
              "ordinal": 25,
              "pricing_type": "VARIABLE_PRICING",
              "price_money": {
                "amount": 1,
                "currency": "MVR"
              },
              "location_overrides": [
                {
                  "location_id": "location_id8",
                  "price_money": {
                    "amount": 100,
                    "currency": "USN"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 220,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until2"
                },
                {
                  "location_id": "location_id9",
                  "price_money": {
                    "amount": 101,
                    "currency": "USS"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 221,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until3"
                },
                {
                  "location_id": "location_id0",
                  "price_money": {
                    "amount": 102,
                    "currency": "UYI"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 222,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until4"
                }
              ],
              "track_inventory": true,
              "inventory_alert_type": "LOW_QUANTITY",
              "inventory_alert_threshold": 229,
              "user_data": "user_data3",
              "service_duration": 115,
              "available_for_booking": true,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id8",
                  "item_option_value_id": "item_option_value_id4"
                },
                {
                  "item_option_id": "item_option_id9",
                  "item_option_value_id": "item_option_value_id3"
                },
                {
                  "item_option_id": "item_option_id0",
                  "item_option_value_id": "item_option_value_id2"
                }
              ],
              "measurement_unit_id": "measurement_unit_id7",
              "sellable": true,
              "stockable": true,
              "image_ids": [
                "image_ids2",
                "image_ids3",
                "image_ids4"
              ],
              "team_member_ids": [
                "team_member_ids0",
                "team_member_ids1"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id9",
                "stockable_quantity": "stockable_quantity3",
                "nonstockable_quantity": "nonstockable_quantity5"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids2"
              ]
            },
            "tax_data": {
              "name": "name9",
              "calculation_phase": "TAX_TOTAL_PHASE",
              "inclusion_type": "INCLUSIVE",
              "percentage": "percentage7",
              "applies_to_custom_amounts": true,
              "enabled": true
            },
            "discount_data": {
              "name": "name5",
              "discount_type": "VARIABLE_AMOUNT",
              "percentage": "percentage3",
              "amount_money": {},
              "pin_required": true,
              "label_color": "label_color7",
              "modify_tax_basis": "DO_NOT_MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name9",
              "ordinal": 39,
              "selection_type": "MULTIPLE",
              "modifiers": [
                {}
              ],
              "image_ids": [
                "image_ids6"
              ]
            },
            "modifier_data": {
              "name": "name5",
              "price_money": {},
              "ordinal": 17,
              "modifier_list_id": "modifier_list_id1",
              "image_id": "image_id9"
            },
            "time_period_data": {
              "event": "event9"
            },
            "product_set_data": {
              "name": "name5",
              "product_ids_any": [
                "product_ids_any7",
                "product_ids_any6",
                "product_ids_any5"
              ],
              "product_ids_all": [
                "product_ids_all6",
                "product_ids_all5",
                "product_ids_all4"
              ],
              "quantity_exact": 123,
              "quantity_min": 1,
              "quantity_max": 231,
              "all_products": true
            },
            "pricing_rule_data": {
              "name": "name3",
              "time_period_ids": [
                "time_period_ids5",
                "time_period_ids6"
              ],
              "discount_id": "discount_id1",
              "match_products_id": "match_products_id9",
              "apply_products_id": "apply_products_id3",
              "exclude_products_id": "exclude_products_id9",
              "valid_from_date": "valid_from_date9",
              "valid_from_local_time": "valid_from_local_time7",
              "valid_until_date": "valid_until_date1",
              "valid_until_local_time": "valid_until_local_time1",
              "exclude_strategy": "MOST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any2",
                "customer_group_ids_any3"
              ]
            },
            "image_data": {
              "name": "name7",
              "url": "url1",
              "caption": "caption1",
              "photo_studio_order_id": "photo_studio_order_id9"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name7",
                  "abbreviation": "abbreviation9"
                },
                "area_unit": "IMPERIAL_SQUARE_INCH",
                "length_unit": "METRIC_KILOMETER",
                "volume_unit": "IMPERIAL_CUBIC_YARD",
                "weight_unit": "IMPERIAL_POUND",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_HOUR",
                "type": "TYPE_AREA"
              },
              "precision": 157
            },
            "subscription_plan_data": {
              "name": "name3",
              "phases": [
                {
                  "uid": "uid2",
                  "cadence": "EVERY_SIX_MONTHS",
                  "periods": 230,
                  "recurring_price_money": {},
                  "ordinal": 196
                }
              ]
            },
            "item_option_data": {
              "name": "name9",
              "display_name": "display_name9",
              "description": "description1",
              "show_colors": true,
              "values": [
                {},
                {},
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id9",
              "name": "name7",
              "description": "description7",
              "color": "color1",
              "ordinal": 207
            },
            "custom_attribute_definition_data": {
              "type": "BOOLEAN",
              "name": "name5",
              "description": "description5",
              "source_application": {
                "product": "DASHBOARD",
                "application_id": "application_id3",
                "name": "name7"
              },
              "allowed_object_types": [
                "QUICK_AMOUNTS_SETTINGS"
              ],
              "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
              "app_visibility": "APP_VISIBILITY_READ_WRITE_VALUES",
              "string_config": {
                "enforce_uniqueness": true
              },
              "number_config": {
                "precision": 199
              },
              "selection_config": {
                "max_allowed_selections": 197,
                "allowed_selections": [
                  {
                    "uid": "uid4",
                    "name": "name4"
                  },
                  {
                    "uid": "uid5",
                    "name": "name5"
                  },
                  {
                    "uid": "uid6",
                    "name": "name6"
                  }
                ]
              },
              "custom_attribute_usage_count": 33,
              "key": "key5"
            },
            "quick_amounts_settings_data": {
              "option": "AUTO",
              "eligible_for_auto_amounts": true,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 123,
                  "ordinal": 55
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 124,
                  "ordinal": 56
                }
              ]
            }
          },
          {
            "type": "DISCOUNT",
            "id": "id8",
            "updated_at": "updated_at6",
            "version": 232,
            "is_deleted": false,
            "custom_attribute_values": {
              "key0": {}
            },
            "catalog_v1_ids": [
              {},
              {}
            ],
            "present_at_all_locations": false,
            "present_at_location_ids": [
              "present_at_location_ids8"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids9",
              "absent_at_location_ids0"
            ],
            "item_data": {
              "name": "name0",
              "description": "description0",
              "abbreviation": "abbreviation2",
              "label_color": "label_color2",
              "available_online": false,
              "available_for_pickup": false,
              "available_electronically": false,
              "category_id": "category_id8",
              "tax_ids": [
                "tax_ids3",
                "tax_ids2",
                "tax_ids1"
              ],
              "modifier_list_info": [
                {},
                {},
                {}
              ],
              "variations": [
                {},
                {}
              ],
              "product_type": "GIFT_CARD",
              "skip_modifier_screen": false,
              "item_options": [
                {
                  "item_option_id": "item_option_id1"
                },
                {
                  "item_option_id": "item_option_id0"
                }
              ],
              "image_ids": [
                "image_ids5",
                "image_ids4",
                "image_ids3"
              ],
              "sort_name": "sort_name8",
              "description_html": "description_html0",
              "description_plaintext": "description_plaintext0"
            },
            "category_data": {
              "name": "name2",
              "image_ids": [
                "image_ids7"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id6",
              "name": "name4",
              "sku": "sku0",
              "upc": "upc8",
              "ordinal": 26,
              "pricing_type": "FIXED_PRICING",
              "price_money": {
                "amount": 0,
                "currency": "MUR"
              },
              "location_overrides": [
                {
                  "location_id": "location_id9",
                  "price_money": {
                    "amount": 101,
                    "currency": "USS"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 221,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until3"
                }
              ],
              "track_inventory": false,
              "inventory_alert_type": "NONE",
              "inventory_alert_threshold": 228,
              "user_data": "user_data2",
              "service_duration": 116,
              "available_for_booking": false,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id7",
                  "item_option_value_id": "item_option_value_id5"
                },
                {
                  "item_option_id": "item_option_id8",
                  "item_option_value_id": "item_option_value_id4"
                }
              ],
              "measurement_unit_id": "measurement_unit_id6",
              "sellable": false,
              "stockable": false,
              "image_ids": [
                "image_ids1",
                "image_ids2"
              ],
              "team_member_ids": [
                "team_member_ids1",
                "team_member_ids2",
                "team_member_ids3"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id8",
                "stockable_quantity": "stockable_quantity4",
                "nonstockable_quantity": "nonstockable_quantity6"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids3",
                "item_variation_vendor_info_ids4"
              ]
            },
            "tax_data": {
              "name": "name8",
              "calculation_phase": "TAX_SUBTOTAL_PHASE",
              "inclusion_type": "ADDITIVE",
              "percentage": "percentage6",
              "applies_to_custom_amounts": false,
              "enabled": false
            },
            "discount_data": {
              "name": "name4",
              "discount_type": "VARIABLE_PERCENTAGE",
              "percentage": "percentage2",
              "amount_money": {},
              "pin_required": false,
              "label_color": "label_color6",
              "modify_tax_basis": "MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name8",
              "ordinal": 38,
              "selection_type": "SINGLE",
              "modifiers": [
                {},
                {},
                {}
              ],
              "image_ids": [
                "image_ids7",
                "image_ids6",
                "image_ids5"
              ]
            },
            "modifier_data": {
              "name": "name4",
              "price_money": {},
              "ordinal": 16,
              "modifier_list_id": "modifier_list_id0",
              "image_id": "image_id8"
            },
            "time_period_data": {
              "event": "event8"
            },
            "product_set_data": {
              "name": "name6",
              "product_ids_any": [
                "product_ids_any8",
                "product_ids_any7"
              ],
              "product_ids_all": [
                "product_ids_all7",
                "product_ids_all6"
              ],
              "quantity_exact": 124,
              "quantity_min": 2,
              "quantity_max": 232,
              "all_products": false
            },
            "pricing_rule_data": {
              "name": "name2",
              "time_period_ids": [
                "time_period_ids4"
              ],
              "discount_id": "discount_id0",
              "match_products_id": "match_products_id0",
              "apply_products_id": "apply_products_id4",
              "exclude_products_id": "exclude_products_id8",
              "valid_from_date": "valid_from_date0",
              "valid_from_local_time": "valid_from_local_time8",
              "valid_until_date": "valid_until_date2",
              "valid_until_local_time": "valid_until_local_time2",
              "exclude_strategy": "LEAST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any1"
              ]
            },
            "image_data": {
              "name": "name8",
              "url": "url2",
              "caption": "caption2",
              "photo_studio_order_id": "photo_studio_order_id0"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name6",
                  "abbreviation": "abbreviation8"
                },
                "area_unit": "IMPERIAL_ACRE",
                "length_unit": "IMPERIAL_INCH",
                "volume_unit": "IMPERIAL_CUBIC_FOOT",
                "weight_unit": "IMPERIAL_STONE",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_MINUTE",
                "type": "TYPE_LENGTH"
              },
              "precision": 156
            },
            "subscription_plan_data": {
              "name": "name2",
              "phases": [
                {
                  "uid": "uid3",
                  "cadence": "EVERY_FOUR_MONTHS",
                  "periods": 231,
                  "recurring_price_money": {},
                  "ordinal": 197
                },
                {
                  "uid": "uid2",
                  "cadence": "EVERY_SIX_MONTHS",
                  "periods": 230,
                  "recurring_price_money": {},
                  "ordinal": 196
                },
                {
                  "uid": "uid1",
                  "cadence": "ANNUAL",
                  "periods": 229,
                  "recurring_price_money": {},
                  "ordinal": 195
                }
              ]
            },
            "item_option_data": {
              "name": "name8",
              "display_name": "display_name8",
              "description": "description2",
              "show_colors": false,
              "values": [
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id0",
              "name": "name8",
              "description": "description8",
              "color": "color2",
              "ordinal": 208
            },
            "custom_attribute_definition_data": {
              "type": "STRING",
              "name": "name6",
              "description": "description6",
              "source_application": {
                "product": "ITEM_LIBRARY_IMPORT",
                "application_id": "application_id4",
                "name": "name8"
              },
              "allowed_object_types": [
                "CUSTOM_ATTRIBUTE_DEFINITION",
                "ITEM_OPTION_VAL"
              ],
              "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
              "app_visibility": "APP_VISIBILITY_HIDDEN",
              "string_config": {
                "enforce_uniqueness": false
              },
              "number_config": {
                "precision": 198
              },
              "selection_config": {
                "max_allowed_selections": 198,
                "allowed_selections": [
                  {
                    "uid": "uid5",
                    "name": "name5"
                  }
                ]
              },
              "custom_attribute_usage_count": 34,
              "key": "key6"
            },
            "quick_amounts_settings_data": {
              "option": "DISABLED",
              "eligible_for_auto_amounts": false,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 124,
                  "ordinal": 56
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 125,
                  "ordinal": 57
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 126,
                  "ordinal": 58
                }
              ]
            }
          }
        ],
        "product_type": "REGULAR",
        "skip_modifier_screen": true,
        "item_options": [
          {}
        ],
        "image_ids": [
          "image_ids6",
          "image_ids5",
          "image_ids4"
        ],
        "sort_name": "sort_name7",
        "description_html": "description_html1",
        "description_plaintext": "description_plaintext1"
      },
      "category_data": {
        "name": "name1",
        "image_ids": [
          "image_ids6",
          "image_ids7"
        ]
      },
      "item_variation_data": {
        "item_id": "item_id7",
        "name": "name3",
        "sku": "sku9",
        "upc": "upc9",
        "ordinal": 177,
        "pricing_type": "VARIABLE_PRICING",
        "price_money": {},
        "location_overrides": [
          {},
          {}
        ],
        "track_inventory": true,
        "inventory_alert_type": "LOW_QUANTITY",
        "inventory_alert_threshold": 179,
        "user_data": "user_data3",
        "service_duration": 11,
        "available_for_booking": true,
        "item_option_values": [
          {}
        ],
        "measurement_unit_id": "measurement_unit_id7",
        "sellable": true,
        "stockable": true,
        "image_ids": [
          "image_ids2"
        ],
        "team_member_ids": [
          "team_member_ids0"
        ],
        "stockable_conversion": {
          "stockable_item_variation_id": "stockable_item_variation_id1",
          "stockable_quantity": "stockable_quantity3",
          "nonstockable_quantity": "nonstockable_quantity5"
        },
        "item_variation_vendor_info_ids": [
          "item_variation_vendor_info_ids2",
          "item_variation_vendor_info_ids3",
          "item_variation_vendor_info_ids4"
        ]
      },
      "tax_data": {
        "name": "name1",
        "calculation_phase": "TAX_TOTAL_PHASE",
        "inclusion_type": "INCLUSIVE",
        "percentage": "percentage9",
        "applies_to_custom_amounts": true,
        "enabled": true
      },
      "discount_data": {
        "name": "name5",
        "discount_type": "FIXED_AMOUNT",
        "percentage": "percentage3",
        "amount_money": {},
        "pin_required": true,
        "label_color": "label_color7",
        "modify_tax_basis": "DO_NOT_MODIFY_TAX_BASIS",
        "maximum_amount_money": {}
      },
      "modifier_list_data": {
        "name": "name9",
        "ordinal": 143,
        "selection_type": "MULTIPLE",
        "modifiers": [
          {},
          {}
        ],
        "image_ids": [
          "image_ids6",
          "image_ids7",
          "image_ids8"
        ]
      },
      "modifier_data": {
        "name": "name5",
        "price_money": {},
        "ordinal": 39,
        "modifier_list_id": "modifier_list_id1",
        "image_id": "image_id9"
      },
      "time_period_data": {
        "event": "event9"
      },
      "product_set_data": {
        "name": "name5",
        "product_ids_any": [
          "product_ids_any9"
        ],
        "product_ids_all": [
          "product_ids_all8"
        ],
        "quantity_exact": 19,
        "quantity_min": 153,
        "quantity_max": 127,
        "all_products": true
      },
      "pricing_rule_data": {
        "name": "name7",
        "time_period_ids": [
          "time_period_ids9",
          "time_period_ids0",
          "time_period_ids1"
        ],
        "discount_id": "discount_id5",
        "match_products_id": "match_products_id5",
        "apply_products_id": "apply_products_id9",
        "exclude_products_id": "exclude_products_id3",
        "valid_from_date": "valid_from_date5",
        "valid_from_local_time": "valid_from_local_time3",
        "valid_until_date": "valid_until_date7",
        "valid_until_local_time": "valid_until_local_time7",
        "exclude_strategy": "MOST_EXPENSIVE",
        "minimum_order_subtotal_money": {},
        "customer_group_ids_any": [
          "customer_group_ids_any6",
          "customer_group_ids_any7",
          "customer_group_ids_any8"
        ]
      },
      "image_data": {
        "name": "name7",
        "url": "url1",
        "caption": "caption1",
        "photo_studio_order_id": "photo_studio_order_id9"
      },
      "measurement_unit_data": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name7",
            "abbreviation": "abbreviation9"
          },
          "area_unit": "IMPERIAL_SQUARE_INCH",
          "length_unit": "METRIC_KILOMETER",
          "volume_unit": "IMPERIAL_CUBIC_FOOT",
          "weight_unit": "METRIC_MILLIGRAM",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_MINUTE",
          "type": "TYPE_VOLUME"
        },
        "precision": 5
      },
      "subscription_plan_data": {
        "name": "name3",
        "phases": [
          {},
          {},
          {}
        ]
      },
      "item_option_data": {
        "name": "name1",
        "display_name": "display_name1",
        "description": "description9",
        "show_colors": true,
        "values": [
          {}
        ]
      },
      "item_option_value_data": {
        "item_option_id": "item_option_id9",
        "name": "name7",
        "description": "description7",
        "color": "color1",
        "ordinal": 103
      },
      "custom_attribute_definition_data": {
        "type": "SELECTION",
        "name": "name5",
        "description": "description5",
        "source_application": {
          "product": "DASHBOARD",
          "application_id": "application_id3",
          "name": "name7"
        },
        "allowed_object_types": [
          "MEASUREMENT_UNIT",
          "ITEM_OPTION",
          "ITEM_OPTION_VAL"
        ],
        "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
        "app_visibility": "APP_VISIBILITY_READ_ONLY",
        "string_config": {
          "enforce_uniqueness": true
        },
        "number_config": {
          "precision": 47
        },
        "selection_config": {
          "max_allowed_selections": 93,
          "allowed_selections": [
            {},
            {}
          ]
        },
        "custom_attribute_usage_count": 185,
        "key": "key5"
      },
      "quick_amounts_settings_data": {
        "option": "MANUAL",
        "eligible_for_auto_amounts": true,
        "amounts": [
          {}
        ]
      }
    }
  ]
}
```

