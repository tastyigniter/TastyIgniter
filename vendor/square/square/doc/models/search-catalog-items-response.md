
# Search Catalog Items Response

Defines the response body returned from the [SearchCatalogItems](../../doc/apis/catalog.md#search-catalog-items) endpoint.

## Structure

`SearchCatalogItemsResponse`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `errors` | [`?(Error[])`](../../doc/models/error.md) | Optional | Any errors that occurred during the request. | getErrors(): ?array | setErrors(?array errors): void |
| `items` | [`?(CatalogObject[])`](../../doc/models/catalog-object.md) | Optional | Returned items matching the specified query expressions. | getItems(): ?array | setItems(?array items): void |
| `cursor` | `?string` | Optional | Pagination token used in the next request to return more of the search result. | getCursor(): ?string | setCursor(?string cursor): void |
| `matchedVariationIds` | `?(string[])` | Optional | Ids of returned item variations matching the specified query expression. | getMatchedVariationIds(): ?array | setMatchedVariationIds(?array matchedVariationIds): void |

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
  "items": [
    {
      "type": "PRODUCT_SET",
      "id": "id7",
      "updated_at": "updated_at7",
      "version": 143,
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
            "selection_uid_values5"
          ],
          "key": "key8"
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
        }
      ],
      "present_at_all_locations": true,
      "present_at_location_ids": [
        "present_at_location_ids7"
      ],
      "absent_at_location_ids": [
        "absent_at_location_ids8",
        "absent_at_location_ids9"
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
          "tax_ids6",
          "tax_ids7",
          "tax_ids8"
        ],
        "modifier_list_info": [
          {
            "modifier_list_id": "modifier_list_id1",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id4",
                "on_by_default": false
              },
              {
                "modifier_id": "modifier_id5",
                "on_by_default": true
              }
            ],
            "min_selected_modifiers": 17,
            "max_selected_modifiers": 253,
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
              },
              {
                "modifier_id": "modifier_id7",
                "on_by_default": true
              }
            ],
            "min_selected_modifiers": 18,
            "max_selected_modifiers": 254,
            "enabled": false
          },
          {
            "modifier_list_id": "modifier_list_id3",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id6",
                "on_by_default": false
              }
            ],
            "min_selected_modifiers": 19,
            "max_selected_modifiers": 255,
            "enabled": true
          }
        ],
        "variations": [
          {
            "type": "CATEGORY",
            "id": "id6",
            "updated_at": "updated_at8",
            "version": 10,
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
                "image_ids7",
                "image_ids8",
                "image_ids9"
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
              "ordinal": 40,
              "pricing_type": "FIXED_PRICING",
              "price_money": {
                "amount": 242,
                "currency": "ANG"
              },
              "location_overrides": [
                {
                  "location_id": "location_id7",
                  "price_money": {
                    "amount": 115,
                    "currency": "ILS"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 235,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until1"
                }
              ],
              "track_inventory": false,
              "inventory_alert_type": "NONE",
              "inventory_alert_threshold": 214,
              "user_data": "user_data4",
              "service_duration": 130,
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
                "image_ids3",
                "image_ids4"
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
              "ordinal": 24,
              "selection_type": "SINGLE",
              "modifiers": [
                {},
                {},
                {}
              ],
              "image_ids": [
                "image_ids5",
                "image_ids4",
                "image_ids3"
              ]
            },
            "modifier_data": {
              "name": "name6",
              "price_money": {},
              "ordinal": 2,
              "modifier_list_id": "modifier_list_id2",
              "image_id": "image_id0"
            },
            "time_period_data": {
              "event": "event0"
            },
            "product_set_data": {
              "name": "name4",
              "product_ids_any": [
                "product_ids_any6",
                "product_ids_any5"
              ],
              "product_ids_all": [
                "product_ids_all5",
                "product_ids_all4"
              ],
              "quantity_exact": 138,
              "quantity_min": 16,
              "quantity_max": 10,
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
              "measurement_unit": {
                "custom_unit": {
                  "name": "name8",
                  "abbreviation": "abbreviation0"
                },
                "area_unit": "IMPERIAL_SQUARE_FOOT",
                "length_unit": "METRIC_METER",
                "volume_unit": "GENERIC_QUART",
                "weight_unit": "IMPERIAL_STONE",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_DAY",
                "type": "TYPE_WEIGHT"
              },
              "precision": 142
            },
            "subscription_plan_data": {
              "name": "name4",
              "phases": [
                {
                  "uid": "uid1",
                  "cadence": "THIRTY_DAYS",
                  "periods": 245,
                  "recurring_price_money": {},
                  "ordinal": 211
                },
                {
                  "uid": "uid0",
                  "cadence": "SIXTY_DAYS",
                  "periods": 244,
                  "recurring_price_money": {},
                  "ordinal": 210
                },
                {
                  "uid": "uid9",
                  "cadence": "NINETY_DAYS",
                  "periods": 243,
                  "recurring_price_money": {},
                  "ordinal": 209
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
              "ordinal": 222
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
                "DISCOUNT",
                "TAX",
                "ITEM_VARIATION"
              ],
              "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
              "app_visibility": "APP_VISIBILITY_HIDDEN",
              "string_config": {
                "enforce_uniqueness": false
              },
              "number_config": {
                "precision": 184
              },
              "selection_config": {
                "max_allowed_selections": 212,
                "allowed_selections": [
                  {
                    "uid": "uid3",
                    "name": "name3"
                  }
                ]
              },
              "custom_attribute_usage_count": 48,
              "key": "key4"
            },
            "quick_amounts_settings_data": {
              "option": "DISABLED",
              "eligible_for_auto_amounts": false,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 138,
                  "ordinal": 70
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 139,
                  "ordinal": 71
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 140,
                  "ordinal": 72
                }
              ]
            }
          },
          {
            "type": "IMAGE",
            "id": "id7",
            "updated_at": "updated_at7",
            "version": 9,
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
                "image_ids6",
                "image_ids7"
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
              "ordinal": 41,
              "pricing_type": "VARIABLE_PRICING",
              "price_money": {
                "amount": 241,
                "currency": "AMD"
              },
              "location_overrides": [
                {
                  "location_id": "location_id8",
                  "price_money": {
                    "amount": 116,
                    "currency": "INR"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 236,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until2"
                },
                {
                  "location_id": "location_id9",
                  "price_money": {
                    "amount": 117,
                    "currency": "IQD"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 237,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until3"
                }
              ],
              "track_inventory": true,
              "inventory_alert_type": "LOW_QUANTITY",
              "inventory_alert_threshold": 213,
              "user_data": "user_data3",
              "service_duration": 131,
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
                "image_ids2"
              ],
              "team_member_ids": [
                "team_member_ids0"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id9",
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
              "ordinal": 23,
              "selection_type": "MULTIPLE",
              "modifiers": [
                {},
                {}
              ],
              "image_ids": [
                "image_ids6",
                "image_ids5"
              ]
            },
            "modifier_data": {
              "name": "name5",
              "price_money": {},
              "ordinal": 1,
              "modifier_list_id": "modifier_list_id1",
              "image_id": "image_id9"
            },
            "time_period_data": {
              "event": "event9"
            },
            "product_set_data": {
              "name": "name5",
              "product_ids_any": [
                "product_ids_any7"
              ],
              "product_ids_all": [
                "product_ids_all6"
              ],
              "quantity_exact": 139,
              "quantity_min": 17,
              "quantity_max": 9,
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
              "measurement_unit": {
                "custom_unit": {
                  "name": "name7",
                  "abbreviation": "abbreviation9"
                },
                "area_unit": "IMPERIAL_SQUARE_INCH",
                "length_unit": "METRIC_KILOMETER",
                "volume_unit": "GENERIC_PINT",
                "weight_unit": "METRIC_MILLIGRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_HOUR",
                "type": "TYPE_VOLUME"
              },
              "precision": 141
            },
            "subscription_plan_data": {
              "name": "name3",
              "phases": [
                {
                  "uid": "uid2",
                  "cadence": "EVERY_TWO_WEEKS",
                  "periods": 246,
                  "recurring_price_money": {},
                  "ordinal": 212
                },
                {
                  "uid": "uid1",
                  "cadence": "THIRTY_DAYS",
                  "periods": 245,
                  "recurring_price_money": {},
                  "ordinal": 211
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
              "ordinal": 223
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
                "MODIFIER_LIST",
                "DISCOUNT"
              ],
              "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
              "app_visibility": "APP_VISIBILITY_READ_ONLY",
              "string_config": {
                "enforce_uniqueness": true
              },
              "number_config": {
                "precision": 183
              },
              "selection_config": {
                "max_allowed_selections": 213,
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
              "custom_attribute_usage_count": 49,
              "key": "key5"
            },
            "quick_amounts_settings_data": {
              "option": "MANUAL",
              "eligible_for_auto_amounts": true,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 139,
                  "ordinal": 71
                }
              ]
            }
          }
        ],
        "product_type": "GIFT_CARD",
        "skip_modifier_screen": true,
        "item_options": [
          {},
          {},
          {}
        ],
        "image_ids": [
          "image_ids6",
          "image_ids5"
        ],
        "sort_name": "sort_name7",
        "description_html": "description_html1",
        "description_plaintext": "description_plaintext1"
      },
      "category_data": {
        "name": "name1",
        "image_ids": [
          "image_ids6"
        ]
      },
      "item_variation_data": {
        "item_id": "item_id7",
        "name": "name3",
        "sku": "sku1",
        "upc": "upc9",
        "ordinal": 193,
        "pricing_type": "VARIABLE_PRICING",
        "price_money": {},
        "location_overrides": [
          {}
        ],
        "track_inventory": true,
        "inventory_alert_type": "LOW_QUANTITY",
        "inventory_alert_threshold": 195,
        "user_data": "user_data3",
        "service_duration": 27,
        "available_for_booking": true,
        "item_option_values": [
          {},
          {}
        ],
        "measurement_unit_id": "measurement_unit_id7",
        "sellable": true,
        "stockable": true,
        "image_ids": [
          "image_ids8",
          "image_ids7"
        ],
        "team_member_ids": [
          "team_member_ids0",
          "team_member_ids1",
          "team_member_ids2"
        ],
        "stockable_conversion": {
          "stockable_item_variation_id": "stockable_item_variation_id1",
          "stockable_quantity": "stockable_quantity3",
          "nonstockable_quantity": "nonstockable_quantity5"
        },
        "item_variation_vendor_info_ids": [
          "item_variation_vendor_info_ids2",
          "item_variation_vendor_info_ids3"
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
        "ordinal": 127,
        "selection_type": "MULTIPLE",
        "modifiers": [
          {},
          {},
          {}
        ],
        "image_ids": [
          "image_ids6",
          "image_ids7"
        ]
      },
      "modifier_data": {
        "name": "name5",
        "price_money": {},
        "ordinal": 55,
        "modifier_list_id": "modifier_list_id1",
        "image_id": "image_id9"
      },
      "time_period_data": {
        "event": "event9"
      },
      "product_set_data": {
        "name": "name5",
        "product_ids_any": [
          "product_ids_any9",
          "product_ids_any8",
          "product_ids_any7"
        ],
        "product_ids_all": [
          "product_ids_all2",
          "product_ids_all1",
          "product_ids_all0"
        ],
        "quantity_exact": 35,
        "quantity_min": 169,
        "quantity_max": 143,
        "all_products": true
      },
      "pricing_rule_data": {
        "name": "name7",
        "time_period_ids": [
          "time_period_ids9",
          "time_period_ids0"
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
          "customer_group_ids_any7"
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
          "volume_unit": "GENERIC_CUP",
          "weight_unit": "METRIC_KILOGRAM",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_MINUTE",
          "type": "TYPE_GENERIC"
        },
        "precision": 245
      },
      "subscription_plan_data": {
        "name": "name3",
        "phases": [
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
          {},
          {}
        ]
      },
      "item_option_value_data": {
        "item_option_id": "item_option_id9",
        "name": "name7",
        "description": "description7",
        "color": "color1",
        "ordinal": 119
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
          "IMAGE",
          "ITEM"
        ],
        "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
        "app_visibility": "APP_VISIBILITY_HIDDEN",
        "string_config": {
          "enforce_uniqueness": true
        },
        "number_config": {
          "precision": 31
        },
        "selection_config": {
          "max_allowed_selections": 109,
          "allowed_selections": [
            {}
          ]
        },
        "custom_attribute_usage_count": 201,
        "key": "key5"
      },
      "quick_amounts_settings_data": {
        "option": "DISABLED",
        "eligible_for_auto_amounts": true,
        "amounts": [
          {},
          {},
          {}
        ]
      }
    },
    {
      "type": "PRICING_RULE",
      "id": "id8",
      "updated_at": "updated_at6",
      "version": 144,
      "is_deleted": false,
      "custom_attribute_values": {
        "key0": {
          "name": "name9",
          "string_value": "string_value3",
          "custom_attribute_definition_id": "custom_attribute_definition_id3",
          "type": "SELECTION",
          "number_value": "number_value9",
          "boolean_value": true,
          "selection_uid_values": [
            "selection_uid_values6",
            "selection_uid_values7"
          ],
          "key": "key9"
        },
        "key1": {
          "name": "name8",
          "string_value": "string_value2",
          "custom_attribute_definition_id": "custom_attribute_definition_id4",
          "type": "STRING",
          "number_value": "number_value8",
          "boolean_value": false,
          "selection_uid_values": [
            "selection_uid_values5"
          ],
          "key": "key8"
        },
        "key2": {
          "name": "name7",
          "string_value": "string_value1",
          "custom_attribute_definition_id": "custom_attribute_definition_id5",
          "type": "BOOLEAN",
          "number_value": "number_value7",
          "boolean_value": true,
          "selection_uid_values": [
            "selection_uid_values4",
            "selection_uid_values5",
            "selection_uid_values6"
          ],
          "key": "key7"
        }
      },
      "catalog_v1_ids": [
        {
          "catalog_v1_id": "catalog_v1_id2",
          "location_id": "location_id2"
        },
        {
          "catalog_v1_id": "catalog_v1_id3",
          "location_id": "location_id3"
        },
        {
          "catalog_v1_id": "catalog_v1_id4",
          "location_id": "location_id4"
        }
      ],
      "present_at_all_locations": false,
      "present_at_location_ids": [
        "present_at_location_ids8",
        "present_at_location_ids9"
      ],
      "absent_at_location_ids": [
        "absent_at_location_ids9",
        "absent_at_location_ids0",
        "absent_at_location_ids1"
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
          "tax_ids7"
        ],
        "modifier_list_info": [
          {
            "modifier_list_id": "modifier_list_id0",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id3",
                "on_by_default": true
              }
            ],
            "min_selected_modifiers": 16,
            "max_selected_modifiers": 252,
            "enabled": false
          },
          {
            "modifier_list_id": "modifier_list_id1",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id4",
                "on_by_default": false
              },
              {
                "modifier_id": "modifier_id5",
                "on_by_default": true
              }
            ],
            "min_selected_modifiers": 17,
            "max_selected_modifiers": 253,
            "enabled": true
          }
        ],
        "variations": [
          {
            "type": "IMAGE",
            "id": "id7",
            "updated_at": "updated_at7",
            "version": 9,
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
                "image_ids6",
                "image_ids7"
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
              "ordinal": 41,
              "pricing_type": "VARIABLE_PRICING",
              "price_money": {
                "amount": 241,
                "currency": "AMD"
              },
              "location_overrides": [
                {
                  "location_id": "location_id8",
                  "price_money": {
                    "amount": 116,
                    "currency": "INR"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 236,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until2"
                },
                {
                  "location_id": "location_id9",
                  "price_money": {
                    "amount": 117,
                    "currency": "IQD"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 237,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until3"
                }
              ],
              "track_inventory": true,
              "inventory_alert_type": "LOW_QUANTITY",
              "inventory_alert_threshold": 213,
              "user_data": "user_data3",
              "service_duration": 131,
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
                "image_ids2"
              ],
              "team_member_ids": [
                "team_member_ids0"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id9",
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
              "ordinal": 23,
              "selection_type": "MULTIPLE",
              "modifiers": [
                {},
                {}
              ],
              "image_ids": [
                "image_ids6",
                "image_ids5"
              ]
            },
            "modifier_data": {
              "name": "name5",
              "price_money": {},
              "ordinal": 1,
              "modifier_list_id": "modifier_list_id1",
              "image_id": "image_id9"
            },
            "time_period_data": {
              "event": "event9"
            },
            "product_set_data": {
              "name": "name5",
              "product_ids_any": [
                "product_ids_any7"
              ],
              "product_ids_all": [
                "product_ids_all6"
              ],
              "quantity_exact": 139,
              "quantity_min": 17,
              "quantity_max": 9,
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
              "measurement_unit": {
                "custom_unit": {
                  "name": "name7",
                  "abbreviation": "abbreviation9"
                },
                "area_unit": "IMPERIAL_SQUARE_INCH",
                "length_unit": "METRIC_KILOMETER",
                "volume_unit": "GENERIC_PINT",
                "weight_unit": "METRIC_MILLIGRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_HOUR",
                "type": "TYPE_VOLUME"
              },
              "precision": 141
            },
            "subscription_plan_data": {
              "name": "name3",
              "phases": [
                {
                  "uid": "uid2",
                  "cadence": "EVERY_TWO_WEEKS",
                  "periods": 246,
                  "recurring_price_money": {},
                  "ordinal": 212
                },
                {
                  "uid": "uid1",
                  "cadence": "THIRTY_DAYS",
                  "periods": 245,
                  "recurring_price_money": {},
                  "ordinal": 211
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
              "ordinal": 223
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
                "MODIFIER_LIST",
                "DISCOUNT"
              ],
              "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
              "app_visibility": "APP_VISIBILITY_READ_ONLY",
              "string_config": {
                "enforce_uniqueness": true
              },
              "number_config": {
                "precision": 183
              },
              "selection_config": {
                "max_allowed_selections": 213,
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
              "custom_attribute_usage_count": 49,
              "key": "key5"
            },
            "quick_amounts_settings_data": {
              "option": "MANUAL",
              "eligible_for_auto_amounts": true,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 139,
                  "ordinal": 71
                }
              ]
            }
          },
          {
            "type": "ITEM",
            "id": "id8",
            "updated_at": "updated_at6",
            "version": 8,
            "is_deleted": false,
            "custom_attribute_values": {
              "key0": {},
              "key1": {}
            },
            "catalog_v1_ids": [
              {}
            ],
            "present_at_all_locations": false,
            "present_at_location_ids": [
              "present_at_location_ids8",
              "present_at_location_ids9",
              "present_at_location_ids0"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids9"
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
                "tax_ids2"
              ],
              "modifier_list_info": [
                {}
              ],
              "variations": [
                {}
              ],
              "product_type": "APPOINTMENTS_SERVICE",
              "skip_modifier_screen": false,
              "item_options": [
                {
                  "item_option_id": "item_option_id1"
                },
                {
                  "item_option_id": "item_option_id0"
                },
                {
                  "item_option_id": "item_option_id9"
                }
              ],
              "image_ids": [
                "image_ids5"
              ],
              "sort_name": "sort_name8",
              "description_html": "description_html0",
              "description_plaintext": "description_plaintext0"
            },
            "category_data": {
              "name": "name2",
              "image_ids": [
                "image_ids7",
                "image_ids8",
                "image_ids9"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id6",
              "name": "name4",
              "sku": "sku0",
              "upc": "upc8",
              "ordinal": 42,
              "pricing_type": "FIXED_PRICING",
              "price_money": {
                "amount": 240,
                "currency": "ALL"
              },
              "location_overrides": [
                {
                  "location_id": "location_id9",
                  "price_money": {
                    "amount": 117,
                    "currency": "IQD"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 237,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until3"
                },
                {
                  "location_id": "location_id0",
                  "price_money": {
                    "amount": 118,
                    "currency": "IRR"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 238,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until4"
                },
                {
                  "location_id": "location_id1",
                  "price_money": {
                    "amount": 119,
                    "currency": "ISK"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 239,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until5"
                }
              ],
              "track_inventory": false,
              "inventory_alert_type": "NONE",
              "inventory_alert_threshold": 212,
              "user_data": "user_data2",
              "service_duration": 132,
              "available_for_booking": false,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id7",
                  "item_option_value_id": "item_option_value_id5"
                },
                {
                  "item_option_id": "item_option_id8",
                  "item_option_value_id": "item_option_value_id4"
                },
                {
                  "item_option_id": "item_option_id9",
                  "item_option_value_id": "item_option_value_id3"
                }
              ],
              "measurement_unit_id": "measurement_unit_id6",
              "sellable": false,
              "stockable": false,
              "image_ids": [
                "image_ids1",
                "image_ids2",
                "image_ids3"
              ],
              "team_member_ids": [
                "team_member_ids1",
                "team_member_ids2"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id8",
                "stockable_quantity": "stockable_quantity4",
                "nonstockable_quantity": "nonstockable_quantity6"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids3"
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
              "ordinal": 22,
              "selection_type": "SINGLE",
              "modifiers": [
                {}
              ],
              "image_ids": [
                "image_ids7"
              ]
            },
            "modifier_data": {
              "name": "name4",
              "price_money": {},
              "ordinal": 0,
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
                "product_ids_any7",
                "product_ids_any6"
              ],
              "product_ids_all": [
                "product_ids_all7",
                "product_ids_all6",
                "product_ids_all5"
              ],
              "quantity_exact": 140,
              "quantity_min": 18,
              "quantity_max": 8,
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
              "apply_products_id": "apply_products_id4",
              "exclude_products_id": "exclude_products_id8",
              "valid_from_date": "valid_from_date0",
              "valid_from_local_time": "valid_from_local_time8",
              "valid_until_date": "valid_until_date2",
              "valid_until_local_time": "valid_until_local_time2",
              "exclude_strategy": "LEAST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any1",
                "customer_group_ids_any2"
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
                "volume_unit": "GENERIC_CUP",
                "weight_unit": "METRIC_GRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_MINUTE",
                "type": "TYPE_LENGTH"
              },
              "precision": 140
            },
            "subscription_plan_data": {
              "name": "name2",
              "phases": [
                {
                  "uid": "uid3",
                  "cadence": "WEEKLY",
                  "periods": 247,
                  "recurring_price_money": {},
                  "ordinal": 213
                }
              ]
            },
            "item_option_data": {
              "name": "name8",
              "display_name": "display_name8",
              "description": "description2",
              "show_colors": false,
              "values": [
                {},
                {},
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id0",
              "name": "name8",
              "description": "description8",
              "color": "color2",
              "ordinal": 224
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
                "MODIFIER"
              ],
              "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
              "app_visibility": "APP_VISIBILITY_READ_WRITE_VALUES",
              "string_config": {
                "enforce_uniqueness": false
              },
              "number_config": {
                "precision": 182
              },
              "selection_config": {
                "max_allowed_selections": 214,
                "allowed_selections": [
                  {
                    "uid": "uid5",
                    "name": "name5"
                  },
                  {
                    "uid": "uid6",
                    "name": "name6"
                  },
                  {
                    "uid": "uid7",
                    "name": "name7"
                  }
                ]
              },
              "custom_attribute_usage_count": 50,
              "key": "key6"
            },
            "quick_amounts_settings_data": {
              "option": "AUTO",
              "eligible_for_auto_amounts": false,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 140,
                  "ordinal": 72
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 141,
                  "ordinal": 73
                }
              ]
            }
          },
          {
            "type": "SUBSCRIPTION_PLAN",
            "id": "id9",
            "updated_at": "updated_at5",
            "version": 7,
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
              "present_at_location_ids9"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids0",
              "absent_at_location_ids1"
            ],
            "item_data": {
              "name": "name9",
              "description": "description9",
              "abbreviation": "abbreviation1",
              "label_color": "label_color1",
              "available_online": true,
              "available_for_pickup": true,
              "available_electronically": true,
              "category_id": "category_id9",
              "tax_ids": [
                "tax_ids2",
                "tax_ids1",
                "tax_ids0"
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
                  "item_option_id": "item_option_id2"
                },
                {
                  "item_option_id": "item_option_id1"
                }
              ],
              "image_ids": [
                "image_ids4",
                "image_ids5",
                "image_ids6"
              ],
              "sort_name": "sort_name9",
              "description_html": "description_html9",
              "description_plaintext": "description_plaintext9"
            },
            "category_data": {
              "name": "name3",
              "image_ids": [
                "image_ids8"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id5",
              "name": "name5",
              "sku": "sku9",
              "upc": "upc7",
              "ordinal": 43,
              "pricing_type": "VARIABLE_PRICING",
              "price_money": {
                "amount": 239,
                "currency": "AFN"
              },
              "location_overrides": [
                {
                  "location_id": "location_id0",
                  "price_money": {
                    "amount": 118,
                    "currency": "IRR"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 238,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until4"
                }
              ],
              "track_inventory": true,
              "inventory_alert_type": "LOW_QUANTITY",
              "inventory_alert_threshold": 211,
              "user_data": "user_data1",
              "service_duration": 133,
              "available_for_booking": true,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id6",
                  "item_option_value_id": "item_option_value_id6"
                },
                {
                  "item_option_id": "item_option_id7",
                  "item_option_value_id": "item_option_value_id5"
                }
              ],
              "measurement_unit_id": "measurement_unit_id5",
              "sellable": true,
              "stockable": true,
              "image_ids": [
                "image_ids0",
                "image_ids1"
              ],
              "team_member_ids": [
                "team_member_ids2",
                "team_member_ids3",
                "team_member_ids4"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id7",
                "stockable_quantity": "stockable_quantity5",
                "nonstockable_quantity": "nonstockable_quantity7"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids4",
                "item_variation_vendor_info_ids5"
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
              "name": "name3",
              "discount_type": "FIXED_AMOUNT",
              "percentage": "percentage1",
              "amount_money": {},
              "pin_required": true,
              "label_color": "label_color5",
              "modify_tax_basis": "DO_NOT_MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name7",
              "ordinal": 21,
              "selection_type": "MULTIPLE",
              "modifiers": [
                {},
                {},
                {}
              ],
              "image_ids": [
                "image_ids8",
                "image_ids7",
                "image_ids6"
              ]
            },
            "modifier_data": {
              "name": "name3",
              "price_money": {},
              "ordinal": 255,
              "modifier_list_id": "modifier_list_id9",
              "image_id": "image_id7"
            },
            "time_period_data": {
              "event": "event7"
            },
            "product_set_data": {
              "name": "name7",
              "product_ids_any": [
                "product_ids_any9",
                "product_ids_any8"
              ],
              "product_ids_all": [
                "product_ids_all8",
                "product_ids_all7"
              ],
              "quantity_exact": 141,
              "quantity_min": 19,
              "quantity_max": 7,
              "all_products": true
            },
            "pricing_rule_data": {
              "name": "name1",
              "time_period_ids": [
                "time_period_ids3"
              ],
              "discount_id": "discount_id9",
              "match_products_id": "match_products_id1",
              "apply_products_id": "apply_products_id5",
              "exclude_products_id": "exclude_products_id7",
              "valid_from_date": "valid_from_date1",
              "valid_from_local_time": "valid_from_local_time9",
              "valid_until_date": "valid_until_date3",
              "valid_until_local_time": "valid_until_local_time3",
              "exclude_strategy": "MOST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any0"
              ]
            },
            "image_data": {
              "name": "name9",
              "url": "url3",
              "caption": "caption3",
              "photo_studio_order_id": "photo_studio_order_id1"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name5",
                  "abbreviation": "abbreviation7"
                },
                "area_unit": "METRIC_SQUARE_KILOMETER",
                "length_unit": "IMPERIAL_FOOT",
                "volume_unit": "GENERIC_SHOT",
                "weight_unit": "METRIC_KILOGRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_SECOND",
                "type": "TYPE_AREA"
              },
              "precision": 139
            },
            "subscription_plan_data": {
              "name": "name1",
              "phases": [
                {
                  "uid": "uid4",
                  "cadence": "DAILY",
                  "periods": 248,
                  "recurring_price_money": {},
                  "ordinal": 214
                },
                {
                  "uid": "uid3",
                  "cadence": "WEEKLY",
                  "periods": 247,
                  "recurring_price_money": {},
                  "ordinal": 213
                },
                {
                  "uid": "uid2",
                  "cadence": "EVERY_TWO_WEEKS",
                  "periods": 246,
                  "recurring_price_money": {},
                  "ordinal": 212
                }
              ]
            },
            "item_option_data": {
              "name": "name7",
              "display_name": "display_name7",
              "description": "description3",
              "show_colors": true,
              "values": [
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id1",
              "name": "name9",
              "description": "description9",
              "color": "color3",
              "ordinal": 225
            },
            "custom_attribute_definition_data": {
              "type": "SELECTION",
              "name": "name7",
              "description": "description7",
              "source_application": {
                "product": "OTHER",
                "application_id": "application_id5",
                "name": "name9"
              },
              "allowed_object_types": [
                "PRICING_RULE",
                "MODIFIER",
                "MODIFIER_LIST"
              ],
              "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
              "app_visibility": "APP_VISIBILITY_HIDDEN",
              "string_config": {
                "enforce_uniqueness": true
              },
              "number_config": {
                "precision": 181
              },
              "selection_config": {
                "max_allowed_selections": 215,
                "allowed_selections": [
                  {
                    "uid": "uid6",
                    "name": "name6"
                  }
                ]
              },
              "custom_attribute_usage_count": 51,
              "key": "key7"
            },
            "quick_amounts_settings_data": {
              "option": "DISABLED",
              "eligible_for_auto_amounts": true,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 141,
                  "ordinal": 73
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 142,
                  "ordinal": 74
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 143,
                  "ordinal": 75
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
          "image_ids7",
          "image_ids8"
        ]
      },
      "item_variation_data": {
        "item_id": "item_id6",
        "name": "name4",
        "sku": "sku0",
        "upc": "upc8",
        "ordinal": 194,
        "pricing_type": "FIXED_PRICING",
        "price_money": {},
        "location_overrides": [
          {},
          {}
        ],
        "track_inventory": false,
        "inventory_alert_type": "NONE",
        "inventory_alert_threshold": 196,
        "user_data": "user_data2",
        "service_duration": 28,
        "available_for_booking": false,
        "item_option_values": [
          {}
        ],
        "measurement_unit_id": "measurement_unit_id6",
        "sellable": false,
        "stockable": false,
        "image_ids": [
          "image_ids9"
        ],
        "team_member_ids": [
          "team_member_ids1"
        ],
        "stockable_conversion": {
          "stockable_item_variation_id": "stockable_item_variation_id2",
          "stockable_quantity": "stockable_quantity4",
          "nonstockable_quantity": "nonstockable_quantity6"
        },
        "item_variation_vendor_info_ids": [
          "item_variation_vendor_info_ids3",
          "item_variation_vendor_info_ids4",
          "item_variation_vendor_info_ids5"
        ]
      },
      "tax_data": {
        "name": "name2",
        "calculation_phase": "TAX_SUBTOTAL_PHASE",
        "inclusion_type": "ADDITIVE",
        "percentage": "percentage0",
        "applies_to_custom_amounts": false,
        "enabled": false
      },
      "discount_data": {
        "name": "name6",
        "discount_type": "VARIABLE_PERCENTAGE",
        "percentage": "percentage4",
        "amount_money": {},
        "pin_required": false,
        "label_color": "label_color8",
        "modify_tax_basis": "MODIFY_TAX_BASIS",
        "maximum_amount_money": {}
      },
      "modifier_list_data": {
        "name": "name8",
        "ordinal": 126,
        "selection_type": "SINGLE",
        "modifiers": [
          {},
          {}
        ],
        "image_ids": [
          "image_ids7",
          "image_ids8",
          "image_ids9"
        ]
      },
      "modifier_data": {
        "name": "name6",
        "price_money": {},
        "ordinal": 56,
        "modifier_list_id": "modifier_list_id2",
        "image_id": "image_id0"
      },
      "time_period_data": {
        "event": "event8"
      },
      "product_set_data": {
        "name": "name6",
        "product_ids_any": [
          "product_ids_any8"
        ],
        "product_ids_all": [
          "product_ids_all1"
        ],
        "quantity_exact": 36,
        "quantity_min": 170,
        "quantity_max": 144,
        "all_products": false
      },
      "pricing_rule_data": {
        "name": "name8",
        "time_period_ids": [
          "time_period_ids0",
          "time_period_ids1",
          "time_period_ids2"
        ],
        "discount_id": "discount_id6",
        "match_products_id": "match_products_id4",
        "apply_products_id": "apply_products_id8",
        "exclude_products_id": "exclude_products_id4",
        "valid_from_date": "valid_from_date4",
        "valid_from_local_time": "valid_from_local_time2",
        "valid_until_date": "valid_until_date6",
        "valid_until_local_time": "valid_until_local_time6",
        "exclude_strategy": "LEAST_EXPENSIVE",
        "minimum_order_subtotal_money": {},
        "customer_group_ids_any": [
          "customer_group_ids_any7",
          "customer_group_ids_any8",
          "customer_group_ids_any9"
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
          "volume_unit": "GENERIC_SHOT",
          "weight_unit": "IMPERIAL_WEIGHT_OUNCE",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_HOUR",
          "type": "TYPE_CUSTOM"
        },
        "precision": 244
      },
      "subscription_plan_data": {
        "name": "name2",
        "phases": [
          {},
          {},
          {}
        ]
      },
      "item_option_data": {
        "name": "name2",
        "display_name": "display_name2",
        "description": "description8",
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
        "ordinal": 120
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
          "ITEM",
          "SUBSCRIPTION_PLAN",
          "QUICK_AMOUNTS_SETTINGS"
        ],
        "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
        "app_visibility": "APP_VISIBILITY_READ_ONLY",
        "string_config": {
          "enforce_uniqueness": false
        },
        "number_config": {
          "precision": 30
        },
        "selection_config": {
          "max_allowed_selections": 110,
          "allowed_selections": [
            {},
            {}
          ]
        },
        "custom_attribute_usage_count": 202,
        "key": "key6"
      },
      "quick_amounts_settings_data": {
        "option": "MANUAL",
        "eligible_for_auto_amounts": false,
        "amounts": [
          {}
        ]
      }
    }
  ],
  "cursor": "cursor6",
  "matched_variation_ids": [
    "matched_variation_ids9",
    "matched_variation_ids0"
  ]
}
```

