
# Catalog Item Option

A group of variations for a `CatalogItem`.

## Structure

`CatalogItemOption`

## Fields

| Name | Type | Tags | Description | Getter | Setter |
|  --- | --- | --- | --- | --- | --- |
| `name` | `?string` | Optional | The item option's display name for the seller. Must be unique across<br>all item options. This is a searchable attribute for use in applicable query filters. | getName(): ?string | setName(?string name): void |
| `displayName` | `?string` | Optional | The item option's display name for the customer. This is a searchable attribute for use in applicable query filters. | getDisplayName(): ?string | setDisplayName(?string displayName): void |
| `description` | `?string` | Optional | The item option's human-readable description. Displayed in the Square<br>Point of Sale app for the seller and in the Online Store or on receipts for<br>the buyer. This is a searchable attribute for use in applicable query filters. | getDescription(): ?string | setDescription(?string description): void |
| `showColors` | `?bool` | Optional | If true, display colors for entries in `values` when present. | getShowColors(): ?bool | setShowColors(?bool showColors): void |
| `values` | [`?(CatalogObject[])`](../../doc/models/catalog-object.md) | Optional | A list of CatalogObjects containing the<br>`CatalogItemOptionValue`s for this item. | getValues(): ?array | setValues(?array values): void |

## Example (as JSON)

```json
{
  "name": "name0",
  "display_name": "display_name0",
  "description": "description0",
  "show_colors": false,
  "values": [
    {
      "type": "MODIFIER",
      "id": "id0",
      "updated_at": "updated_at6",
      "version": 100,
      "is_deleted": false,
      "custom_attribute_values": {
        "key0": {
          "name": "name1",
          "string_value": "string_value5",
          "custom_attribute_definition_id": "custom_attribute_definition_id1",
          "type": "SELECTION",
          "number_value": "number_value1",
          "boolean_value": true,
          "selection_uid_values": [
            "selection_uid_values8",
            "selection_uid_values9"
          ],
          "key": "key1"
        },
        "key1": {
          "name": "name0",
          "string_value": "string_value4",
          "custom_attribute_definition_id": "custom_attribute_definition_id2",
          "type": "STRING",
          "number_value": "number_value0",
          "boolean_value": false,
          "selection_uid_values": [
            "selection_uid_values7"
          ],
          "key": "key0"
        },
        "key2": {
          "name": "name9",
          "string_value": "string_value3",
          "custom_attribute_definition_id": "custom_attribute_definition_id3",
          "type": "BOOLEAN",
          "number_value": "number_value9",
          "boolean_value": true,
          "selection_uid_values": [
            "selection_uid_values6",
            "selection_uid_values7",
            "selection_uid_values8"
          ],
          "key": "key9"
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
        "name": "name8",
        "description": "description8",
        "abbreviation": "abbreviation0",
        "label_color": "label_color0",
        "available_online": false,
        "available_for_pickup": false,
        "available_electronically": false,
        "category_id": "category_id0",
        "tax_ids": [
          "tax_ids9"
        ],
        "modifier_list_info": [
          {
            "modifier_list_id": "modifier_list_id8",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id1",
                "on_by_default": true
              }
            ],
            "min_selected_modifiers": 60,
            "max_selected_modifiers": 40,
            "enabled": false
          },
          {
            "modifier_list_id": "modifier_list_id9",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id2",
                "on_by_default": false
              },
              {
                "modifier_id": "modifier_id3",
                "on_by_default": true
              }
            ],
            "min_selected_modifiers": 61,
            "max_selected_modifiers": 41,
            "enabled": true
          }
        ],
        "variations": [
          {
            "type": "ITEM",
            "id": "id9",
            "updated_at": "updated_at5",
            "version": 203,
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
              "present_at_location_ids9",
              "present_at_location_ids0"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids0",
              "absent_at_location_ids1",
              "absent_at_location_ids2"
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
                "tax_ids2"
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
                  "item_option_id": "item_option_id2"
                }
              ],
              "image_ids": [
                "image_ids6",
                "image_ids5"
              ],
              "sort_name": "sort_name9",
              "description_html": "description_html9",
              "description_plaintext": "description_plaintext9"
            },
            "category_data": {
              "name": "name3",
              "image_ids": [
                "image_ids8",
                "image_ids9"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id5",
              "name": "name5",
              "sku": "sku9",
              "upc": "upc7",
              "ordinal": 253,
              "pricing_type": "VARIABLE_PRICING",
              "price_money": {
                "amount": 29,
                "currency": "SDG"
              },
              "location_overrides": [
                {
                  "location_id": "location_id0",
                  "price_money": {
                    "amount": 72,
                    "currency": "RWF"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 192,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until4"
                },
                {
                  "location_id": "location_id1",
                  "price_money": {
                    "amount": 73,
                    "currency": "SAR"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 193,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until5"
                }
              ],
              "track_inventory": true,
              "inventory_alert_type": "LOW_QUANTITY",
              "inventory_alert_threshold": 1,
              "user_data": "user_data1",
              "service_duration": 87,
              "available_for_booking": true,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id6",
                  "item_option_value_id": "item_option_value_id6"
                }
              ],
              "measurement_unit_id": "measurement_unit_id5",
              "sellable": true,
              "stockable": true,
              "image_ids": [
                "image_ids0"
              ],
              "team_member_ids": [
                "team_member_ids2"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id7",
                "stockable_quantity": "stockable_quantity5",
                "nonstockable_quantity": "nonstockable_quantity7"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids4",
                "item_variation_vendor_info_ids5",
                "item_variation_vendor_info_ids6"
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
              "discount_type": "VARIABLE_AMOUNT",
              "percentage": "percentage1",
              "amount_money": {},
              "pin_required": true,
              "label_color": "label_color5",
              "modify_tax_basis": "DO_NOT_MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name7",
              "ordinal": 67,
              "selection_type": "MULTIPLE",
              "modifiers": [
                {},
                {}
              ],
              "image_ids": [
                "image_ids8",
                "image_ids7"
              ]
            },
            "modifier_data": {
              "name": "name3",
              "price_money": {},
              "ordinal": 45,
              "modifier_list_id": "modifier_list_id9",
              "image_id": "image_id7"
            },
            "time_period_data": {
              "event": "event7"
            },
            "product_set_data": {
              "name": "name7",
              "product_ids_any": [
                "product_ids_any9"
              ],
              "product_ids_all": [
                "product_ids_all8"
              ],
              "quantity_exact": 95,
              "quantity_min": 229,
              "quantity_max": 203,
              "all_products": true
            },
            "pricing_rule_data": {
              "name": "name1",
              "time_period_ids": [
                "time_period_ids3",
                "time_period_ids4",
                "time_period_ids5"
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
                "customer_group_ids_any0",
                "customer_group_ids_any1",
                "customer_group_ids_any2"
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
                "area_unit": "METRIC_SQUARE_CENTIMETER",
                "length_unit": "IMPERIAL_MILE",
                "volume_unit": "GENERIC_PINT",
                "weight_unit": "METRIC_MILLIGRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_SECOND",
                "type": "TYPE_VOLUME"
              },
              "precision": 185
            },
            "subscription_plan_data": {
              "name": "name1",
              "phases": [
                {
                  "uid": "uid4",
                  "cadence": "EVERY_TWO_YEARS",
                  "periods": 202,
                  "recurring_price_money": {},
                  "ordinal": 168
                },
                {
                  "uid": "uid3",
                  "cadence": "DAILY",
                  "periods": 201,
                  "recurring_price_money": {},
                  "ordinal": 167
                }
              ]
            },
            "item_option_data": {
              "name": "name7",
              "display_name": "display_name7",
              "description": "description3",
              "show_colors": true,
              "values": [
                {},
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id1",
              "name": "name9",
              "description": "description9",
              "color": "color3",
              "ordinal": 179
            },
            "custom_attribute_definition_data": {
              "type": "BOOLEAN",
              "name": "name7",
              "description": "description7",
              "source_application": {
                "product": "OTHER",
                "application_id": "application_id5",
                "name": "name9"
              },
              "allowed_object_types": [
                "PRODUCT_SET",
                "PRICING_RULE",
                "MODIFIER"
              ],
              "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
              "app_visibility": "APP_VISIBILITY_READ_ONLY",
              "string_config": {
                "enforce_uniqueness": true
              },
              "number_config": {
                "precision": 227
              },
              "selection_config": {
                "max_allowed_selections": 169,
                "allowed_selections": [
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
              "custom_attribute_usage_count": 5,
              "key": "key7"
            },
            "quick_amounts_settings_data": {
              "option": "MANUAL",
              "eligible_for_auto_amounts": true,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 95,
                  "ordinal": 27
                }
              ]
            }
          },
          {
            "type": "SUBSCRIPTION_PLAN",
            "id": "id0",
            "updated_at": "updated_at4",
            "version": 204,
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
              "present_at_location_ids0",
              "present_at_location_ids1",
              "present_at_location_ids2"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids1"
            ],
            "item_data": {
              "name": "name8",
              "description": "description8",
              "abbreviation": "abbreviation0",
              "label_color": "label_color0",
              "available_online": false,
              "available_for_pickup": false,
              "available_electronically": false,
              "category_id": "category_id0",
              "tax_ids": [
                "tax_ids1",
                "tax_ids0"
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
                  "item_option_id": "item_option_id3"
                },
                {
                  "item_option_id": "item_option_id2"
                },
                {
                  "item_option_id": "item_option_id1"
                }
              ],
              "image_ids": [
                "image_ids7"
              ],
              "sort_name": "sort_name0",
              "description_html": "description_html8",
              "description_plaintext": "description_plaintext8"
            },
            "category_data": {
              "name": "name4",
              "image_ids": [
                "image_ids9",
                "image_ids0",
                "image_ids1"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id4",
              "name": "name6",
              "sku": "sku8",
              "upc": "upc6",
              "ordinal": 254,
              "pricing_type": "FIXED_PRICING",
              "price_money": {
                "amount": 28,
                "currency": "SCR"
              },
              "location_overrides": [
                {
                  "location_id": "location_id1",
                  "price_money": {
                    "amount": 73,
                    "currency": "SAR"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 193,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until5"
                },
                {
                  "location_id": "location_id2",
                  "price_money": {
                    "amount": 74,
                    "currency": "SBD"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 194,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until6"
                },
                {
                  "location_id": "location_id3",
                  "price_money": {
                    "amount": 75,
                    "currency": "SCR"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 195,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until7"
                }
              ],
              "track_inventory": false,
              "inventory_alert_type": "NONE",
              "inventory_alert_threshold": 0,
              "user_data": "user_data0",
              "service_duration": 88,
              "available_for_booking": false,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id5",
                  "item_option_value_id": "item_option_value_id7"
                },
                {
                  "item_option_id": "item_option_id6",
                  "item_option_value_id": "item_option_value_id6"
                },
                {
                  "item_option_id": "item_option_id7",
                  "item_option_value_id": "item_option_value_id5"
                }
              ],
              "measurement_unit_id": "measurement_unit_id4",
              "sellable": false,
              "stockable": false,
              "image_ids": [
                "image_ids9",
                "image_ids0",
                "image_ids1"
              ],
              "team_member_ids": [
                "team_member_ids3",
                "team_member_ids4"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id6",
                "stockable_quantity": "stockable_quantity6",
                "nonstockable_quantity": "nonstockable_quantity8"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids5"
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
              "name": "name2",
              "discount_type": "VARIABLE_PERCENTAGE",
              "percentage": "percentage0",
              "amount_money": {},
              "pin_required": false,
              "label_color": "label_color4",
              "modify_tax_basis": "MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name6",
              "ordinal": 66,
              "selection_type": "SINGLE",
              "modifiers": [
                {}
              ],
              "image_ids": [
                "image_ids9"
              ]
            },
            "modifier_data": {
              "name": "name2",
              "price_money": {},
              "ordinal": 44,
              "modifier_list_id": "modifier_list_id8",
              "image_id": "image_id6"
            },
            "time_period_data": {
              "event": "event6"
            },
            "product_set_data": {
              "name": "name8",
              "product_ids_any": [
                "product_ids_any0",
                "product_ids_any9",
                "product_ids_any8"
              ],
              "product_ids_all": [
                "product_ids_all9",
                "product_ids_all8",
                "product_ids_all7"
              ],
              "quantity_exact": 96,
              "quantity_min": 230,
              "quantity_max": 204,
              "all_products": false
            },
            "pricing_rule_data": {
              "name": "name0",
              "time_period_ids": [
                "time_period_ids2",
                "time_period_ids3"
              ],
              "discount_id": "discount_id8",
              "match_products_id": "match_products_id2",
              "apply_products_id": "apply_products_id6",
              "exclude_products_id": "exclude_products_id6",
              "valid_from_date": "valid_from_date2",
              "valid_from_local_time": "valid_from_local_time0",
              "valid_until_date": "valid_until_date4",
              "valid_until_local_time": "valid_until_local_time4",
              "exclude_strategy": "LEAST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any9",
                "customer_group_ids_any0"
              ]
            },
            "image_data": {
              "name": "name0",
              "url": "url4",
              "caption": "caption4",
              "photo_studio_order_id": "photo_studio_order_id2"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name4",
                  "abbreviation": "abbreviation6"
                },
                "area_unit": "IMPERIAL_SQUARE_MILE",
                "length_unit": "METRIC_MILLIMETER",
                "volume_unit": "GENERIC_CUP",
                "weight_unit": "METRIC_GRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_MILLISECOND",
                "type": "TYPE_WEIGHT"
              },
              "precision": 184
            },
            "subscription_plan_data": {
              "name": "name0",
              "phases": [
                {
                  "uid": "uid5",
                  "cadence": "ANNUAL",
                  "periods": 203,
                  "recurring_price_money": {},
                  "ordinal": 169
                }
              ]
            },
            "item_option_data": {
              "name": "name6",
              "display_name": "display_name6",
              "description": "description4",
              "show_colors": false,
              "values": [
                {},
                {},
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id2",
              "name": "name0",
              "description": "description0",
              "color": "color4",
              "ordinal": 180
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
                "PRICING_RULE"
              ],
              "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
              "app_visibility": "APP_VISIBILITY_READ_WRITE_VALUES",
              "string_config": {
                "enforce_uniqueness": false
              },
              "number_config": {
                "precision": 226
              },
              "selection_config": {
                "max_allowed_selections": 170,
                "allowed_selections": [
                  {
                    "uid": "uid7",
                    "name": "name7"
                  },
                  {
                    "uid": "uid8",
                    "name": "name8"
                  },
                  {
                    "uid": "uid9",
                    "name": "name9"
                  }
                ]
              },
              "custom_attribute_usage_count": 6,
              "key": "key8"
            },
            "quick_amounts_settings_data": {
              "option": "AUTO",
              "eligible_for_auto_amounts": false,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 96,
                  "ordinal": 28
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 97,
                  "ordinal": 29
                }
              ]
            }
          },
          {
            "type": "QUICK_AMOUNTS_SETTINGS",
            "id": "id1",
            "updated_at": "updated_at3",
            "version": 205,
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
              "present_at_location_ids1"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids2",
              "absent_at_location_ids3"
            ],
            "item_data": {
              "name": "name7",
              "description": "description7",
              "abbreviation": "abbreviation9",
              "label_color": "label_color9",
              "available_online": true,
              "available_for_pickup": true,
              "available_electronically": true,
              "category_id": "category_id1",
              "tax_ids": [
                "tax_ids0",
                "tax_ids9",
                "tax_ids8"
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
                  "item_option_id": "item_option_id4"
                },
                {
                  "item_option_id": "item_option_id3"
                }
              ],
              "image_ids": [
                "image_ids8",
                "image_ids7",
                "image_ids6"
              ],
              "sort_name": "sort_name1",
              "description_html": "description_html7",
              "description_plaintext": "description_plaintext7"
            },
            "category_data": {
              "name": "name5",
              "image_ids": [
                "image_ids0"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id3",
              "name": "name7",
              "sku": "sku7",
              "upc": "upc5",
              "ordinal": 255,
              "pricing_type": "VARIABLE_PRICING",
              "price_money": {
                "amount": 27,
                "currency": "SBD"
              },
              "location_overrides": [
                {
                  "location_id": "location_id2",
                  "price_money": {
                    "amount": 74,
                    "currency": "SBD"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 194,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until6"
                }
              ],
              "track_inventory": true,
              "inventory_alert_type": "LOW_QUANTITY",
              "inventory_alert_threshold": 255,
              "user_data": "user_data9",
              "service_duration": 89,
              "available_for_booking": true,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id4",
                  "item_option_value_id": "item_option_value_id8"
                },
                {
                  "item_option_id": "item_option_id5",
                  "item_option_value_id": "item_option_value_id7"
                }
              ],
              "measurement_unit_id": "measurement_unit_id3",
              "sellable": true,
              "stockable": true,
              "image_ids": [
                "image_ids8",
                "image_ids9"
              ],
              "team_member_ids": [
                "team_member_ids4",
                "team_member_ids5",
                "team_member_ids6"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id5",
                "stockable_quantity": "stockable_quantity7",
                "nonstockable_quantity": "nonstockable_quantity9"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids6",
                "item_variation_vendor_info_ids7"
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
              "name": "name1",
              "discount_type": "FIXED_AMOUNT",
              "percentage": "percentage9",
              "amount_money": {},
              "pin_required": true,
              "label_color": "label_color3",
              "modify_tax_basis": "DO_NOT_MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name5",
              "ordinal": 65,
              "selection_type": "MULTIPLE",
              "modifiers": [
                {},
                {},
                {}
              ],
              "image_ids": [
                "image_ids0",
                "image_ids9",
                "image_ids8"
              ]
            },
            "modifier_data": {
              "name": "name1",
              "price_money": {},
              "ordinal": 43,
              "modifier_list_id": "modifier_list_id7",
              "image_id": "image_id5"
            },
            "time_period_data": {
              "event": "event5"
            },
            "product_set_data": {
              "name": "name9",
              "product_ids_any": [
                "product_ids_any1",
                "product_ids_any0"
              ],
              "product_ids_all": [
                "product_ids_all0",
                "product_ids_all9"
              ],
              "quantity_exact": 97,
              "quantity_min": 231,
              "quantity_max": 205,
              "all_products": true
            },
            "pricing_rule_data": {
              "name": "name9",
              "time_period_ids": [
                "time_period_ids1"
              ],
              "discount_id": "discount_id7",
              "match_products_id": "match_products_id3",
              "apply_products_id": "apply_products_id7",
              "exclude_products_id": "exclude_products_id5",
              "valid_from_date": "valid_from_date3",
              "valid_from_local_time": "valid_from_local_time1",
              "valid_until_date": "valid_until_date5",
              "valid_until_local_time": "valid_until_local_time5",
              "exclude_strategy": "MOST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any8"
              ]
            },
            "image_data": {
              "name": "name1",
              "url": "url5",
              "caption": "caption5",
              "photo_studio_order_id": "photo_studio_order_id3"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name3",
                  "abbreviation": "abbreviation5"
                },
                "area_unit": "IMPERIAL_SQUARE_YARD",
                "length_unit": "METRIC_CENTIMETER",
                "volume_unit": "GENERIC_SHOT",
                "weight_unit": "METRIC_KILOGRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_DAY",
                "type": "TYPE_GENERIC"
              },
              "precision": 183
            },
            "subscription_plan_data": {
              "name": "name9",
              "phases": [
                {
                  "uid": "uid6",
                  "cadence": "EVERY_SIX_MONTHS",
                  "periods": 204,
                  "recurring_price_money": {},
                  "ordinal": 170
                },
                {
                  "uid": "uid5",
                  "cadence": "ANNUAL",
                  "periods": 203,
                  "recurring_price_money": {},
                  "ordinal": 169
                },
                {
                  "uid": "uid4",
                  "cadence": "EVERY_TWO_YEARS",
                  "periods": 202,
                  "recurring_price_money": {},
                  "ordinal": 168
                }
              ]
            },
            "item_option_data": {
              "name": "name5",
              "display_name": "display_name5",
              "description": "description5",
              "show_colors": true,
              "values": [
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id3",
              "name": "name1",
              "description": "description1",
              "color": "color5",
              "ordinal": 181
            },
            "custom_attribute_definition_data": {
              "type": "SELECTION",
              "name": "name9",
              "description": "description9",
              "source_application": {
                "product": "EXTERNAL_API",
                "application_id": "application_id7",
                "name": "name1"
              },
              "allowed_object_types": [
                "MODIFIER",
                "MODIFIER_LIST"
              ],
              "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
              "app_visibility": "APP_VISIBILITY_HIDDEN",
              "string_config": {
                "enforce_uniqueness": true
              },
              "number_config": {
                "precision": 225
              },
              "selection_config": {
                "max_allowed_selections": 171,
                "allowed_selections": [
                  {
                    "uid": "uid8",
                    "name": "name8"
                  }
                ]
              },
              "custom_attribute_usage_count": 7,
              "key": "key9"
            },
            "quick_amounts_settings_data": {
              "option": "DISABLED",
              "eligible_for_auto_amounts": true,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 97,
                  "ordinal": 29
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 98,
                  "ordinal": 30
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 99,
                  "ordinal": 31
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
          "image_ids2",
          "image_ids1"
        ],
        "sort_name": "sort_name0",
        "description_html": "description_html8",
        "description_plaintext": "description_plaintext8"
      },
      "category_data": {
        "name": "name4",
        "image_ids": [
          "image_ids9",
          "image_ids0"
        ]
      },
      "item_variation_data": {
        "item_id": "item_id4",
        "name": "name6",
        "sku": "sku2",
        "upc": "upc6",
        "ordinal": 150,
        "pricing_type": "FIXED_PRICING",
        "price_money": {},
        "location_overrides": [
          {},
          {}
        ],
        "track_inventory": false,
        "inventory_alert_type": "NONE",
        "inventory_alert_threshold": 152,
        "user_data": "user_data0",
        "service_duration": 240,
        "available_for_booking": false,
        "item_option_values": [
          {}
        ],
        "measurement_unit_id": "measurement_unit_id4",
        "sellable": false,
        "stockable": false,
        "image_ids": [
          "image_ids9"
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
        "name": "name6",
        "ordinal": 170,
        "selection_type": "SINGLE",
        "modifiers": [
          {},
          {}
        ],
        "image_ids": [
          "image_ids9",
          "image_ids0",
          "image_ids1"
        ]
      },
      "modifier_data": {
        "name": "name8",
        "price_money": {},
        "ordinal": 12,
        "modifier_list_id": "modifier_list_id4",
        "image_id": "image_id2"
      },
      "time_period_data": {
        "event": "event6"
      },
      "product_set_data": {
        "name": "name8",
        "product_ids_any": [
          "product_ids_any6"
        ],
        "product_ids_all": [
          "product_ids_all1"
        ],
        "quantity_exact": 248,
        "quantity_min": 126,
        "quantity_max": 100,
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
        "match_products_id": "match_products_id2",
        "apply_products_id": "apply_products_id6",
        "exclude_products_id": "exclude_products_id6",
        "valid_from_date": "valid_from_date2",
        "valid_from_local_time": "valid_from_local_time0",
        "valid_until_date": "valid_until_date4",
        "valid_until_local_time": "valid_until_local_time4",
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
        "measurement_unit": {
          "custom_unit": {
            "name": "name4",
            "abbreviation": "abbreviation6"
          },
          "area_unit": "IMPERIAL_SQUARE_MILE",
          "length_unit": "METRIC_MILLIMETER",
          "volume_unit": "GENERIC_SHOT",
          "weight_unit": "IMPERIAL_WEIGHT_OUNCE",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_MILLISECOND",
          "type": "TYPE_CUSTOM"
        },
        "precision": 32
      },
      "subscription_plan_data": {
        "name": "name0",
        "phases": [
          {},
          {},
          {}
        ]
      },
      "item_option_data": {
        "name": "name4",
        "display_name": "display_name4",
        "description": "description6",
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
        "ordinal": 76
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
          "IMAGE",
          "CATEGORY",
          "ITEM_VARIATION"
        ],
        "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
        "app_visibility": "APP_VISIBILITY_READ_ONLY",
        "string_config": {
          "enforce_uniqueness": false
        },
        "number_config": {
          "precision": 74
        },
        "selection_config": {
          "max_allowed_selections": 66,
          "allowed_selections": [
            {},
            {}
          ]
        },
        "custom_attribute_usage_count": 158,
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
      "type": "MODIFIER_LIST",
      "id": "id1",
      "updated_at": "updated_at7",
      "version": 101,
      "is_deleted": true,
      "custom_attribute_values": {
        "key0": {
          "name": "name2",
          "string_value": "string_value6",
          "custom_attribute_definition_id": "custom_attribute_definition_id0",
          "type": "NUMBER",
          "number_value": "number_value2",
          "boolean_value": false,
          "selection_uid_values": [
            "selection_uid_values9",
            "selection_uid_values0",
            "selection_uid_values1"
          ],
          "key": "key2"
        },
        "key1": {
          "name": "name1",
          "string_value": "string_value5",
          "custom_attribute_definition_id": "custom_attribute_definition_id1",
          "type": "SELECTION",
          "number_value": "number_value1",
          "boolean_value": true,
          "selection_uid_values": [
            "selection_uid_values8",
            "selection_uid_values9"
          ],
          "key": "key1"
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
        "name": "name7",
        "description": "description7",
        "abbreviation": "abbreviation9",
        "label_color": "label_color9",
        "available_online": true,
        "available_for_pickup": true,
        "available_electronically": true,
        "category_id": "category_id1",
        "tax_ids": [
          "tax_ids0",
          "tax_ids1"
        ],
        "modifier_list_info": [
          {
            "modifier_list_id": "modifier_list_id7",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id0",
                "on_by_default": false
              },
              {
                "modifier_id": "modifier_id1",
                "on_by_default": true
              },
              {
                "modifier_id": "modifier_id2",
                "on_by_default": false
              }
            ],
            "min_selected_modifiers": 59,
            "max_selected_modifiers": 39,
            "enabled": true
          }
        ],
        "variations": [
          {
            "type": "SUBSCRIPTION_PLAN",
            "id": "id0",
            "updated_at": "updated_at4",
            "version": 204,
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
              "present_at_location_ids0",
              "present_at_location_ids1",
              "present_at_location_ids2"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids1"
            ],
            "item_data": {
              "name": "name8",
              "description": "description8",
              "abbreviation": "abbreviation0",
              "label_color": "label_color0",
              "available_online": false,
              "available_for_pickup": false,
              "available_electronically": false,
              "category_id": "category_id0",
              "tax_ids": [
                "tax_ids1",
                "tax_ids0"
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
                  "item_option_id": "item_option_id3"
                },
                {
                  "item_option_id": "item_option_id2"
                },
                {
                  "item_option_id": "item_option_id1"
                }
              ],
              "image_ids": [
                "image_ids7"
              ],
              "sort_name": "sort_name0",
              "description_html": "description_html8",
              "description_plaintext": "description_plaintext8"
            },
            "category_data": {
              "name": "name4",
              "image_ids": [
                "image_ids9",
                "image_ids0",
                "image_ids1"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id4",
              "name": "name6",
              "sku": "sku8",
              "upc": "upc6",
              "ordinal": 254,
              "pricing_type": "FIXED_PRICING",
              "price_money": {
                "amount": 28,
                "currency": "SCR"
              },
              "location_overrides": [
                {
                  "location_id": "location_id1",
                  "price_money": {
                    "amount": 73,
                    "currency": "SAR"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 193,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until5"
                },
                {
                  "location_id": "location_id2",
                  "price_money": {
                    "amount": 74,
                    "currency": "SBD"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 194,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until6"
                },
                {
                  "location_id": "location_id3",
                  "price_money": {
                    "amount": 75,
                    "currency": "SCR"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 195,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until7"
                }
              ],
              "track_inventory": false,
              "inventory_alert_type": "NONE",
              "inventory_alert_threshold": 0,
              "user_data": "user_data0",
              "service_duration": 88,
              "available_for_booking": false,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id5",
                  "item_option_value_id": "item_option_value_id7"
                },
                {
                  "item_option_id": "item_option_id6",
                  "item_option_value_id": "item_option_value_id6"
                },
                {
                  "item_option_id": "item_option_id7",
                  "item_option_value_id": "item_option_value_id5"
                }
              ],
              "measurement_unit_id": "measurement_unit_id4",
              "sellable": false,
              "stockable": false,
              "image_ids": [
                "image_ids9",
                "image_ids0",
                "image_ids1"
              ],
              "team_member_ids": [
                "team_member_ids3",
                "team_member_ids4"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id6",
                "stockable_quantity": "stockable_quantity6",
                "nonstockable_quantity": "nonstockable_quantity8"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids5"
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
              "name": "name2",
              "discount_type": "VARIABLE_PERCENTAGE",
              "percentage": "percentage0",
              "amount_money": {},
              "pin_required": false,
              "label_color": "label_color4",
              "modify_tax_basis": "MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name6",
              "ordinal": 66,
              "selection_type": "SINGLE",
              "modifiers": [
                {}
              ],
              "image_ids": [
                "image_ids9"
              ]
            },
            "modifier_data": {
              "name": "name2",
              "price_money": {},
              "ordinal": 44,
              "modifier_list_id": "modifier_list_id8",
              "image_id": "image_id6"
            },
            "time_period_data": {
              "event": "event6"
            },
            "product_set_data": {
              "name": "name8",
              "product_ids_any": [
                "product_ids_any0",
                "product_ids_any9",
                "product_ids_any8"
              ],
              "product_ids_all": [
                "product_ids_all9",
                "product_ids_all8",
                "product_ids_all7"
              ],
              "quantity_exact": 96,
              "quantity_min": 230,
              "quantity_max": 204,
              "all_products": false
            },
            "pricing_rule_data": {
              "name": "name0",
              "time_period_ids": [
                "time_period_ids2",
                "time_period_ids3"
              ],
              "discount_id": "discount_id8",
              "match_products_id": "match_products_id2",
              "apply_products_id": "apply_products_id6",
              "exclude_products_id": "exclude_products_id6",
              "valid_from_date": "valid_from_date2",
              "valid_from_local_time": "valid_from_local_time0",
              "valid_until_date": "valid_until_date4",
              "valid_until_local_time": "valid_until_local_time4",
              "exclude_strategy": "LEAST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any9",
                "customer_group_ids_any0"
              ]
            },
            "image_data": {
              "name": "name0",
              "url": "url4",
              "caption": "caption4",
              "photo_studio_order_id": "photo_studio_order_id2"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name4",
                  "abbreviation": "abbreviation6"
                },
                "area_unit": "IMPERIAL_SQUARE_MILE",
                "length_unit": "METRIC_MILLIMETER",
                "volume_unit": "GENERIC_CUP",
                "weight_unit": "METRIC_GRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_MILLISECOND",
                "type": "TYPE_WEIGHT"
              },
              "precision": 184
            },
            "subscription_plan_data": {
              "name": "name0",
              "phases": [
                {
                  "uid": "uid5",
                  "cadence": "ANNUAL",
                  "periods": 203,
                  "recurring_price_money": {},
                  "ordinal": 169
                }
              ]
            },
            "item_option_data": {
              "name": "name6",
              "display_name": "display_name6",
              "description": "description4",
              "show_colors": false,
              "values": [
                {},
                {},
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id2",
              "name": "name0",
              "description": "description0",
              "color": "color4",
              "ordinal": 180
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
                "PRICING_RULE"
              ],
              "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
              "app_visibility": "APP_VISIBILITY_READ_WRITE_VALUES",
              "string_config": {
                "enforce_uniqueness": false
              },
              "number_config": {
                "precision": 226
              },
              "selection_config": {
                "max_allowed_selections": 170,
                "allowed_selections": [
                  {
                    "uid": "uid7",
                    "name": "name7"
                  },
                  {
                    "uid": "uid8",
                    "name": "name8"
                  },
                  {
                    "uid": "uid9",
                    "name": "name9"
                  }
                ]
              },
              "custom_attribute_usage_count": 6,
              "key": "key8"
            },
            "quick_amounts_settings_data": {
              "option": "AUTO",
              "eligible_for_auto_amounts": false,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 96,
                  "ordinal": 28
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 97,
                  "ordinal": 29
                }
              ]
            }
          }
        ],
        "product_type": "APPOINTMENTS_SERVICE",
        "skip_modifier_screen": true,
        "item_options": [
          {},
          {}
        ],
        "image_ids": [
          "image_ids2"
        ],
        "sort_name": "sort_name1",
        "description_html": "description_html7",
        "description_plaintext": "description_plaintext7"
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
        "item_id": "item_id3",
        "name": "name7",
        "sku": "sku3",
        "upc": "upc5",
        "ordinal": 151,
        "pricing_type": "VARIABLE_PRICING",
        "price_money": {},
        "location_overrides": [
          {},
          {},
          {}
        ],
        "track_inventory": true,
        "inventory_alert_type": "LOW_QUANTITY",
        "inventory_alert_threshold": 153,
        "user_data": "user_data9",
        "service_duration": 241,
        "available_for_booking": true,
        "item_option_values": [
          {},
          {},
          {}
        ],
        "measurement_unit_id": "measurement_unit_id3",
        "sellable": true,
        "stockable": true,
        "image_ids": [
          "image_ids8",
          "image_ids7"
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
        "ordinal": 169,
        "selection_type": "MULTIPLE",
        "modifiers": [
          {}
        ],
        "image_ids": [
          "image_ids0"
        ]
      },
      "modifier_data": {
        "name": "name9",
        "price_money": {},
        "ordinal": 13,
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
          "product_ids_any4"
        ],
        "product_ids_all": [
          "product_ids_all2",
          "product_ids_all3"
        ],
        "quantity_exact": 249,
        "quantity_min": 127,
        "quantity_max": 101,
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
        "name": "name1",
        "url": "url5",
        "caption": "caption5",
        "photo_studio_order_id": "photo_studio_order_id3"
      },
      "measurement_unit_data": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name3",
            "abbreviation": "abbreviation5"
          },
          "area_unit": "IMPERIAL_SQUARE_YARD",
          "length_unit": "METRIC_CENTIMETER",
          "volume_unit": "GENERIC_FLUID_OUNCE",
          "weight_unit": "IMPERIAL_POUND",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_SECOND",
          "type": "TYPE_AREA"
        },
        "precision": 31
      },
      "subscription_plan_data": {
        "name": "name9",
        "phases": [
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
          {},
          {}
        ]
      },
      "item_option_value_data": {
        "item_option_id": "item_option_id3",
        "name": "name1",
        "description": "description1",
        "color": "color5",
        "ordinal": 77
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
          "CATEGORY"
        ],
        "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
        "app_visibility": "APP_VISIBILITY_READ_WRITE_VALUES",
        "string_config": {
          "enforce_uniqueness": true
        },
        "number_config": {
          "precision": 73
        },
        "selection_config": {
          "max_allowed_selections": 67,
          "allowed_selections": [
            {},
            {},
            {}
          ]
        },
        "custom_attribute_usage_count": 159,
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
      "type": "DISCOUNT",
      "id": "id2",
      "updated_at": "updated_at8",
      "version": 102,
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
            "selection_uid_values0"
          ],
          "key": "key3"
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
        "name": "name6",
        "description": "description6",
        "abbreviation": "abbreviation8",
        "label_color": "label_color8",
        "available_online": false,
        "available_for_pickup": false,
        "available_electronically": false,
        "category_id": "category_id2",
        "tax_ids": [
          "tax_ids1",
          "tax_ids2",
          "tax_ids3"
        ],
        "modifier_list_info": [
          {
            "modifier_list_id": "modifier_list_id6",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id9",
                "on_by_default": true
              },
              {
                "modifier_id": "modifier_id0",
                "on_by_default": false
              }
            ],
            "min_selected_modifiers": 58,
            "max_selected_modifiers": 38,
            "enabled": false
          },
          {
            "modifier_list_id": "modifier_list_id7",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id0",
                "on_by_default": false
              },
              {
                "modifier_id": "modifier_id1",
                "on_by_default": true
              },
              {
                "modifier_id": "modifier_id2",
                "on_by_default": false
              }
            ],
            "min_selected_modifiers": 59,
            "max_selected_modifiers": 39,
            "enabled": true
          },
          {
            "modifier_list_id": "modifier_list_id8",
            "modifier_overrides": [
              {
                "modifier_id": "modifier_id1",
                "on_by_default": true
              }
            ],
            "min_selected_modifiers": 60,
            "max_selected_modifiers": 40,
            "enabled": false
          }
        ],
        "variations": [
          {
            "type": "QUICK_AMOUNTS_SETTINGS",
            "id": "id1",
            "updated_at": "updated_at3",
            "version": 205,
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
              "present_at_location_ids1"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids2",
              "absent_at_location_ids3"
            ],
            "item_data": {
              "name": "name7",
              "description": "description7",
              "abbreviation": "abbreviation9",
              "label_color": "label_color9",
              "available_online": true,
              "available_for_pickup": true,
              "available_electronically": true,
              "category_id": "category_id1",
              "tax_ids": [
                "tax_ids0",
                "tax_ids9",
                "tax_ids8"
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
                  "item_option_id": "item_option_id4"
                },
                {
                  "item_option_id": "item_option_id3"
                }
              ],
              "image_ids": [
                "image_ids8",
                "image_ids7",
                "image_ids6"
              ],
              "sort_name": "sort_name1",
              "description_html": "description_html7",
              "description_plaintext": "description_plaintext7"
            },
            "category_data": {
              "name": "name5",
              "image_ids": [
                "image_ids0"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id3",
              "name": "name7",
              "sku": "sku7",
              "upc": "upc5",
              "ordinal": 255,
              "pricing_type": "VARIABLE_PRICING",
              "price_money": {
                "amount": 27,
                "currency": "SBD"
              },
              "location_overrides": [
                {
                  "location_id": "location_id2",
                  "price_money": {
                    "amount": 74,
                    "currency": "SBD"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 194,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until6"
                }
              ],
              "track_inventory": true,
              "inventory_alert_type": "LOW_QUANTITY",
              "inventory_alert_threshold": 255,
              "user_data": "user_data9",
              "service_duration": 89,
              "available_for_booking": true,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id4",
                  "item_option_value_id": "item_option_value_id8"
                },
                {
                  "item_option_id": "item_option_id5",
                  "item_option_value_id": "item_option_value_id7"
                }
              ],
              "measurement_unit_id": "measurement_unit_id3",
              "sellable": true,
              "stockable": true,
              "image_ids": [
                "image_ids8",
                "image_ids9"
              ],
              "team_member_ids": [
                "team_member_ids4",
                "team_member_ids5",
                "team_member_ids6"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id5",
                "stockable_quantity": "stockable_quantity7",
                "nonstockable_quantity": "nonstockable_quantity9"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids6",
                "item_variation_vendor_info_ids7"
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
              "name": "name1",
              "discount_type": "FIXED_AMOUNT",
              "percentage": "percentage9",
              "amount_money": {},
              "pin_required": true,
              "label_color": "label_color3",
              "modify_tax_basis": "DO_NOT_MODIFY_TAX_BASIS",
              "maximum_amount_money": {}
            },
            "modifier_list_data": {
              "name": "name5",
              "ordinal": 65,
              "selection_type": "MULTIPLE",
              "modifiers": [
                {},
                {},
                {}
              ],
              "image_ids": [
                "image_ids0",
                "image_ids9",
                "image_ids8"
              ]
            },
            "modifier_data": {
              "name": "name1",
              "price_money": {},
              "ordinal": 43,
              "modifier_list_id": "modifier_list_id7",
              "image_id": "image_id5"
            },
            "time_period_data": {
              "event": "event5"
            },
            "product_set_data": {
              "name": "name9",
              "product_ids_any": [
                "product_ids_any1",
                "product_ids_any0"
              ],
              "product_ids_all": [
                "product_ids_all0",
                "product_ids_all9"
              ],
              "quantity_exact": 97,
              "quantity_min": 231,
              "quantity_max": 205,
              "all_products": true
            },
            "pricing_rule_data": {
              "name": "name9",
              "time_period_ids": [
                "time_period_ids1"
              ],
              "discount_id": "discount_id7",
              "match_products_id": "match_products_id3",
              "apply_products_id": "apply_products_id7",
              "exclude_products_id": "exclude_products_id5",
              "valid_from_date": "valid_from_date3",
              "valid_from_local_time": "valid_from_local_time1",
              "valid_until_date": "valid_until_date5",
              "valid_until_local_time": "valid_until_local_time5",
              "exclude_strategy": "MOST_EXPENSIVE",
              "minimum_order_subtotal_money": {},
              "customer_group_ids_any": [
                "customer_group_ids_any8"
              ]
            },
            "image_data": {
              "name": "name1",
              "url": "url5",
              "caption": "caption5",
              "photo_studio_order_id": "photo_studio_order_id3"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name3",
                  "abbreviation": "abbreviation5"
                },
                "area_unit": "IMPERIAL_SQUARE_YARD",
                "length_unit": "METRIC_CENTIMETER",
                "volume_unit": "GENERIC_SHOT",
                "weight_unit": "METRIC_KILOGRAM",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_DAY",
                "type": "TYPE_GENERIC"
              },
              "precision": 183
            },
            "subscription_plan_data": {
              "name": "name9",
              "phases": [
                {
                  "uid": "uid6",
                  "cadence": "EVERY_SIX_MONTHS",
                  "periods": 204,
                  "recurring_price_money": {},
                  "ordinal": 170
                },
                {
                  "uid": "uid5",
                  "cadence": "ANNUAL",
                  "periods": 203,
                  "recurring_price_money": {},
                  "ordinal": 169
                },
                {
                  "uid": "uid4",
                  "cadence": "EVERY_TWO_YEARS",
                  "periods": 202,
                  "recurring_price_money": {},
                  "ordinal": 168
                }
              ]
            },
            "item_option_data": {
              "name": "name5",
              "display_name": "display_name5",
              "description": "description5",
              "show_colors": true,
              "values": [
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id3",
              "name": "name1",
              "description": "description1",
              "color": "color5",
              "ordinal": 181
            },
            "custom_attribute_definition_data": {
              "type": "SELECTION",
              "name": "name9",
              "description": "description9",
              "source_application": {
                "product": "EXTERNAL_API",
                "application_id": "application_id7",
                "name": "name1"
              },
              "allowed_object_types": [
                "MODIFIER",
                "MODIFIER_LIST"
              ],
              "seller_visibility": "SELLER_VISIBILITY_READ_WRITE_VALUES",
              "app_visibility": "APP_VISIBILITY_HIDDEN",
              "string_config": {
                "enforce_uniqueness": true
              },
              "number_config": {
                "precision": 225
              },
              "selection_config": {
                "max_allowed_selections": 171,
                "allowed_selections": [
                  {
                    "uid": "uid8",
                    "name": "name8"
                  }
                ]
              },
              "custom_attribute_usage_count": 7,
              "key": "key9"
            },
            "quick_amounts_settings_data": {
              "option": "DISABLED",
              "eligible_for_auto_amounts": true,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 97,
                  "ordinal": 29
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 98,
                  "ordinal": 30
                },
                {
                  "type": "QUICK_AMOUNT_TYPE_AUTO",
                  "amount": {},
                  "score": 99,
                  "ordinal": 31
                }
              ]
            }
          },
          {
            "type": "CUSTOM_ATTRIBUTE_DEFINITION",
            "id": "id2",
            "updated_at": "updated_at2",
            "version": 206,
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
              "present_at_location_ids2",
              "present_at_location_ids3"
            ],
            "absent_at_location_ids": [
              "absent_at_location_ids3",
              "absent_at_location_ids4",
              "absent_at_location_ids5"
            ],
            "item_data": {
              "name": "name6",
              "description": "description6",
              "abbreviation": "abbreviation8",
              "label_color": "label_color8",
              "available_online": false,
              "available_for_pickup": false,
              "available_electronically": false,
              "category_id": "category_id2",
              "tax_ids": [
                "tax_ids9"
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
                  "item_option_id": "item_option_id5"
                }
              ],
              "image_ids": [
                "image_ids9",
                "image_ids8"
              ],
              "sort_name": "sort_name2",
              "description_html": "description_html6",
              "description_plaintext": "description_plaintext6"
            },
            "category_data": {
              "name": "name6",
              "image_ids": [
                "image_ids1",
                "image_ids2"
              ]
            },
            "item_variation_data": {
              "item_id": "item_id2",
              "name": "name8",
              "sku": "sku6",
              "upc": "upc4",
              "ordinal": 0,
              "pricing_type": "FIXED_PRICING",
              "price_money": {
                "amount": 26,
                "currency": "SAR"
              },
              "location_overrides": [
                {
                  "location_id": "location_id3",
                  "price_money": {
                    "amount": 75,
                    "currency": "SCR"
                  },
                  "pricing_type": "VARIABLE_PRICING",
                  "track_inventory": true,
                  "inventory_alert_type": "LOW_QUANTITY",
                  "inventory_alert_threshold": 195,
                  "sold_out": true,
                  "sold_out_valid_until": "sold_out_valid_until7"
                },
                {
                  "location_id": "location_id4",
                  "price_money": {
                    "amount": 76,
                    "currency": "SDG"
                  },
                  "pricing_type": "FIXED_PRICING",
                  "track_inventory": false,
                  "inventory_alert_type": "NONE",
                  "inventory_alert_threshold": 196,
                  "sold_out": false,
                  "sold_out_valid_until": "sold_out_valid_until8"
                }
              ],
              "track_inventory": false,
              "inventory_alert_type": "NONE",
              "inventory_alert_threshold": 254,
              "user_data": "user_data8",
              "service_duration": 90,
              "available_for_booking": false,
              "item_option_values": [
                {
                  "item_option_id": "item_option_id3",
                  "item_option_value_id": "item_option_value_id9"
                }
              ],
              "measurement_unit_id": "measurement_unit_id2",
              "sellable": false,
              "stockable": false,
              "image_ids": [
                "image_ids7"
              ],
              "team_member_ids": [
                "team_member_ids5"
              ],
              "stockable_conversion": {
                "stockable_item_variation_id": "stockable_item_variation_id4",
                "stockable_quantity": "stockable_quantity8",
                "nonstockable_quantity": "nonstockable_quantity0"
              },
              "item_variation_vendor_info_ids": [
                "item_variation_vendor_info_ids7",
                "item_variation_vendor_info_ids8",
                "item_variation_vendor_info_ids9"
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
              "name": "name4",
              "ordinal": 64,
              "selection_type": "SINGLE",
              "modifiers": [
                {},
                {}
              ],
              "image_ids": [
                "image_ids1",
                "image_ids0"
              ]
            },
            "modifier_data": {
              "name": "name0",
              "price_money": {},
              "ordinal": 42,
              "modifier_list_id": "modifier_list_id6",
              "image_id": "image_id4"
            },
            "time_period_data": {
              "event": "event4"
            },
            "product_set_data": {
              "name": "name0",
              "product_ids_any": [
                "product_ids_any2"
              ],
              "product_ids_all": [
                "product_ids_all1"
              ],
              "quantity_exact": 98,
              "quantity_min": 232,
              "quantity_max": 206,
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
              "name": "name2",
              "url": "url6",
              "caption": "caption6",
              "photo_studio_order_id": "photo_studio_order_id4"
            },
            "measurement_unit_data": {
              "measurement_unit": {
                "custom_unit": {
                  "name": "name2",
                  "abbreviation": "abbreviation4"
                },
                "area_unit": "IMPERIAL_SQUARE_FOOT",
                "length_unit": "METRIC_METER",
                "volume_unit": "GENERIC_FLUID_OUNCE",
                "weight_unit": "IMPERIAL_WEIGHT_OUNCE",
                "generic_unit": "UNIT",
                "time_unit": "GENERIC_HOUR",
                "type": "TYPE_CUSTOM"
              },
              "precision": 182
            },
            "subscription_plan_data": {
              "name": "name8",
              "phases": [
                {
                  "uid": "uid7",
                  "cadence": "EVERY_FOUR_MONTHS",
                  "periods": 205,
                  "recurring_price_money": {},
                  "ordinal": 171
                },
                {
                  "uid": "uid6",
                  "cadence": "EVERY_SIX_MONTHS",
                  "periods": 204,
                  "recurring_price_money": {},
                  "ordinal": 170
                }
              ]
            },
            "item_option_data": {
              "name": "name4",
              "display_name": "display_name4",
              "description": "description6",
              "show_colors": false,
              "values": [
                {},
                {}
              ]
            },
            "item_option_value_data": {
              "item_option_id": "item_option_id4",
              "name": "name2",
              "description": "description2",
              "color": "color6",
              "ordinal": 182
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
                "MODIFIER_LIST",
                "DISCOUNT",
                "TAX"
              ],
              "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
              "app_visibility": "APP_VISIBILITY_READ_ONLY",
              "string_config": {
                "enforce_uniqueness": false
              },
              "number_config": {
                "precision": 224
              },
              "selection_config": {
                "max_allowed_selections": 172,
                "allowed_selections": [
                  {
                    "uid": "uid9",
                    "name": "name9"
                  },
                  {
                    "uid": "uid0",
                    "name": "name0"
                  }
                ]
              },
              "custom_attribute_usage_count": 8,
              "key": "key0"
            },
            "quick_amounts_settings_data": {
              "option": "MANUAL",
              "eligible_for_auto_amounts": false,
              "amounts": [
                {
                  "type": "QUICK_AMOUNT_TYPE_MANUAL",
                  "amount": {},
                  "score": 98,
                  "ordinal": 30
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
          "image_ids1",
          "image_ids0"
        ],
        "sort_name": "sort_name2",
        "description_html": "description_html6",
        "description_plaintext": "description_plaintext6"
      },
      "category_data": {
        "name": "name6",
        "image_ids": [
          "image_ids1"
        ]
      },
      "item_variation_data": {
        "item_id": "item_id2",
        "name": "name8",
        "sku": "sku4",
        "upc": "upc4",
        "ordinal": 152,
        "pricing_type": "FIXED_PRICING",
        "price_money": {},
        "location_overrides": [
          {}
        ],
        "track_inventory": false,
        "inventory_alert_type": "NONE",
        "inventory_alert_threshold": 154,
        "user_data": "user_data8",
        "service_duration": 242,
        "available_for_booking": false,
        "item_option_values": [
          {},
          {}
        ],
        "measurement_unit_id": "measurement_unit_id2",
        "sellable": false,
        "stockable": false,
        "image_ids": [
          "image_ids7",
          "image_ids6",
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
        "name": "name4",
        "ordinal": 168,
        "selection_type": "SINGLE",
        "modifiers": [
          {},
          {},
          {}
        ],
        "image_ids": [
          "image_ids1",
          "image_ids2"
        ]
      },
      "modifier_data": {
        "name": "name0",
        "price_money": {},
        "ordinal": 14,
        "modifier_list_id": "modifier_list_id6",
        "image_id": "image_id4"
      },
      "time_period_data": {
        "event": "event4"
      },
      "product_set_data": {
        "name": "name0",
        "product_ids_any": [
          "product_ids_any4",
          "product_ids_any3",
          "product_ids_any2"
        ],
        "product_ids_all": [
          "product_ids_all3",
          "product_ids_all4",
          "product_ids_all5"
        ],
        "quantity_exact": 250,
        "quantity_min": 128,
        "quantity_max": 102,
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
        "name": "name2",
        "url": "url6",
        "caption": "caption6",
        "photo_studio_order_id": "photo_studio_order_id4"
      },
      "measurement_unit_data": {
        "measurement_unit": {
          "custom_unit": {
            "name": "name2",
            "abbreviation": "abbreviation4"
          },
          "area_unit": "IMPERIAL_SQUARE_FOOT",
          "length_unit": "METRIC_METER",
          "volume_unit": "METRIC_LITER",
          "weight_unit": "IMPERIAL_STONE",
          "generic_unit": "UNIT",
          "time_unit": "GENERIC_MINUTE",
          "type": "TYPE_LENGTH"
        },
        "precision": 30
      },
      "subscription_plan_data": {
        "name": "name8",
        "phases": [
          {},
          {}
        ]
      },
      "item_option_data": {
        "name": "name6",
        "display_name": "display_name6",
        "description": "description4",
        "show_colors": false,
        "values": [
          {},
          {}
        ]
      },
      "item_option_value_data": {
        "item_option_id": "item_option_id4",
        "name": "name2",
        "description": "description2",
        "color": "color6",
        "ordinal": 78
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
          "ITEM_VARIATION",
          "TAX"
        ],
        "seller_visibility": "SELLER_VISIBILITY_HIDDEN",
        "app_visibility": "APP_VISIBILITY_HIDDEN",
        "string_config": {
          "enforce_uniqueness": false
        },
        "number_config": {
          "precision": 72
        },
        "selection_config": {
          "max_allowed_selections": 68,
          "allowed_selections": [
            {}
          ]
        },
        "custom_attribute_usage_count": 160,
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
```

