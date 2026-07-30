## OptionValues

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The option_values object

#### Attributes

| Key                    | Type      | Description                                                    |
|------------------------|-----------|----------------------------------------------------------------|
| `menu_option_value_id` | `integer` | The primary key ID off Menu Item Option Value                  |
| `menu_option_id`       | `integer` | The Menu Item Option ID                                        |
| `option_value_id`      | `integer` | The option_value primary ID                                    |
| `new_price`            | `float`   | The price that difference from the original option_value price |
| `priority`             | `integer` | The currency off the price as code **SET Automatically**       |
| `is_default`           | `boolean` | The default selected Option                                    |
| `stocks`               | `array`   | The stocks, if any                                             |

#### Option_value object example

```json
{
    "menu_option_value_id": 42,
    "menu_option_id": 13,
    "option_value_id": 5,
    "new_price": 1.5,
    "priority": 1,
    "is_default": true,
    "stocks": []
}
```

### Create/Update an option

Creates a new option.

Required abilities: `menu_item_options:write`
  
Relations and IDs are automatically set.

** menu_item_options_values are not appended. the state in the json array will be the state on the website. previous menu_item_options_value(s) will be deleted. to add an item to an existing one `option_value_id` && `menu_option_value_id` are mandatory. 

#### Payload example

```json
{
    "option_id": 4,
    "menu_id": 2,
    "required": false,
    "priority": 0,
    "min_selected": 0,
    "max_selected": 4,
    "menu_option_values": [
        {
            "menu_option_value_id": 42,
            "menu_option_id": 13,
            "option_value_id": 5,
            "new_price": 1.6,
            "quantity": 0,
            "subtract_stock": 0,
            "priority": 1,
            "is_default": true
        }
    ]
}
```

#### Response

```html
Status: 201 Created
```

```json
{
    "data": {
        "type": "menuitemoptions",
        "id": "13",
        "attributes": {
            "menu_option_id": 13,
            "option_id": 4,
            "menu_id": 2,
            "required": false,
            "priority": 0,
            "min_selected": 0,
            "max_selected": 4,
            "created_at": null,
            "updated_at": null,
            "option_name": "Drinks",
            "display_type": "checkbox",
            "option": {
                "option_id": 4,
                "option_name": "Drinks",
                "display_type": "checkbox",
                "priority": 0,
                "update_related_menu_item": 0,
                "created_at": "2021-09-21T08:11:55.000000Z",
                "updated_at": "2021-09-21T08:11:55.000000Z"
            }
        },
        "relationships": {
            "menu_option_values": {
                "data": []
            }
        }
    },
    "included": [
        {
            "type": "menu_option_values",
            "id": "42",
            "attributes": {
                "menu_option_id": 13,
                "option_value_id": 5,
                "new_price": 1.6,
                "quantity": 0,
                "subtract_stock": 0,
                "priority": 1,
                "is_default": true,
                "currency": "GBP"
            }
        }
    ]
}
```
