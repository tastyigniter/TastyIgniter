
# Create Payment Link Response

## Structure

`CreatePaymentLinkResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `paymentLink` | [`?PaymentLink`](../../doc/models/payment-link.md) | Optional | - | getPaymentLink(): ?PaymentLink | setPaymentLink(?PaymentLink paymentLink): void |
| `relatedResources` | [`?PaymentLinkRelatedResources`](../../doc/models/payment-link-related-resources.md) | Optional | - | getRelatedResources(): ?PaymentLinkRelatedResources | setRelatedResources(?PaymentLinkRelatedResources relatedResources): void |

## Example (as JSON)

```json
{
  "errors": [
    {
      "category": "AUTHENTICATION_ERROR",
      "code": "REFUND_ALREADY_PENDING",
      "detail": "detail1",
      "field": "field9"
    },
    {
      "category": "INVALID_REQUEST_ERROR",
      "code": "PAYMENT_NOT_REFUNDABLE",
      "detail": "detail2",
      "field": "field0"
    },
    {
      "category": "RATE_LIMIT_ERROR",
      "code": "REFUND_DECLINED",
      "detail": "detail3",
      "field": "field1"
    }
  ],
  "payment_link": {
    "id": "id2",
    "version": 184,
    "description": "description2",
    "order_id": "order_id6",
    "checkout_options": {
      "allow_tipping": false,
      "custom_fields": [
        {
          "title": "title1"
        },
        {
          "title": "title2"
        }
      ],
      "subscription_plan_id": "subscription_plan_id0",
      "redirect_url": "redirect_url4",
      "merchant_support_email": "merchant_support_email0",
      "ask_for_shipping_address": false,
      "accepted_payment_methods": {
        "apple_pay": false,
        "google_pay": false,
        "cash_app_pay": false,
        "afterpay_clearpay": false
      },
      "app_fee_money": {
        "amount": 38,
        "currency": "MZN"
      },
      "shipping_fee": {
        "name": "name4",
        "charge": {
          "amount": 108,
          "currency": "XPF"
        }
      }
    },
    "pre_populated_data": {
      "buyer_email": "buyer_email6",
      "buyer_phone_number": "buyer_phone_number8",
      "buyer_address": {
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
        "country": "AO",
        "first_name": "first_name4",
        "last_name": "last_name2"
      }
    },
    "url": "url6",
    "long_url": "long_url8",
    "created_at": "created_at0",
    "updated_at": "updated_at2",
    "payment_note": "payment_note0"
  },
  "related_resources": {
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
                "area_unit": "METRIC_SQUARE_KILOMETER",
                "length_unit": "IMPERIAL_FOOT",
                "volume_unit": "GENERIC_PINT",
                "weight_unit": "METRIC_MILLIGRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_HOUR",
                "type": "TYPE_VOLUME"
              },
              "precision": 99,
              "catalog_object_id": "catalog_object_id7",
              "catalog_version": 223
            },
            "note": "note1",
            "catalog_object_id": "catalog_object_id3",
            "catalog_version": 81,
            "variation_name": "variation_name3",
            "item_type": "ITEM",
            "metadata": {
              "key0": "metadata0",
              "key1": "metadata1",
              "key2": "metadata2"
            },
            "modifiers": [
              {
                "uid": "uid4",
                "catalog_object_id": "catalog_object_id8",
                "catalog_version": 236,
                "name": "name4",
                "quantity": "quantity0",
                "base_price_money": {
                  "amount": 220,
                  "currency": "UYU"
                },
                "total_price_money": {
                  "amount": 218,
                  "currency": "GTQ"
                },
                "metadata": {
                  "key0": "metadata1",
                  "key1": "metadata0",
                  "key2": "metadata9"
                }
              },
              {
                "uid": "uid5",
                "catalog_object_id": "catalog_object_id9",
                "catalog_version": 237,
                "name": "name5",
                "quantity": "quantity1",
                "base_price_money": {
                  "amount": 221,
                  "currency": "UZS"
                },
                "total_price_money": {
                  "amount": 219,
                  "currency": "GYD"
                },
                "metadata": {
                  "key0": "metadata2",
                  "key1": "metadata1"
                }
              }
            ],
            "applied_taxes": [
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
                "uid": "uid7",
                "discount_uid": "discount_uid7",
                "applied_money": {}
              },
              {
                "uid": "uid8",
                "discount_uid": "discount_uid6",
                "applied_money": {}
              },
              {
                "uid": "uid9",
                "discount_uid": "discount_uid5",
                "applied_money": {}
              }
            ],
            "applied_service_charges": [
              {
                "uid": "uid8",
                "service_charge_uid": "service_charge_uid8",
                "applied_money": {}
              },
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
                  "uid": "uid6",
                  "discount_uid": "discount_uid2",
                  "discount_catalog_object_id": "discount_catalog_object_id8"
                }
              ],
              "blocked_taxes": [
                {
                  "uid": "uid4",
                  "tax_uid": "tax_uid0",
                  "tax_catalog_object_id": "tax_catalog_object_id8"
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
                "area_unit": "IMPERIAL_ACRE",
                "length_unit": "IMPERIAL_INCH",
                "volume_unit": "GENERIC_QUART",
                "weight_unit": "IMPERIAL_STONE",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_MINUTE",
                "type": "TYPE_LENGTH"
              },
              "precision": 100,
              "catalog_object_id": "catalog_object_id6",
              "catalog_version": 222
            },
            "note": "note0",
            "catalog_object_id": "catalog_object_id2",
            "catalog_version": 80,
            "variation_name": "variation_name4",
            "item_type": "CUSTOM_AMOUNT",
            "metadata": {
              "key0": "metadata9",
              "key1": "metadata0"
            },
            "modifiers": [
              {
                "uid": "uid5",
                "catalog_object_id": "catalog_object_id9",
                "catalog_version": 237,
                "name": "name5",
                "quantity": "quantity1",
                "base_price_money": {
                  "amount": 221,
                  "currency": "UZS"
                },
                "total_price_money": {
                  "amount": 219,
                  "currency": "GYD"
                },
                "metadata": {
                  "key0": "metadata2",
                  "key1": "metadata1"
                }
              },
              {
                "uid": "uid6",
                "catalog_object_id": "catalog_object_id0",
                "catalog_version": 238,
                "name": "name6",
                "quantity": "quantity2",
                "base_price_money": {
                  "amount": 222,
                  "currency": "VEF"
                },
                "total_price_money": {
                  "amount": 220,
                  "currency": "HKD"
                },
                "metadata": {
                  "key0": "metadata3"
                }
              },
              {
                "uid": "uid7",
                "catalog_object_id": "catalog_object_id1",
                "catalog_version": 239,
                "name": "name7",
                "quantity": "quantity3",
                "base_price_money": {
                  "amount": 223,
                  "currency": "VND"
                },
                "total_price_money": {
                  "amount": 221,
                  "currency": "HNL"
                },
                "metadata": {
                  "key0": "metadata4",
                  "key1": "metadata3",
                  "key2": "metadata2"
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
              },
              {
                "uid": "uid6",
                "tax_uid": "tax_uid8",
                "applied_money": {}
              }
            ],
            "applied_discounts": [
              {
                "uid": "uid8",
                "discount_uid": "discount_uid6",
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
                },
                {
                  "uid": "uid8",
                  "discount_uid": "discount_uid4",
                  "discount_catalog_object_id": "discount_catalog_object_id0"
                }
              ],
              "blocked_taxes": [
                {
                  "uid": "uid5",
                  "tax_uid": "tax_uid9",
                  "tax_catalog_object_id": "tax_catalog_object_id9"
                },
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
            "catalog_version": 139,
            "name": "name9",
            "type": "ADDITIVE",
            "percentage": "percentage7",
            "metadata": {
              "key0": "metadata4",
              "key1": "metadata5"
            },
            "applied_money": {},
            "scope": "LINE_ITEM",
            "auto_applied": true
          }
        ],
        "discounts": [
          {
            "uid": "uid7",
            "catalog_object_id": "catalog_object_id1",
            "catalog_version": 165,
            "name": "name7",
            "type": "FIXED_AMOUNT",
            "percentage": "percentage5",
            "amount_money": {},
            "applied_money": {},
            "metadata": {
              "key0": "metadata2",
              "key1": "metadata1",
              "key2": "metadata0"
            },
            "scope": "ORDER",
            "reward_ids": [
              "reward_ids4",
              "reward_ids5"
            ],
            "pricing_rule_id": "pricing_rule_id9"
          }
        ],
        "service_charges": [
          {
            "uid": "uid7",
            "name": "name7",
            "catalog_object_id": "catalog_object_id9",
            "catalog_version": 151,
            "percentage": "percentage5",
            "amount_money": {},
            "applied_money": {},
            "total_money": {},
            "total_tax_money": {},
            "calculation_phase": "TOTAL_PHASE",
            "taxable": true,
            "applied_taxes": [
              {},
              {}
            ],
            "metadata": {
              "key0": "metadata6",
              "key1": "metadata7",
              "key2": "metadata8"
            },
            "type": "CUSTOM",
            "treatment_type": "APPORTIONED_TREATMENT",
            "scope": "ORDER"
          },
          {
            "uid": "uid6",
            "name": "name6",
            "catalog_object_id": "catalog_object_id0",
            "catalog_version": 152,
            "percentage": "percentage4",
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
              "key0": "metadata7"
            },
            "type": "AUTO_GRATUITY",
            "treatment_type": "LINE_ITEM_TREATMENT",
            "scope": "OTHER_SERVICE_CHARGE_SCOPE"
          }
        ],
        "fulfillments": [
          {
            "uid": "uid2",
            "type": "SHIPMENT",
            "state": "PREPARED",
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
                "uid": "uid8",
                "line_item_uid": "line_item_uid8",
                "quantity": "quantity4",
                "metadata": {
                  "key0": "metadata5"
                }
              }
            ],
            "metadata": {
              "key0": "metadata9",
              "key1": "metadata8"
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
                  "country": "SK",
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
                "email_address": "email_address6",
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
                  "country": "TT",
                  "first_name": "first_name2",
                  "last_name": "last_name0"
                }
              },
              "carrier": "carrier6",
              "shipping_note": "shipping_note0",
              "shipping_type": "shipping_type2",
              "tracking_number": "tracking_number2",
              "tracking_url": "tracking_url6",
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
                "catalog_version": 38,
                "variation_name": "variation_name6",
                "item_type": "GIFT_CARD",
                "return_modifiers": [
                  {
                    "uid": "uid5",
                    "source_modifier_uid": "source_modifier_uid1",
                    "catalog_object_id": "catalog_object_id1",
                    "catalog_version": 161,
                    "name": "name5",
                    "base_price_money": {},
                    "total_price_money": {},
                    "quantity": "quantity1"
                  },
                  {
                    "uid": "uid6",
                    "source_modifier_uid": "source_modifier_uid0",
                    "catalog_object_id": "catalog_object_id0",
                    "catalog_version": 160,
                    "name": "name6",
                    "base_price_money": {},
                    "total_price_money": {},
                    "quantity": "quantity2"
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
                "uid": "uid5",
                "source_line_item_uid": "source_line_item_uid7",
                "name": "name5",
                "quantity": "quantity1",
                "quantity_unit": {},
                "note": "note9",
                "catalog_object_id": "catalog_object_id1",
                "catalog_version": 39,
                "variation_name": "variation_name5",
                "item_type": "CUSTOM_AMOUNT",
                "return_modifiers": [
                  {
                    "uid": "uid6",
                    "source_modifier_uid": "source_modifier_uid0",
                    "catalog_object_id": "catalog_object_id0",
                    "catalog_version": 160,
                    "name": "name6",
                    "base_price_money": {},
                    "total_price_money": {},
                    "quantity": "quantity2"
                  },
                  {
                    "uid": "uid7",
                    "source_modifier_uid": "source_modifier_uid9",
                    "catalog_object_id": "catalog_object_id9",
                    "catalog_version": 159,
                    "name": "name7",
                    "base_price_money": {},
                    "total_price_money": {},
                    "quantity": "quantity3"
                  },
                  {
                    "uid": "uid8",
                    "source_modifier_uid": "source_modifier_uid8",
                    "catalog_object_id": "catalog_object_id8",
                    "catalog_version": 158,
                    "name": "name8",
                    "base_price_money": {},
                    "total_price_money": {},
                    "quantity": "quantity4"
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
                "uid": "uid4",
                "source_line_item_uid": "source_line_item_uid8",
                "name": "name4",
                "quantity": "quantity0",
                "quantity_unit": {},
                "note": "note0",
                "catalog_object_id": "catalog_object_id2",
                "catalog_version": 40,
                "variation_name": "variation_name4",
                "item_type": "ITEM",
                "return_modifiers": [
                  {
                    "uid": "uid7",
                    "source_modifier_uid": "source_modifier_uid9",
                    "catalog_object_id": "catalog_object_id9",
                    "catalog_version": 159,
                    "name": "name7",
                    "base_price_money": {},
                    "total_price_money": {},
                    "quantity": "quantity3"
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
                "uid": "uid0",
                "source_service_charge_uid": "source_service_charge_uid6",
                "name": "name0",
                "catalog_object_id": "catalog_object_id6",
                "catalog_version": 52,
                "percentage": "percentage8",
                "amount_money": {},
                "applied_money": {},
                "total_money": {},
                "total_tax_money": {},
                "calculation_phase": "SUBTOTAL_PHASE",
                "taxable": false,
                "applied_taxes": [
                  {}
                ],
                "treatment_type": "LINE_ITEM_TREATMENT",
                "scope": "OTHER_SERVICE_CHARGE_SCOPE"
              }
            ],
            "return_taxes": [
              {
                "uid": "uid3",
                "source_tax_uid": "source_tax_uid1",
                "catalog_object_id": "catalog_object_id3",
                "catalog_version": 167,
                "name": "name3",
                "type": "ADDITIVE",
                "percentage": "percentage1",
                "applied_money": {},
                "scope": "LINE_ITEM"
              },
              {
                "uid": "uid2",
                "source_tax_uid": "source_tax_uid0",
                "catalog_object_id": "catalog_object_id4",
                "catalog_version": 168,
                "name": "name2",
                "type": "INCLUSIVE",
                "percentage": "percentage0",
                "applied_money": {},
                "scope": "ORDER"
              },
              {
                "uid": "uid1",
                "source_tax_uid": "source_tax_uid9",
                "catalog_object_id": "catalog_object_id5",
                "catalog_version": 169,
                "name": "name1",
                "type": "UNKNOWN_TAX",
                "percentage": "percentage9",
                "applied_money": {},
                "scope": "OTHER_TAX_SCOPE"
              }
            ],
            "return_discounts": [
              {
                "uid": "uid7",
                "source_discount_uid": "source_discount_uid3",
                "catalog_object_id": "catalog_object_id9",
                "catalog_version": 27,
                "name": "name7",
                "type": "VARIABLE_PERCENTAGE",
                "percentage": "percentage5",
                "amount_money": {},
                "applied_money": {},
                "scope": "LINE_ITEM"
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
                "catalog_version": 39,
                "variation_name": "variation_name5",
                "item_type": "CUSTOM_AMOUNT",
                "return_modifiers": [
                  {
                    "uid": "uid6",
                    "source_modifier_uid": "source_modifier_uid0",
                    "catalog_object_id": "catalog_object_id0",
                    "catalog_version": 160,
                    "name": "name6",
                    "base_price_money": {},
                    "total_price_money": {},
                    "quantity": "quantity2"
                  },
                  {
                    "uid": "uid7",
                    "source_modifier_uid": "source_modifier_uid9",
                    "catalog_object_id": "catalog_object_id9",
                    "catalog_version": 159,
                    "name": "name7",
                    "base_price_money": {},
                    "total_price_money": {},
                    "quantity": "quantity3"
                  },
                  {
                    "uid": "uid8",
                    "source_modifier_uid": "source_modifier_uid8",
                    "catalog_object_id": "catalog_object_id8",
                    "catalog_version": 158,
                    "name": "name8",
                    "base_price_money": {},
                    "total_price_money": {},
                    "quantity": "quantity4"
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
                "uid": "uid9",
                "source_service_charge_uid": "source_service_charge_uid7",
                "name": "name9",
                "catalog_object_id": "catalog_object_id7",
                "catalog_version": 53,
                "percentage": "percentage7",
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
                "treatment_type": "APPORTIONED_TREATMENT",
                "scope": "LINE_ITEM"
              },
              {
                "uid": "uid8",
                "source_service_charge_uid": "source_service_charge_uid8",
                "name": "name8",
                "catalog_object_id": "catalog_object_id8",
                "catalog_version": 54,
                "percentage": "percentage6",
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
                "treatment_type": "LINE_ITEM_TREATMENT",
                "scope": "ORDER"
              }
            ],
            "return_taxes": [
              {
                "uid": "uid4",
                "source_tax_uid": "source_tax_uid2",
                "catalog_object_id": "catalog_object_id2",
                "catalog_version": 166,
                "name": "name4",
                "type": "UNKNOWN_TAX",
                "percentage": "percentage2",
                "applied_money": {},
                "scope": "OTHER_TAX_SCOPE"
              },
              {
                "uid": "uid3",
                "source_tax_uid": "source_tax_uid1",
                "catalog_object_id": "catalog_object_id3",
                "catalog_version": 167,
                "name": "name3",
                "type": "ADDITIVE",
                "percentage": "percentage1",
                "applied_money": {},
                "scope": "LINE_ITEM"
              }
            ],
            "return_discounts": [
              {
                "uid": "uid6",
                "source_discount_uid": "source_discount_uid4",
                "catalog_object_id": "catalog_object_id0",
                "catalog_version": 28,
                "name": "name6",
                "type": "VARIABLE_AMOUNT",
                "percentage": "percentage4",
                "amount_money": {},
                "applied_money": {},
                "scope": "ORDER"
              },
              {
                "uid": "uid7",
                "source_discount_uid": "source_discount_uid3",
                "catalog_object_id": "catalog_object_id9",
                "catalog_version": 27,
                "name": "name7",
                "type": "VARIABLE_PERCENTAGE",
                "percentage": "percentage5",
                "amount_money": {},
                "applied_money": {},
                "scope": "LINE_ITEM"
              },
              {
                "uid": "uid8",
                "source_discount_uid": "source_discount_uid2",
                "catalog_object_id": "catalog_object_id8",
                "catalog_version": 26,
                "name": "name8",
                "type": "FIXED_AMOUNT",
                "percentage": "percentage6",
                "amount_money": {},
                "applied_money": {},
                "scope": "OTHER_DISCOUNT_SCOPE"
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
            "id": "id8",
            "location_id": "location_id2",
            "transaction_id": "transaction_id6",
            "created_at": "created_at6",
            "note": "note4",
            "amount_money": {},
            "tip_money": {},
            "processing_fee_money": {},
            "customer_id": "customer_id6",
            "type": "THIRD_PARTY_CARD",
            "card_details": {
              "status": "AUTHORIZED",
              "card": {
                "id": "id0",
                "card_brand": "JCB",
                "last_4": "last_42",
                "exp_month": 248,
                "exp_year": 48,
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
                "version": 122,
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
              }
            ],
            "payment_id": "payment_id8"
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
            "status": "PENDING",
            "processing_fee_money": {},
            "additional_recipients": [
              {},
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
            "status": "FAILED",
            "processing_fee_money": {},
            "additional_recipients": [
              {}
            ]
          }
        ],
        "metadata": {
          "key0": "metadata7",
          "key1": "metadata8"
        },
        "created_at": "created_at4",
        "updated_at": "updated_at8",
        "closed_at": "closed_at8",
        "state": "OPEN",
        "version": 184,
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
          }
        ],
        "net_amount_due_money": {}
      }
    ],
    "subscription_plans": [
      {
        "type": "TAX",
        "id": "id0",
        "updated_at": "updated_at6",
        "version": 172,
        "is_deleted": false,
        "custom_attribute_values": {
          "key0": {
            "name": "name3",
            "string_value": "string_value7",
            "custom_attribute_definition_id": "custom_attribute_definition_id9",
            "type": "BOOLEAN",
            "number_value": "number_value3",
            "boolean_value": true,
            "selection_uid_values": [
              "selection_uid_values0",
              "selection_uid_values1"
            ],
            "key": "key3"
          },
          "key1": {
            "name": "name4",
            "string_value": "string_value8",
            "custom_attribute_definition_id": "custom_attribute_definition_id8",
            "type": "STRING",
            "number_value": "number_value4",
            "boolean_value": false,
            "selection_uid_values": [
              "selection_uid_values1",
              "selection_uid_values2",
              "selection_uid_values3"
            ],
            "key": "key4"
          }
        },
        "catalog_v1_ids": [
          {
            "catalog_v1_id": "catalog_v1_id4",
            "location_id": "location_id4"
          },
          {
            "catalog_v1_id": "catalog_v1_id5",
            "location_id": "location_id5"
          },
          {
            "catalog_v1_id": "catalog_v1_id6",
            "location_id": "location_id6"
          }
        ],
        "present_at_all_locations": false,
        "present_at_location_ids": [
          "present_at_location_ids0",
          "present_at_location_ids1"
        ],
        "absent_at_location_ids": [
          "absent_at_location_ids1",
          "absent_at_location_ids2",
          "absent_at_location_ids3"
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
            {
              "modifier_list_id": "modifier_list_id2",
              "modifier_overrides": [
                {
                  "modifier_id": "modifier_id5",
                  "on_by_default": true
                }
              ],
              "min_selected_modifiers": 188,
              "max_selected_modifiers": 168,
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
                }
              ],
              "min_selected_modifiers": 189,
              "max_selected_modifiers": 169,
              "enabled": true
            }
          ],
          "variations": [
            {
              "type": "TAX",
              "id": "id5",
              "updated_at": "updated_at9",
              "version": 93,
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
                "present_at_location_ids5",
                "present_at_location_ids6",
                "present_at_location_ids7"
              ],
              "absent_at_location_ids": [
                "absent_at_location_ids6"
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
                  "tax_ids5"
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
                    "item_option_id": "item_option_id8"
                  },
                  {
                    "item_option_id": "item_option_id7"
                  },
                  {
                    "item_option_id": "item_option_id6"
                  }
                ],
                "image_ids": [
                  "image_ids2"
                ],
                "sort_name": "sort_name5",
                "description_html": "description_html3",
                "description_plaintext": "description_plaintext3"
              },
              "category_data": {
                "name": "name9",
                "image_ids": [
                  "image_ids4",
                  "image_ids5",
                  "image_ids6"
                ]
              },
              "item_variation_data": {
                "item_id": "item_id9",
                "name": "name1",
                "sku": "sku3",
                "upc": "upc1",
                "ordinal": 143,
                "pricing_type": "VARIABLE_PRICING",
                "price_money": {},
                "location_overrides": [
                  {
                    "location_id": "location_id6",
                    "price_money": {},
                    "pricing_type": "FIXED_PRICING",
                    "track_inventory": false,
                    "inventory_alert_type": "NONE",
                    "inventory_alert_threshold": 82,
                    "sold_out": false,
                    "sold_out_valid_until": "sold_out_valid_until0"
                  },
                  {
                    "location_id": "location_id7",
                    "price_money": {},
                    "pricing_type": "VARIABLE_PRICING",
                    "track_inventory": true,
                    "inventory_alert_type": "LOW_QUANTITY",
                    "inventory_alert_threshold": 83,
                    "sold_out": true,
                    "sold_out_valid_until": "sold_out_valid_until1"
                  },
                  {
                    "location_id": "location_id8",
                    "price_money": {},
                    "pricing_type": "FIXED_PRICING",
                    "track_inventory": false,
                    "inventory_alert_type": "NONE",
                    "inventory_alert_threshold": 84,
                    "sold_out": false,
                    "sold_out_valid_until": "sold_out_valid_until2"
                  }
                ],
                "track_inventory": true,
                "inventory_alert_type": "LOW_QUANTITY",
                "inventory_alert_threshold": 111,
                "user_data": "user_data5",
                "service_duration": 233,
                "available_for_booking": true,
                "item_option_values": [
                  {
                    "item_option_id": "item_option_id0",
                    "item_option_value_id": "item_option_value_id2"
                  },
                  {
                    "item_option_id": "item_option_id1",
                    "item_option_value_id": "item_option_value_id1"
                  },
                  {
                    "item_option_id": "item_option_id2",
                    "item_option_value_id": "item_option_value_id0"
                  }
                ],
                "measurement_unit_id": "measurement_unit_id9",
                "sellable": true,
                "stockable": true,
                "image_ids": [
                  "image_ids6",
                  "image_ids5",
                  "image_ids4"
                ],
                "team_member_ids": [
                  "team_member_ids8",
                  "team_member_ids9"
                ],
                "stockable_conversion": {
                  "stockable_item_variation_id": "stockable_item_variation_id9",
                  "stockable_quantity": "stockable_quantity1",
                  "nonstockable_quantity": "nonstockable_quantity3"
                },
                "item_variation_vendor_info_ids": [
                  "item_variation_vendor_info_ids0"
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
                "ordinal": 177,
                "selection_type": "MULTIPLE",
                "modifiers": [
                  {}
                ],
                "image_ids": [
                  "image_ids6"
                ]
              },
              "modifier_data": {
                "name": "name7",
                "price_money": {},
                "ordinal": 155,
                "modifier_list_id": "modifier_list_id3",
                "image_id": "image_id1"
              },
              "time_period_data": {
                "event": "event1"
              },
              "product_set_data": {
                "name": "name3",
                "product_ids_any": [
                  "product_ids_any1",
                  "product_ids_any0"
                ],
                "product_ids_all": [
                  "product_ids_all4",
                  "product_ids_all3"
                ],
                "quantity_exact": 241,
                "quantity_min": 119,
                "quantity_max": 93,
                "all_products": true
              },
              "pricing_rule_data": {
                "name": "name5",
                "time_period_ids": [
                  "time_period_ids7",
                  "time_period_ids8"
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
                  "customer_group_ids_any4",
                  "customer_group_ids_any5"
                ]
              },
              "image_data": {
                "name": "name5",
                "url": "url9",
                "caption": "caption9",
                "photo_studio_order_id": "photo_studio_order_id7"
              },
              "measurement_unit_data": {
                "measurement_unit": {},
                "precision": 39
              },
              "subscription_plan_data": {
                "name": "name5",
                "phases": [
                  {
                    "uid": "uid0",
                    "cadence": "ANNUAL",
                    "periods": 92,
                    "recurring_price_money": {},
                    "ordinal": 58
                  }
                ]
              },
              "item_option_data": {
                "name": "name1",
                "display_name": "display_name1",
                "description": "description9",
                "show_colors": true,
                "values": [
                  {},
                  {},
                  {}
                ]
              },
              "item_option_value_data": {
                "item_option_id": "item_option_id7",
                "name": "name5",
                "description": "description5",
                "color": "color9",
                "ordinal": 69
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
                  "ITEM_OPTION_VAL"
                ],
                "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
                "app_visibility": "APP_VISIBILITY_READ_WRITE_VALUES",
                "string_config": {
                  "enforce_uniqueness": true
                },
                "number_config": {
                  "precision": 81
                },
                "selection_config": {
                  "max_allowed_selections": 59,
                  "allowed_selections": [
                    {
                      "uid": "uid2",
                      "name": "name2"
                    },
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
                "custom_attribute_usage_count": 151,
                "key": "key3"
              },
              "quick_amounts_settings_data": {
                "option": "AUTO",
                "eligible_for_auto_amounts": true,
                "amounts": [
                  {
                    "type": "QUICK_AMOUNT_TYPE_AUTO",
                    "amount": {},
                    "score": 241,
                    "ordinal": 173
                  },
                  {
                    "type": "QUICK_AMOUNT_TYPE_MANUAL",
                    "amount": {},
                    "score": 242,
                    "ordinal": 174
                  }
                ]
              }
            },
            {
              "type": "DISCOUNT",
              "id": "id4",
              "updated_at": "updated_at0",
              "version": 92,
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
                "present_at_location_ids4",
                "present_at_location_ids5"
              ],
              "absent_at_location_ids": [
                "absent_at_location_ids5",
                "absent_at_location_ids6",
                "absent_at_location_ids7"
              ],
              "item_data": {
                "name": "name4",
                "description": "description4",
                "abbreviation": "abbreviation6",
                "label_color": "label_color6",
                "available_online": false,
                "available_for_pickup": false,
                "available_electronically": false,
                "category_id": "category_id4",
                "tax_ids": [
                  "tax_ids7"
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
                    "item_option_id": "item_option_id7"
                  }
                ],
                "image_ids": [
                  "image_ids1",
                  "image_ids0"
                ],
                "sort_name": "sort_name4",
                "description_html": "description_html4",
                "description_plaintext": "description_plaintext4"
              },
              "category_data": {
                "name": "name8",
                "image_ids": [
                  "image_ids3",
                  "image_ids4"
                ]
              },
              "item_variation_data": {
                "item_id": "item_id0",
                "name": "name0",
                "sku": "sku4",
                "upc": "upc2",
                "ordinal": 142,
                "pricing_type": "FIXED_PRICING",
                "price_money": {},
                "location_overrides": [
                  {
                    "location_id": "location_id5",
                    "price_money": {},
                    "pricing_type": "VARIABLE_PRICING",
                    "track_inventory": true,
                    "inventory_alert_type": "LOW_QUANTITY",
                    "inventory_alert_threshold": 81,
                    "sold_out": true,
                    "sold_out_valid_until": "sold_out_valid_until9"
                  },
                  {
                    "location_id": "location_id6",
                    "price_money": {},
                    "pricing_type": "FIXED_PRICING",
                    "track_inventory": false,
                    "inventory_alert_type": "NONE",
                    "inventory_alert_threshold": 82,
                    "sold_out": false,
                    "sold_out_valid_until": "sold_out_valid_until0"
                  }
                ],
                "track_inventory": false,
                "inventory_alert_type": "NONE",
                "inventory_alert_threshold": 112,
                "user_data": "user_data6",
                "service_duration": 232,
                "available_for_booking": false,
                "item_option_values": [
                  {
                    "item_option_id": "item_option_id1",
                    "item_option_value_id": "item_option_value_id1"
                  }
                ],
                "measurement_unit_id": "measurement_unit_id0",
                "sellable": false,
                "stockable": false,
                "image_ids": [
                  "image_ids5"
                ],
                "team_member_ids": [
                  "team_member_ids7"
                ],
                "stockable_conversion": {
                  "stockable_item_variation_id": "stockable_item_variation_id8",
                  "stockable_quantity": "stockable_quantity0",
                  "nonstockable_quantity": "nonstockable_quantity2"
                },
                "item_variation_vendor_info_ids": [
                  "item_variation_vendor_info_ids9",
                  "item_variation_vendor_info_ids0",
                  "item_variation_vendor_info_ids1"
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
                "name": "name8",
                "discount_type": "VARIABLE_PERCENTAGE",
                "percentage": "percentage6",
                "amount_money": {},
                "pin_required": false,
                "label_color": "label_color0",
                "modify_tax_basis": "MODIFY_TAX_BASIS",
                "maximum_amount_money": {}
              },
              "modifier_list_data": {
                "name": "name2",
                "ordinal": 178,
                "selection_type": "SINGLE",
                "modifiers": [
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
                "name": "name8",
                "price_money": {},
                "ordinal": 156,
                "modifier_list_id": "modifier_list_id4",
                "image_id": "image_id2"
              },
              "time_period_data": {
                "event": "event2"
              },
              "product_set_data": {
                "name": "name2",
                "product_ids_any": [
                  "product_ids_any2"
                ],
                "product_ids_all": [
                  "product_ids_all5"
                ],
                "quantity_exact": 240,
                "quantity_min": 118,
                "quantity_max": 92,
                "all_products": false
              },
              "pricing_rule_data": {
                "name": "name6",
                "time_period_ids": [
                  "time_period_ids8",
                  "time_period_ids9",
                  "time_period_ids0"
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
                  "customer_group_ids_any6",
                  "customer_group_ids_any7"
                ]
              },
              "image_data": {
                "name": "name4",
                "url": "url8",
                "caption": "caption8",
                "photo_studio_order_id": "photo_studio_order_id6"
              },
              "measurement_unit_data": {
                "measurement_unit": {},
                "precision": 40
              },
              "subscription_plan_data": {
                "name": "name6",
                "phases": [
                  {
                    "uid": "uid9",
                    "cadence": "EVERY_TWO_YEARS",
                    "periods": 91,
                    "recurring_price_money": {},
                    "ordinal": 57
                  },
                  {
                    "uid": "uid8",
                    "cadence": "DAILY",
                    "periods": 90,
                    "recurring_price_money": {},
                    "ordinal": 56
                  }
                ]
              },
              "item_option_data": {
                "name": "name2",
                "display_name": "display_name2",
                "description": "description8",
                "show_colors": false,
                "values": [
                  {},
                  {}
                ]
              },
              "item_option_value_data": {
                "item_option_id": "item_option_id6",
                "name": "name4",
                "description": "description4",
                "color": "color8",
                "ordinal": 68
              },
              "custom_attribute_definition_data": {
                "type": "STRING",
                "name": "name2",
                "description": "description2",
                "source_application": {
                  "product": "INVOICES",
                  "application_id": "application_id0",
                  "name": "name4"
                },
                "allowed_object_types": [
                  "CUSTOM_ATTRIBUTE_DEFINITION",
                  "ITEM_OPTION_VAL",
                  "ITEM_OPTION"
                ],
                "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
                "app_visibility": "APP_VISIBILITY_READ_ONLY",
                "string_config": {
                  "enforce_uniqueness": false
                },
                "number_config": {
                  "precision": 82
                },
                "selection_config": {
                  "max_allowed_selections": 58,
                  "allowed_selections": [
                    {
                      "uid": "uid1",
                      "name": "name1"
                    },
                    {
                      "uid": "uid2",
                      "name": "name2"
                    }
                  ]
                },
                "custom_attribute_usage_count": 150,
                "key": "key2"
              },
              "quick_amounts_settings_data": {
                "option": "MANUAL",
                "eligible_for_auto_amounts": false,
                "amounts": [
                  {
                    "type": "QUICK_AMOUNT_TYPE_MANUAL",
                    "amount": {},
                    "score": 240,
                    "ordinal": 172
                  }
                ]
              }
            },
            {
              "type": "MODIFIER_LIST",
              "id": "id3",
              "updated_at": "updated_at1",
              "version": 91,
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
                "present_at_location_ids3"
              ],
              "absent_at_location_ids": [
                "absent_at_location_ids4",
                "absent_at_location_ids5"
              ],
              "item_data": {
                "name": "name5",
                "description": "description5",
                "abbreviation": "abbreviation7",
                "label_color": "label_color7",
                "available_online": true,
                "available_for_pickup": true,
                "available_electronically": true,
                "category_id": "category_id3",
                "tax_ids": [
                  "tax_ids8",
                  "tax_ids7",
                  "tax_ids6"
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
                    "item_option_id": "item_option_id6"
                  },
                  {
                    "item_option_id": "item_option_id5"
                  }
                ],
                "image_ids": [
                  "image_ids0",
                  "image_ids9",
                  "image_ids8"
                ],
                "sort_name": "sort_name3",
                "description_html": "description_html5",
                "description_plaintext": "description_plaintext5"
              },
              "category_data": {
                "name": "name7",
                "image_ids": [
                  "image_ids2"
                ]
              },
              "item_variation_data": {
                "item_id": "item_id1",
                "name": "name9",
                "sku": "sku5",
                "upc": "upc3",
                "ordinal": 141,
                "pricing_type": "VARIABLE_PRICING",
                "price_money": {},
                "location_overrides": [
                  {
                    "location_id": "location_id4",
                    "price_money": {},
                    "pricing_type": "FIXED_PRICING",
                    "track_inventory": false,
                    "inventory_alert_type": "NONE",
                    "inventory_alert_threshold": 80,
                    "sold_out": false,
                    "sold_out_valid_until": "sold_out_valid_until8"
                  }
                ],
                "track_inventory": true,
                "inventory_alert_type": "LOW_QUANTITY",
                "inventory_alert_threshold": 113,
                "user_data": "user_data7",
                "service_duration": 231,
                "available_for_booking": true,
                "item_option_values": [
                  {
                    "item_option_id": "item_option_id2",
                    "item_option_value_id": "item_option_value_id0"
                  },
                  {
                    "item_option_id": "item_option_id3",
                    "item_option_value_id": "item_option_value_id9"
                  }
                ],
                "measurement_unit_id": "measurement_unit_id1",
                "sellable": true,
                "stockable": true,
                "image_ids": [
                  "image_ids4",
                  "image_ids3"
                ],
                "team_member_ids": [
                  "team_member_ids6",
                  "team_member_ids7",
                  "team_member_ids8"
                ],
                "stockable_conversion": {
                  "stockable_item_variation_id": "stockable_item_variation_id7",
                  "stockable_quantity": "stockable_quantity9",
                  "nonstockable_quantity": "nonstockable_quantity1"
                },
                "item_variation_vendor_info_ids": [
                  "item_variation_vendor_info_ids8",
                  "item_variation_vendor_info_ids9"
                ]
              },
              "tax_data": {
                "name": "name7",
                "calculation_phase": "TAX_TOTAL_PHASE",
                "inclusion_type": "INCLUSIVE",
                "percentage": "percentage5",
                "applies_to_custom_amounts": true,
                "enabled": true
              },
              "discount_data": {
                "name": "name9",
                "discount_type": "VARIABLE_AMOUNT",
                "percentage": "percentage7",
                "amount_money": {},
                "pin_required": true,
                "label_color": "label_color1",
                "modify_tax_basis": "DO_NOT_MODIFY_TAX_BASIS",
                "maximum_amount_money": {}
              },
              "modifier_list_data": {
                "name": "name3",
                "ordinal": 179,
                "selection_type": "MULTIPLE",
                "modifiers": [
                  {},
                  {},
                  {}
                ],
                "image_ids": [
                  "image_ids8",
                  "image_ids7"
                ]
              },
              "modifier_data": {
                "name": "name9",
                "price_money": {},
                "ordinal": 157,
                "modifier_list_id": "modifier_list_id5",
                "image_id": "image_id3"
              },
              "time_period_data": {
                "event": "event3"
              },
              "product_set_data": {
                "name": "name1",
                "product_ids_any": [
                  "product_ids_any3",
                  "product_ids_any2",
                  "product_ids_any1"
                ],
                "product_ids_all": [
                  "product_ids_all6",
                  "product_ids_all5",
                  "product_ids_all4"
                ],
                "quantity_exact": 239,
                "quantity_min": 117,
                "quantity_max": 91,
                "all_products": true
              },
              "pricing_rule_data": {
                "name": "name7",
                "time_period_ids": [
                  "time_period_ids9"
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
                  "customer_group_ids_any6"
                ]
              },
              "image_data": {
                "name": "name3",
                "url": "url7",
                "caption": "caption7",
                "photo_studio_order_id": "photo_studio_order_id5"
              },
              "measurement_unit_data": {
                "measurement_unit": {},
                "precision": 41
              },
              "subscription_plan_data": {
                "name": "name7",
                "phases": [
                  {
                    "uid": "uid8",
                    "cadence": "DAILY",
                    "periods": 90,
                    "recurring_price_money": {},
                    "ordinal": 56
                  },
                  {
                    "uid": "uid7",
                    "cadence": "WEEKLY",
                    "periods": 89,
                    "recurring_price_money": {},
                    "ordinal": 55
                  },
                  {
                    "uid": "uid6",
                    "cadence": "EVERY_TWO_WEEKS",
                    "periods": 88,
                    "recurring_price_money": {},
                    "ordinal": 54
                  }
                ]
              },
              "item_option_data": {
                "name": "name3",
                "display_name": "display_name3",
                "description": "description7",
                "show_colors": true,
                "values": [
                  {}
                ]
              },
              "item_option_value_data": {
                "item_option_id": "item_option_id5",
                "name": "name3",
                "description": "description3",
                "color": "color7",
                "ordinal": 67
              },
              "custom_attribute_definition_data": {
                "type": "BOOLEAN",
                "name": "name1",
                "description": "description1",
                "source_application": {
                  "product": "APPOINTMENTS",
                  "application_id": "application_id9",
                  "name": "name3"
                },
                "allowed_object_types": [
                  "QUICK_AMOUNTS_SETTINGS",
                  "CUSTOM_ATTRIBUTE_DEFINITION"
                ],
                "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
                "app_visibility": "APP_VISIBILITY_HIDDEN",
                "string_config": {
                  "enforce_uniqueness": true
                },
                "number_config": {
                  "precision": 83
                },
                "selection_config": {
                  "max_allowed_selections": 57,
                  "allowed_selections": [
                    {
                      "uid": "uid0",
                      "name": "name0"
                    }
                  ]
                },
                "custom_attribute_usage_count": 149,
                "key": "key1"
              },
              "quick_amounts_settings_data": {
                "option": "DISABLED",
                "eligible_for_auto_amounts": true,
                "amounts": [
                  {
                    "type": "QUICK_AMOUNT_TYPE_AUTO",
                    "amount": {},
                    "score": 239,
                    "ordinal": 171
                  },
                  {
                    "type": "QUICK_AMOUNT_TYPE_MANUAL",
                    "amount": {},
                    "score": 240,
                    "ordinal": 172
                  },
                  {
                    "type": "QUICK_AMOUNT_TYPE_AUTO",
                    "amount": {},
                    "score": 241,
                    "ordinal": 173
                  }
                ]
              }
            }
          ],
          "product_type": "REGULAR",
          "skip_modifier_screen": false,
          "item_options": [
            {}
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
          "name": "name4",
          "image_ids": [
            "image_ids9",
            "image_ids0"
          ]
        },
        "item_variation_data": {
          "item_id": "item_id6",
          "name": "name6",
          "sku": "sku2",
          "upc": "upc4",
          "ordinal": 222,
          "pricing_type": "FIXED_PRICING",
          "price_money": {},
          "location_overrides": [
            {},
            {}
          ],
          "track_inventory": false,
          "inventory_alert_type": "NONE",
          "inventory_alert_threshold": 224,
          "user_data": "user_data0",
          "service_duration": 56,
          "available_for_booking": false,
          "item_option_values": [
            {}
          ],
          "measurement_unit_id": "measurement_unit_id6",
          "sellable": false,
          "stockable": false,
          "image_ids": [
            "image_ids1"
          ],
          "team_member_ids": [
            "team_member_ids3"
          ],
          "stockable_conversion": {
            "stockable_item_variation_id": "stockable_item_variation_id4",
            "stockable_quantity": "stockable_quantity6",
            "nonstockable_quantity": "nonstockable_quantity8"
          },
          "item_variation_vendor_info_ids": [
            "item_variation_vendor_info_ids5",
            "item_variation_vendor_info_ids6",
            "item_variation_vendor_info_ids7"
          ]
        },
        "tax_data": {
          "name": "name4",
          "calculation_phase": "TAX_SUBTOTAL_PHASE",
          "inclusion_type": "ADDITIVE",
          "percentage": "percentage2",
          "applies_to_custom_amounts": false,
          "enabled": false
        },
        "discount_data": {
          "name": "name8",
          "discount_type": "VARIABLE_PERCENTAGE",
          "percentage": "percentage6",
          "amount_money": {},
          "pin_required": false,
          "label_color": "label_color0",
          "modify_tax_basis": "MODIFY_TAX_BASIS",
          "maximum_amount_money": {}
        },
        "modifier_list_data": {
          "name": "name4",
          "ordinal": 62,
          "selection_type": "SINGLE",
          "modifiers": [
            {},
            {}
          ],
          "image_ids": [
            "image_ids9",
            "image_ids0"
          ]
        },
        "modifier_data": {
          "name": "name8",
          "price_money": {},
          "ordinal": 84,
          "modifier_list_id": "modifier_list_id4",
          "image_id": "image_id2"
        },
        "time_period_data": {
          "event": "event4"
        },
        "product_set_data": {
          "name": "name8",
          "product_ids_any": [
            "product_ids_any4"
          ],
          "product_ids_all": [
            "product_ids_all1"
          ],
          "quantity_exact": 64,
          "quantity_min": 198,
          "quantity_max": 172,
          "all_products": false
        },
        "pricing_rule_data": {
          "name": "name0",
          "time_period_ids": [
            "time_period_ids2",
            "time_period_ids3",
            "time_period_ids4"
          ],
          "discount_id": "discount_id8",
          "match_products_id": "match_products_id8",
          "apply_products_id": "apply_products_id4",
          "exclude_products_id": "exclude_products_id6",
          "valid_from_date": "valid_from_date8",
          "valid_from_local_time": "valid_from_local_time0",
          "valid_until_date": "valid_until_date6",
          "valid_until_local_time": "valid_until_local_time6",
          "exclude_strategy": "LEAST_EXPENSIVE",
          "minimum_order_subtotal_money": {},
          "customer_group_ids_any": [
            "customer_group_ids_any9",
            "customer_group_ids_any0",
            "customer_group_ids_any1"
          ]
        },
        "image_data": {
          "name": "name0",
          "url": "url4",
          "caption": "caption4",
          "photo_studio_order_id": "photo_studio_order_id2"
        },
        "measurement_unit_data": {
          "measurement_unit": {},
          "precision": 176
        },
        "subscription_plan_data": {
          "name": "name0",
          "phases": [
            {}
          ]
        },
        "item_option_data": {
          "name": "name4",
          "display_name": "display_name4",
          "description": "description4",
          "show_colors": false,
          "values": [
            {}
          ]
        },
        "item_option_value_data": {
          "item_option_id": "item_option_id2",
          "name": "name0",
          "description": "description0",
          "color": "color4",
          "ordinal": 148
        },
        "custom_attribute_definition_data": {
          "type": "STRING",
          "name": "name8",
          "description": "description8",
          "source_application": {
            "product": "SQUARE_POS",
            "application_id": "application_id6",
            "name": "name0"
          },
          "allowed_object_types": [
            "ITEM_OPTION",
            "ITEM_OPTION_VAL",
            "CUSTOM_ATTRIBUTE_DEFINITION"
          ],
          "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
          "app_visibility": "APP_VISIBILITY_READ_ONLY",
          "string_config": {
            "enforce_uniqueness": false
          },
          "number_config": {
            "precision": 134
          },
          "selection_config": {
            "max_allowed_selections": 138,
            "allowed_selections": [
              {},
              {}
            ]
          },
          "custom_attribute_usage_count": 230,
          "key": "key8"
        },
        "quick_amounts_settings_data": {
          "option": "MANUAL",
          "eligible_for_auto_amounts": false,
          "amounts": [
            {}
          ]
        }
      },
      {
        "type": "DISCOUNT",
        "id": "id1",
        "updated_at": "updated_at7",
        "version": 173,
        "is_deleted": true,
        "custom_attribute_values": {
          "key0": {
            "name": "name4",
            "string_value": "string_value8",
            "custom_attribute_definition_id": "custom_attribute_definition_id8",
            "type": "STRING",
            "number_value": "number_value4",
            "boolean_value": false,
            "selection_uid_values": [
              "selection_uid_values1",
              "selection_uid_values2",
              "selection_uid_values3"
            ],
            "key": "key4"
          },
          "key1": {
            "name": "name5",
            "string_value": "string_value9",
            "custom_attribute_definition_id": "custom_attribute_definition_id7",
            "type": "SELECTION",
            "number_value": "number_value5",
            "boolean_value": true,
            "selection_uid_values": [
              "selection_uid_values2"
            ],
            "key": "key5"
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
              "selection_uid_values4"
            ],
            "key": "key6"
          }
        },
        "catalog_v1_ids": [
          {
            "catalog_v1_id": "catalog_v1_id5",
            "location_id": "location_id5"
          }
        ],
        "present_at_all_locations": true,
        "present_at_location_ids": [
          "present_at_location_ids1",
          "present_at_location_ids2",
          "present_at_location_ids3"
        ],
        "absent_at_location_ids": [
          "absent_at_location_ids2"
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
                }
              ],
              "min_selected_modifiers": 189,
              "max_selected_modifiers": 169,
              "enabled": true
            },
            {
              "modifier_list_id": "modifier_list_id4",
              "modifier_overrides": [
                {
                  "modifier_id": "modifier_id7",
                  "on_by_default": true
                },
                {
                  "modifier_id": "modifier_id8",
                  "on_by_default": false
                },
                {
                  "modifier_id": "modifier_id9",
                  "on_by_default": true
                }
              ],
              "min_selected_modifiers": 190,
              "max_selected_modifiers": 170,
              "enabled": false
            },
            {
              "modifier_list_id": "modifier_list_id5",
              "modifier_overrides": [
                {
                  "modifier_id": "modifier_id8",
                  "on_by_default": false
                }
              ],
              "min_selected_modifiers": 191,
              "max_selected_modifiers": 171,
              "enabled": true
            }
          ],
          "variations": [
            {
              "type": "ITEM_VARIATION",
              "id": "id6",
              "updated_at": "updated_at8",
              "version": 94,
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
                  "tax_ids4",
                  "tax_ids3"
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
                    "item_option_id": "item_option_id9"
                  },
                  {
                    "item_option_id": "item_option_id8"
                  }
                ],
                "image_ids": [
                  "image_ids3",
                  "image_ids2",
                  "image_ids1"
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
                "sku": "sku2",
                "upc": "upc0",
                "ordinal": 144,
                "pricing_type": "FIXED_PRICING",
                "price_money": {},
                "location_overrides": [
                  {
                    "location_id": "location_id7",
                    "price_money": {},
                    "pricing_type": "VARIABLE_PRICING",
                    "track_inventory": true,
                    "inventory_alert_type": "LOW_QUANTITY",
                    "inventory_alert_threshold": 83,
                    "sold_out": true,
                    "sold_out_valid_until": "sold_out_valid_until1"
                  }
                ],
                "track_inventory": false,
                "inventory_alert_type": "NONE",
                "inventory_alert_threshold": 110,
                "user_data": "user_data4",
                "service_duration": 234,
                "available_for_booking": false,
                "item_option_values": [
                  {
                    "item_option_id": "item_option_id9",
                    "item_option_value_id": "item_option_value_id3"
                  },
                  {
                    "item_option_id": "item_option_id0",
                    "item_option_value_id": "item_option_value_id2"
                  }
                ],
                "measurement_unit_id": "measurement_unit_id8",
                "sellable": false,
                "stockable": false,
                "image_ids": [
                  "image_ids7",
                  "image_ids6"
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
                "ordinal": 176,
                "selection_type": "SINGLE",
                "modifiers": [
                  {},
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
                "ordinal": 154,
                "modifier_list_id": "modifier_list_id2",
                "image_id": "image_id0"
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
                  "product_ids_all3",
                  "product_ids_all2",
                  "product_ids_all1"
                ],
                "quantity_exact": 242,
                "quantity_min": 120,
                "quantity_max": 94,
                "all_products": false
              },
              "pricing_rule_data": {
                "name": "name4",
                "time_period_ids": [
                  "time_period_ids6"
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
                  "customer_group_ids_any3"
                ]
              },
              "image_data": {
                "name": "name6",
                "url": "url0",
                "caption": "caption0",
                "photo_studio_order_id": "photo_studio_order_id8"
              },
              "measurement_unit_data": {
                "measurement_unit": {},
                "precision": 38
              },
              "subscription_plan_data": {
                "name": "name4",
                "phases": [
                  {
                    "uid": "uid1",
                    "cadence": "EVERY_SIX_MONTHS",
                    "periods": 93,
                    "recurring_price_money": {},
                    "ordinal": 59
                  },
                  {
                    "uid": "uid0",
                    "cadence": "ANNUAL",
                    "periods": 92,
                    "recurring_price_money": {},
                    "ordinal": 58
                  },
                  {
                    "uid": "uid9",
                    "cadence": "EVERY_TWO_YEARS",
                    "periods": 91,
                    "recurring_price_money": {},
                    "ordinal": 57
                  }
                ]
              },
              "item_option_data": {
                "name": "name0",
                "display_name": "display_name0",
                "description": "description0",
                "show_colors": false,
                "values": [
                  {}
                ]
              },
              "item_option_value_data": {
                "item_option_id": "item_option_id8",
                "name": "name6",
                "description": "description6",
                "color": "color0",
                "ordinal": 70
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
                  "ITEM_OPTION",
                  "MEASUREMENT_UNIT"
                ],
                "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
                "app_visibility": "APP_VISIBILITY_HIDDEN",
                "string_config": {
                  "enforce_uniqueness": false
                },
                "number_config": {
                  "precision": 80
                },
                "selection_config": {
                  "max_allowed_selections": 60,
                  "allowed_selections": [
                    {
                      "uid": "uid3",
                      "name": "name3"
                    }
                  ]
                },
                "custom_attribute_usage_count": 152,
                "key": "key4"
              },
              "quick_amounts_settings_data": {
                "option": "DISABLED",
                "eligible_for_auto_amounts": false,
                "amounts": [
                  {
                    "type": "QUICK_AMOUNT_TYPE_MANUAL",
                    "amount": {},
                    "score": 242,
                    "ordinal": 174
                  },
                  {
                    "type": "QUICK_AMOUNT_TYPE_AUTO",
                    "amount": {},
                    "score": 243,
                    "ordinal": 175
                  },
                  {
                    "type": "QUICK_AMOUNT_TYPE_MANUAL",
                    "amount": {},
                    "score": 244,
                    "ordinal": 176
                  }
                ]
              }
            },
            {
              "type": "TAX",
              "id": "id5",
              "updated_at": "updated_at9",
              "version": 93,
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
                "present_at_location_ids5",
                "present_at_location_ids6",
                "present_at_location_ids7"
              ],
              "absent_at_location_ids": [
                "absent_at_location_ids6"
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
                  "tax_ids5"
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
                    "item_option_id": "item_option_id8"
                  },
                  {
                    "item_option_id": "item_option_id7"
                  },
                  {
                    "item_option_id": "item_option_id6"
                  }
                ],
                "image_ids": [
                  "image_ids2"
                ],
                "sort_name": "sort_name5",
                "description_html": "description_html3",
                "description_plaintext": "description_plaintext3"
              },
              "category_data": {
                "name": "name9",
                "image_ids": [
                  "image_ids4",
                  "image_ids5",
                  "image_ids6"
                ]
              },
              "item_variation_data": {
                "item_id": "item_id9",
                "name": "name1",
                "sku": "sku3",
                "upc": "upc1",
                "ordinal": 143,
                "pricing_type": "VARIABLE_PRICING",
                "price_money": {},
                "location_overrides": [
                  {
                    "location_id": "location_id6",
                    "price_money": {},
                    "pricing_type": "FIXED_PRICING",
                    "track_inventory": false,
                    "inventory_alert_type": "NONE",
                    "inventory_alert_threshold": 82,
                    "sold_out": false,
                    "sold_out_valid_until": "sold_out_valid_until0"
                  },
                  {
                    "location_id": "location_id7",
                    "price_money": {},
                    "pricing_type": "VARIABLE_PRICING",
                    "track_inventory": true,
                    "inventory_alert_type": "LOW_QUANTITY",
                    "inventory_alert_threshold": 83,
                    "sold_out": true,
                    "sold_out_valid_until": "sold_out_valid_until1"
                  },
                  {
                    "location_id": "location_id8",
                    "price_money": {},
                    "pricing_type": "FIXED_PRICING",
                    "track_inventory": false,
                    "inventory_alert_type": "NONE",
                    "inventory_alert_threshold": 84,
                    "sold_out": false,
                    "sold_out_valid_until": "sold_out_valid_until2"
                  }
                ],
                "track_inventory": true,
                "inventory_alert_type": "LOW_QUANTITY",
                "inventory_alert_threshold": 111,
                "user_data": "user_data5",
                "service_duration": 233,
                "available_for_booking": true,
                "item_option_values": [
                  {
                    "item_option_id": "item_option_id0",
                    "item_option_value_id": "item_option_value_id2"
                  },
                  {
                    "item_option_id": "item_option_id1",
                    "item_option_value_id": "item_option_value_id1"
                  },
                  {
                    "item_option_id": "item_option_id2",
                    "item_option_value_id": "item_option_value_id0"
                  }
                ],
                "measurement_unit_id": "measurement_unit_id9",
                "sellable": true,
                "stockable": true,
                "image_ids": [
                  "image_ids6",
                  "image_ids5",
                  "image_ids4"
                ],
                "team_member_ids": [
                  "team_member_ids8",
                  "team_member_ids9"
                ],
                "stockable_conversion": {
                  "stockable_item_variation_id": "stockable_item_variation_id9",
                  "stockable_quantity": "stockable_quantity1",
                  "nonstockable_quantity": "nonstockable_quantity3"
                },
                "item_variation_vendor_info_ids": [
                  "item_variation_vendor_info_ids0"
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
                "ordinal": 177,
                "selection_type": "MULTIPLE",
                "modifiers": [
                  {}
                ],
                "image_ids": [
                  "image_ids6"
                ]
              },
              "modifier_data": {
                "name": "name7",
                "price_money": {},
                "ordinal": 155,
                "modifier_list_id": "modifier_list_id3",
                "image_id": "image_id1"
              },
              "time_period_data": {
                "event": "event1"
              },
              "product_set_data": {
                "name": "name3",
                "product_ids_any": [
                  "product_ids_any1",
                  "product_ids_any0"
                ],
                "product_ids_all": [
                  "product_ids_all4",
                  "product_ids_all3"
                ],
                "quantity_exact": 241,
                "quantity_min": 119,
                "quantity_max": 93,
                "all_products": true
              },
              "pricing_rule_data": {
                "name": "name5",
                "time_period_ids": [
                  "time_period_ids7",
                  "time_period_ids8"
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
                  "customer_group_ids_any4",
                  "customer_group_ids_any5"
                ]
              },
              "image_data": {
                "name": "name5",
                "url": "url9",
                "caption": "caption9",
                "photo_studio_order_id": "photo_studio_order_id7"
              },
              "measurement_unit_data": {
                "measurement_unit": {},
                "precision": 39
              },
              "subscription_plan_data": {
                "name": "name5",
                "phases": [
                  {
                    "uid": "uid0",
                    "cadence": "ANNUAL",
                    "periods": 92,
                    "recurring_price_money": {},
                    "ordinal": 58
                  }
                ]
              },
              "item_option_data": {
                "name": "name1",
                "display_name": "display_name1",
                "description": "description9",
                "show_colors": true,
                "values": [
                  {},
                  {},
                  {}
                ]
              },
              "item_option_value_data": {
                "item_option_id": "item_option_id7",
                "name": "name5",
                "description": "description5",
                "color": "color9",
                "ordinal": 69
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
                  "ITEM_OPTION_VAL"
                ],
                "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
                "app_visibility": "APP_VISIBILITY_READ_WRITE_VALUES",
                "string_config": {
                  "enforce_uniqueness": true
                },
                "number_config": {
                  "precision": 81
                },
                "selection_config": {
                  "max_allowed_selections": 59,
                  "allowed_selections": [
                    {
                      "uid": "uid2",
                      "name": "name2"
                    },
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
                "custom_attribute_usage_count": 151,
                "key": "key3"
              },
              "quick_amounts_settings_data": {
                "option": "AUTO",
                "eligible_for_auto_amounts": true,
                "amounts": [
                  {
                    "type": "QUICK_AMOUNT_TYPE_AUTO",
                    "amount": {},
                    "score": 241,
                    "ordinal": 173
                  },
                  {
                    "type": "QUICK_AMOUNT_TYPE_MANUAL",
                    "amount": {},
                    "score": 242,
                    "ordinal": 174
                  }
                ]
              }
            }
          ],
          "product_type": "GIFT_CARD",
          "skip_modifier_screen": true,
          "item_options": [
            {},
            {}
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
          "name": "name5",
          "image_ids": [
            "image_ids0",
            "image_ids1",
            "image_ids2"
          ]
        },
        "item_variation_data": {
          "item_id": "item_id7",
          "name": "name7",
          "sku": "sku3",
          "upc": "upc5",
          "ordinal": 223,
          "pricing_type": "VARIABLE_PRICING",
          "price_money": {},
          "location_overrides": [
            {},
            {},
            {}
          ],
          "track_inventory": true,
          "inventory_alert_type": "LOW_QUANTITY",
          "inventory_alert_threshold": 225,
          "user_data": "user_data1",
          "service_duration": 57,
          "available_for_booking": true,
          "item_option_values": [
            {},
            {}
          ],
          "measurement_unit_id": "measurement_unit_id7",
          "sellable": true,
          "stockable": true,
          "image_ids": [
            "image_ids2",
            "image_ids3"
          ],
          "team_member_ids": [
            "team_member_ids4",
            "team_member_ids5"
          ],
          "stockable_conversion": {
            "stockable_item_variation_id": "stockable_item_variation_id5",
            "stockable_quantity": "stockable_quantity7",
            "nonstockable_quantity": "nonstockable_quantity9"
          },
          "item_variation_vendor_info_ids": [
            "item_variation_vendor_info_ids6"
          ]
        },
        "tax_data": {
          "name": "name5",
          "calculation_phase": "TAX_TOTAL_PHASE",
          "inclusion_type": "INCLUSIVE",
          "percentage": "percentage3",
          "applies_to_custom_amounts": true,
          "enabled": true
        },
        "discount_data": {
          "name": "name9",
          "discount_type": "VARIABLE_AMOUNT",
          "percentage": "percentage7",
          "amount_money": {},
          "pin_required": true,
          "label_color": "label_color1",
          "modify_tax_basis": "DO_NOT_MODIFY_TAX_BASIS",
          "maximum_amount_money": {}
        },
        "modifier_list_data": {
          "name": "name5",
          "ordinal": 63,
          "selection_type": "MULTIPLE",
          "modifiers": [
            {},
            {},
            {}
          ],
          "image_ids": [
            "image_ids0",
            "image_ids1",
            "image_ids2"
          ]
        },
        "modifier_data": {
          "name": "name9",
          "price_money": {},
          "ordinal": 85,
          "modifier_list_id": "modifier_list_id5",
          "image_id": "image_id3"
        },
        "time_period_data": {
          "event": "event5"
        },
        "product_set_data": {
          "name": "name9",
          "product_ids_any": [
            "product_ids_any5",
            "product_ids_any6"
          ],
          "product_ids_all": [
            "product_ids_all2",
            "product_ids_all3"
          ],
          "quantity_exact": 65,
          "quantity_min": 199,
          "quantity_max": 173,
          "all_products": true
        },
        "pricing_rule_data": {
          "name": "name1",
          "time_period_ids": [
            "time_period_ids3"
          ],
          "discount_id": "discount_id9",
          "match_products_id": "match_products_id9",
          "apply_products_id": "apply_products_id5",
          "exclude_products_id": "exclude_products_id7",
          "valid_from_date": "valid_from_date9",
          "valid_from_local_time": "valid_from_local_time1",
          "valid_until_date": "valid_until_date7",
          "valid_until_local_time": "valid_until_local_time7",
          "exclude_strategy": "MOST_EXPENSIVE",
          "minimum_order_subtotal_money": {},
          "customer_group_ids_any": [
            "customer_group_ids_any0"
          ]
        },
        "image_data": {
          "name": "name1",
          "url": "url5",
          "caption": "caption5",
          "photo_studio_order_id": "photo_studio_order_id3"
        },
        "measurement_unit_data": {
          "measurement_unit": {},
          "precision": 177
        },
        "subscription_plan_data": {
          "name": "name1",
          "phases": [
            {},
            {},
            {}
          ]
        },
        "item_option_data": {
          "name": "name5",
          "display_name": "display_name5",
          "description": "description5",
          "show_colors": true,
          "values": [
            {},
            {}
          ]
        },
        "item_option_value_data": {
          "item_option_id": "item_option_id3",
          "name": "name1",
          "description": "description1",
          "color": "color5",
          "ordinal": 149
        },
        "custom_attribute_definition_data": {
          "type": "BOOLEAN",
          "name": "name9",
          "description": "description9",
          "source_application": {
            "product": "EXTERNAL_API",
            "application_id": "application_id7",
            "name": "name1"
          },
          "allowed_object_types": [
            "ITEM_OPTION_VAL"
          ],
          "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
          "app_visibility": "APP_VISIBILITY_READ_WRITE_VALUES",
          "string_config": {
            "enforce_uniqueness": true
          },
          "number_config": {
            "precision": 135
          },
          "selection_config": {
            "max_allowed_selections": 139,
            "allowed_selections": [
              {},
              {},
              {}
            ]
          },
          "custom_attribute_usage_count": 231,
          "key": "key9"
        },
        "quick_amounts_settings_data": {
          "option": "AUTO",
          "eligible_for_auto_amounts": true,
          "amounts": [
            {},
            {}
          ]
        }
      },
      {
        "type": "MODIFIER_LIST",
        "id": "id2",
        "updated_at": "updated_at8",
        "version": 174,
        "is_deleted": false,
        "custom_attribute_values": {
          "key0": {
            "name": "name5",
            "string_value": "string_value9",
            "custom_attribute_definition_id": "custom_attribute_definition_id7",
            "type": "SELECTION",
            "number_value": "number_value5",
            "boolean_value": true,
            "selection_uid_values": [
              "selection_uid_values2"
            ],
            "key": "key5"
          }
        },
        "catalog_v1_ids": [
          {
            "catalog_v1_id": "catalog_v1_id6",
            "location_id": "location_id6"
          },
          {
            "catalog_v1_id": "catalog_v1_id7",
            "location_id": "location_id7"
          }
        ],
        "present_at_all_locations": false,
        "present_at_location_ids": [
          "present_at_location_ids2"
        ],
        "absent_at_location_ids": [
          "absent_at_location_ids3",
          "absent_at_location_ids4"
        ],
        "item_data": {
          "name": "name4",
          "description": "description4",
          "abbreviation": "abbreviation6",
          "label_color": "label_color6",
          "available_online": false,
          "available_for_pickup": false,
          "available_electronically": false,
          "category_id": "category_id4",
          "tax_ids": [
            "tax_ids7",
            "tax_ids6"
          ],
          "modifier_list_info": [
            {
              "modifier_list_id": "modifier_list_id4",
              "modifier_overrides": [
                {
                  "modifier_id": "modifier_id7",
                  "on_by_default": true
                },
                {
                  "modifier_id": "modifier_id8",
                  "on_by_default": false
                },
                {
                  "modifier_id": "modifier_id9",
                  "on_by_default": true
                }
              ],
              "min_selected_modifiers": 190,
              "max_selected_modifiers": 170,
              "enabled": false
            }
          ],
          "variations": [
            {
              "type": "CATEGORY",
              "id": "id7",
              "updated_at": "updated_at7",
              "version": 95,
              "is_deleted": true,
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
                  "tax_ids4"
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
                "skip_modifier_screen": true,
                "item_options": [
                  {
                    "item_option_id": "item_option_id0"
                  }
                ],
                "image_ids": [
                  "image_ids4",
                  "image_ids3"
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
                "sku": "sku1",
                "upc": "upc9",
                "ordinal": 145,
                "pricing_type": "VARIABLE_PRICING",
                "price_money": {},
                "location_overrides": [
                  {
                    "location_id": "location_id8",
                    "price_money": {},
                    "pricing_type": "FIXED_PRICING",
                    "track_inventory": false,
                    "inventory_alert_type": "NONE",
                    "inventory_alert_threshold": 84,
                    "sold_out": false,
                    "sold_out_valid_until": "sold_out_valid_until2"
                  },
                  {
                    "location_id": "location_id9",
                    "price_money": {},
                    "pricing_type": "VARIABLE_PRICING",
                    "track_inventory": true,
                    "inventory_alert_type": "LOW_QUANTITY",
                    "inventory_alert_threshold": 85,
                    "sold_out": true,
                    "sold_out_valid_until": "sold_out_valid_until3"
                  }
                ],
                "track_inventory": true,
                "inventory_alert_type": "LOW_QUANTITY",
                "inventory_alert_threshold": 109,
                "user_data": "user_data3",
                "service_duration": 235,
                "available_for_booking": true,
                "item_option_values": [
                  {
                    "item_option_id": "item_option_id8",
                    "item_option_value_id": "item_option_value_id4"
                  }
                ],
                "measurement_unit_id": "measurement_unit_id7",
                "sellable": true,
                "stockable": true,
                "image_ids": [
                  "image_ids8"
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
                "ordinal": 175,
                "selection_type": "MULTIPLE",
                "modifiers": [
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
                "name": "name5",
                "price_money": {},
                "ordinal": 153,
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
                  "product_ids_all2"
                ],
                "quantity_exact": 243,
                "quantity_min": 121,
                "quantity_max": 95,
                "all_products": true
              },
              "pricing_rule_data": {
                "name": "name3",
                "time_period_ids": [
                  "time_period_ids5",
                  "time_period_ids6",
                  "time_period_ids7"
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
                  "customer_group_ids_any3",
                  "customer_group_ids_any4"
                ]
              },
              "image_data": {
                "name": "name7",
                "url": "url1",
                "caption": "caption1",
                "photo_studio_order_id": "photo_studio_order_id9"
              },
              "measurement_unit_data": {
                "measurement_unit": {},
                "precision": 37
              },
              "subscription_plan_data": {
                "name": "name3",
                "phases": [
                  {
                    "uid": "uid2",
                    "cadence": "EVERY_FOUR_MONTHS",
                    "periods": 94,
                    "recurring_price_money": {},
                    "ordinal": 60
                  },
                  {
                    "uid": "uid1",
                    "cadence": "EVERY_SIX_MONTHS",
                    "periods": 93,
                    "recurring_price_money": {},
                    "ordinal": 59
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
                  {}
                ]
              },
              "item_option_value_data": {
                "item_option_id": "item_option_id9",
                "name": "name7",
                "description": "description7",
                "color": "color1",
                "ordinal": 71
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
                  "MEASUREMENT_UNIT",
                  "TIME_PERIOD",
                  "PRODUCT_SET"
                ],
                "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
                "app_visibility": "APP_VISIBILITY_READ_ONLY",
                "string_config": {
                  "enforce_uniqueness": true
                },
                "number_config": {
                  "precision": 79
                },
                "selection_config": {
                  "max_allowed_selections": 61,
                  "allowed_selections": [
                    {
                      "uid": "uid4",
                      "name": "name4"
                    },
                    {
                      "uid": "uid5",
                      "name": "name5"
                    }
                  ]
                },
                "custom_attribute_usage_count": 153,
                "key": "key5"
              },
              "quick_amounts_settings_data": {
                "option": "MANUAL",
                "eligible_for_auto_amounts": true,
                "amounts": [
                  {
                    "type": "QUICK_AMOUNT_TYPE_AUTO",
                    "amount": {},
                    "score": 243,
                    "ordinal": 175
                  }
                ]
              }
            }
          ],
          "product_type": "APPOINTMENTS_SERVICE",
          "skip_modifier_screen": false,
          "item_options": [
            {},
            {},
            {}
          ],
          "image_ids": [
            "image_ids1"
          ],
          "sort_name": "sort_name4",
          "description_html": "description_html4",
          "description_plaintext": "description_plaintext4"
        },
        "category_data": {
          "name": "name6",
          "image_ids": [
            "image_ids1"
          ]
        },
        "item_variation_data": {
          "item_id": "item_id8",
          "name": "name8",
          "sku": "sku4",
          "upc": "upc6",
          "ordinal": 224,
          "pricing_type": "FIXED_PRICING",
          "price_money": {},
          "location_overrides": [
            {}
          ],
          "track_inventory": false,
          "inventory_alert_type": "NONE",
          "inventory_alert_threshold": 226,
          "user_data": "user_data2",
          "service_duration": 58,
          "available_for_booking": false,
          "item_option_values": [
            {},
            {},
            {}
          ],
          "measurement_unit_id": "measurement_unit_id8",
          "sellable": false,
          "stockable": false,
          "image_ids": [
            "image_ids3",
            "image_ids4",
            "image_ids5"
          ],
          "team_member_ids": [
            "team_member_ids5",
            "team_member_ids6",
            "team_member_ids7"
          ],
          "stockable_conversion": {
            "stockable_item_variation_id": "stockable_item_variation_id6",
            "stockable_quantity": "stockable_quantity8",
            "nonstockable_quantity": "nonstockable_quantity0"
          },
          "item_variation_vendor_info_ids": [
            "item_variation_vendor_info_ids7",
            "item_variation_vendor_info_ids8"
          ]
        },
        "tax_data": {
          "name": "name6",
          "calculation_phase": "TAX_SUBTOTAL_PHASE",
          "inclusion_type": "ADDITIVE",
          "percentage": "percentage4",
          "applies_to_custom_amounts": false,
          "enabled": false
        },
        "discount_data": {
          "name": "name0",
          "discount_type": "FIXED_PERCENTAGE",
          "percentage": "percentage8",
          "amount_money": {},
          "pin_required": false,
          "label_color": "label_color2",
          "modify_tax_basis": "MODIFY_TAX_BASIS",
          "maximum_amount_money": {}
        },
        "modifier_list_data": {
          "name": "name6",
          "ordinal": 64,
          "selection_type": "SINGLE",
          "modifiers": [
            {}
          ],
          "image_ids": [
            "image_ids1"
          ]
        },
        "modifier_data": {
          "name": "name0",
          "price_money": {},
          "ordinal": 86,
          "modifier_list_id": "modifier_list_id6",
          "image_id": "image_id4"
        },
        "time_period_data": {
          "event": "event6"
        },
        "product_set_data": {
          "name": "name0",
          "product_ids_any": [
            "product_ids_any6",
            "product_ids_any7",
            "product_ids_any8"
          ],
          "product_ids_all": [
            "product_ids_all3",
            "product_ids_all4",
            "product_ids_all5"
          ],
          "quantity_exact": 66,
          "quantity_min": 200,
          "quantity_max": 174,
          "all_products": false
        },
        "pricing_rule_data": {
          "name": "name2",
          "time_period_ids": [
            "time_period_ids4",
            "time_period_ids5"
          ],
          "discount_id": "discount_id0",
          "match_products_id": "match_products_id0",
          "apply_products_id": "apply_products_id6",
          "exclude_products_id": "exclude_products_id8",
          "valid_from_date": "valid_from_date0",
          "valid_from_local_time": "valid_from_local_time2",
          "valid_until_date": "valid_until_date8",
          "valid_until_local_time": "valid_until_local_time8",
          "exclude_strategy": "LEAST_EXPENSIVE",
          "minimum_order_subtotal_money": {},
          "customer_group_ids_any": [
            "customer_group_ids_any1",
            "customer_group_ids_any2"
          ]
        },
        "image_data": {
          "name": "name2",
          "url": "url6",
          "caption": "caption6",
          "photo_studio_order_id": "photo_studio_order_id4"
        },
        "measurement_unit_data": {
          "measurement_unit": {},
          "precision": 178
        },
        "subscription_plan_data": {
          "name": "name2",
          "phases": [
            {},
            {}
          ]
        },
        "item_option_data": {
          "name": "name6",
          "display_name": "display_name6",
          "description": "description6",
          "show_colors": false,
          "values": [
            {},
            {},
            {}
          ]
        },
        "item_option_value_data": {
          "item_option_id": "item_option_id4",
          "name": "name2",
          "description": "description2",
          "color": "color6",
          "ordinal": 150
        },
        "custom_attribute_definition_data": {
          "type": "NUMBER",
          "name": "name0",
          "description": "description0",
          "source_application": {
            "product": "BILLING",
            "application_id": "application_id8",
            "name": "name2"
          },
          "allowed_object_types": [
            "CUSTOM_ATTRIBUTE_DEFINITION",
            "QUICK_AMOUNTS_SETTINGS"
          ],
          "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
          "app_visibility": "APP_VISIBILITY_HIDDEN",
          "string_config": {
            "enforce_uniqueness": false
          },
          "number_config": {
            "precision": 136
          },
          "selection_config": {
            "max_allowed_selections": 140,
            "allowed_selections": [
              {}
            ]
          },
          "custom_attribute_usage_count": 232,
          "key": "key0"
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
      }
    ]
  }
}
```

