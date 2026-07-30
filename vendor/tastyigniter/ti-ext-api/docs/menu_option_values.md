## OptionValues

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The option_values object

#### Attributes

| Key               | Type      | Description                                                      |
|-------------------|-----------|------------------------------------------------------------------|
| `option_value_id` | `integer` | The option_value primary ID                                      |
| `option_id`       | `integer` | The option primary ID                                            |
| `value`           | `string`  | The option_value's name (between 2 and 255 characters in length) |
| `price`           | `double`  | The price of the option_value default 0                          |
| `currency`        | `String`  | The currency off the price as code **SET Automatically**         |


#### Option_value object example

```json
{
    "type": "option_values",
    "id": "2",
    "attributes": {
        "option_id": 1,
        "value": "Jalapenos",
        "price": 3.99,
        "priority": 1,
        "currency": "GBP"
    }
}
```

### Create/Update an option

Creates a new option.

Required abilities: `options:write`
  
Relations and IDs are automatically set.

** option_value items are not appended. the state in the json array will be the state on the website. previous option_value(s) will be deleted. to add an option to an existing one `option_value_id` && `option_id` are mandatory. 

#### Payload example

```json
{
    "option_name": "Toppings",
    "display_type": "checkbox",
    "priority": 0,
    "update_related_menu_item": 0,
    "option_values": [
        {
            "option_value_id": 2,
            "option_id": 1,
            "value": "Peperoni",
            "price": 1.99,
            "priority": 2
        },
        {
            "value": "Jalapenos",
            "price": 3.99,
            "priority": 1
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
        "type": "options",
        "id": "9",
        "attributes": {
            "option_name": "Toppings",
            "display_type": "checkbox",
            "updated_at": "2021-09-28T11:46:50.000000Z",
            "created_at": "2021-09-28T11:46:50.000000Z"
        },
        "relationships": {
            "option_values": {
                "data": [
                    {
                        "type": "option_values",
                        "id": ""
                    },
                    {
                        "type": "option_values",
                        "id": ""
                    }
                ]
            }
        }
    },
    "included": [
        {
            "type": "option_values",
            "id": "",
            "attributes": {
                "value": "Peperoni",
                "price": 1.99,
                "priority": 2,
                "currency": "GBP"
            }
        }
    ]
}
```
