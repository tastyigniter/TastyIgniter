## Options

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` menu item options on your TastyIgniter site.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The option object

#### Attributes

| Key                    | Type      | Description                                                                                 |
|------------------------|-----------|---------------------------------------------------------------------------------------------|
| `menu_option_id`       | `integer` | ID of the menu item option                                                                  |
| `menu_id`              | `integer` | **Required** ID of the menu                                                                 |
| `option_id`            | `integer` | **Required** ID of the menu_option                                                          |
| `priority`             | `integer` | Placement in the storefront                                                                 |
| `required`             | `boolean` | Menu Item Option is required to be selected                                                 |
| `min_selected`         | `integer` | Minimum selected of the menu_option, must be smaller than max_selected                      |
| `max_selected`         | `integer` | Maximum selected of the menu_option, must be larger than min_selected                       |
| `option_name`          | `string`  | Menu item option name, read only see (see [MenuOptions](menu_options.md))                   |
| `display_type`         | `srting`  | Menu item option display type, read only (see [MenuOptions](menu_options.md))               |
| `created_at`           | `date`    | Date ISO 8601 format of when the menu item option was created                               |
| `updated_at`           | `date`    | Date ISO 8601 format of when the menu item option was updated                               |
| `menu_option_values.*` | `array`   | Json array with the menu_option_values (see [MenuOptionValues](menu_item_option_values.md)) |
| `option`               | `object`  | Json Object of menu_option (see [MenuOptions](menu_options.md))                             |

#### Option object example

```json
{
    "menu_option_id": 2,
    "option_id": 3,
    "menu_id": 2,
    "required": false,
    "priority": 0,
    "min_selected": 0,
    "max_selected": 0,
    "created_at": "2021-09-21 09:11:55",
    "updated_at": "2021-09-21 09:11:55",
    "option_name": "Size",
    "display_type": "radio",
    "option": {
        "option_id": 3,
        "option_name": "Size",
        "display_type": "radio",
        "priority": 0,
        "update_related_menu_item": 0,
        "created_at": "2021-09-21T08:11:55.000000Z",
        "updated_at": "2021-09-21T08:11:55.000000Z"
    }
}
```

### List menu item options

Retrieves a list of menu item options.

Required abilities: `menu_item_options:read`

```
GET /api/menu_item_options
```

#### Parameters

| Key         | Type      | Description                   |
|-------------|-----------|-------------------------------|
| `page`      | `integer` | The page number.              |
| `pageLimit` | `integer` | The number of items per page. |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "menuitemoptions",
            "id": "2",
            "attributes": {
                "menu_option_id": 2,
                "option_id": 3,
                "menu_id": 2,
                "required": false,
                "priority": 0,
                "min_selected": 0,
                "max_selected": 0,
                "created_at": "2021-09-21 09:11:55",
                "updated_at": "2021-09-21 09:11:55",
                "option_name": "Size",
                "display_type": "radio",
                "option": {
                    "option_id": 3,
                    "option_name": "Size",
                    "display_type": "radio",
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
        {
            "type": "menuitemoptions",
            "id": "3",
            "attributes": {
                "menu_option_id": 3,
                "option_id": 2,
                "menu_id": 3,
                "required": false,
                "priority": 0,
                "min_selected": 0,
                "max_selected": 0,
                "created_at": "2021-09-21 09:11:55",
                "updated_at": "2021-09-21 09:11:55",
                "option_name": "Sides",
                "display_type": "checkbox",
                "option": {
                    "option_id": 2,
                    "option_name": "Sides",
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
        }
    ],
    "included": [],
    "meta": {
        "pagination": {
            "total": 10,
            "count": 2,
            "per_page": 2,
            "current_page": 1,
            "total_pages": 5
        }
    },
    "links": {
        "self": "http://localhost/api/menu_item_options?page=1",
        "first": "http://localhost/api/menu_item_options?page=1",
        "next": "http://localhost/api/menu_item_options?page=2",
        "last": "http://localhost/api/menu_item_options?page=5"
    }
}
```

### Create a menu item option

Creates a new menu item option.

Required abilities: `menu_item_options:write`

```
POST /api/menu_item_options
```

#### Parameters

| Key                  | Type      | Description                                                                                                                                                                                  |
|----------------------|-----------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `menu_id`            | `integer` | **Required** ID of the menu                                                                                                                                                                  |
| `option_id`          | `integer` | **Required** ID of the menu_option                                                                                                                                                           |
| `priority`           | `integer` | Placement in the storefront                                                                                                                                                                  |
| `required`           | `boolean` | Menu Item Option is required to be selected                                                                                                                                                  |
| `min_selected`       | `integer` | Minimum selected of the menu_option, must be smaller than max_selected                                                                                                                       |
| `max_selected`       | `integer` | Maximum selected of the menu_option, must be larger than min_selected                                                                                                                        |
| `menu_option_values` | `array`   | **Optional**. The menu item option\`s option_value\`s if any (see [MenuItemOptionValues](menu_item_option_values.md)) **Response id are not set. to retrieve the id(s) perform a get Request |


#### Payload example

```json
{
    "option_id": 4,
    "menu_id": 2,
    "required": false,
    "priority": 0,
    "min_selected": 1,
    "max_selected": 4,
    "menu_option_values": [
        {
            "option_value_id": 5,
            "new_price": 1,
            "quantity": 0,
            "subtract_stock": 0,
            "priority": 1,
            "is_default": true
        },
        {
            "option_value_id": 6,
            "new_price": 2,
            "quantity": 0,
            "subtract_stock": 0,
            "priority": 2
        },
        {
            "option_value_id": 7,
            "new_price": 3,
            "quantity": 0,
            "subtract_stock": 0,
            "priority": 3
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
            "menu_id": 2,
            "option_id": 4,
            "priority": 0,
            "required": false,
            "min_selected": 1,
            "max_selected": 4,
            "menu_option_id": 13,
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
    }
}
```

### Retrieve a menu item option

Retrieves a menu item option.

Required abilities: `menu_item_options:read`

```
GET /api/menu_item_options/:menu_item_option_id
```

#### Response

```html
Status: 200 OK
```

```json
{
    "data": {
        "type": "menuoptions",
        "id": "9",
        "attributes": {
            "option_name": "Toppings",
            "display_type": "checkbox",
            "priority": 0,
            "update_related_menu_item": 0,
            "created_at": "2021-09-28T11:46:50.000000Z",
            "updated_at": "2021-09-28T11:46:50.000000Z"
        },
        "relationships": {
            "option_values": {
                "data": []
            }
        }
    },
    "included": []
}
```

### Update a menu item option

Updates a menu item option.

Required abilities: `menu_item_options:write`

```
PATCH /api/menu_item_options/:menu_item_option_id
```

#### Parameters

| Key                  | Type      | Description                                                                                                                                                                                  |
|----------------------|-----------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `menu_id`            | `integer` | **Required** ID of the menu                                                                                                                                                                  |
| `option_id`          | `integer` | **Required** ID of the menu_option                                                                                                                                                           |
| `priority`           | `integer` | Placement in the storefront                                                                                                                                                                  |
| `required`           | `boolean` | Menu Item Option is required to be selected                                                                                                                                                  |
| `min_selected`       | `integer` | Minimum selected of the menu_option, must be smaller than max_selected                                                                                                                       |
| `max_selected`       | `integer` | Maximum selected of the menu_option, must be larger than min_selected                                                                                                                        |
| `menu_option_values` | `array`   | **Optional**. The menu item option\`s option_value\`s if any (see [MenuItemOptionValues](menu_item_option_values.md)) **Response id are not set. to retrieve the id(s) perform a get Request |


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
        },
        {
            "menu_option_value_id": 43,
            "menu_option_id": 13,
            "option_value_id": 6,
            "new_price": 3,
            "quantity": 0,
            "subtract_stock": 0,
            "priority": 2
        },
        {
            "menu_option_value_id": 44,
            "menu_option_id": 13,
            "option_value_id": 7,
            "new_price": 6,
            "quantity": 0,
            "subtract_stock": 0,
            "priority": 3
        }
    ]
}
```

#### Response

```html
Status: 200 OK
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
                "subtract_stock": null,
                "priority": 1,
                "is_default": true,
                "created_at": null,
                "updated_at": null,
                "name": "Fish",
                "price": 1.6,
                "option_value": {
                    "option_value_id": 5,
                    "option_id": 2,
                    "value": "Fish",
                    "price": 4.95,
                    "priority": 2
                },
                "currency": "GBP"
            }
        }
    ]
}
```

### Delete a option

Permanently deletes a menu item option. It cannot be undone.

Required abilities: `menu_item_options:write`

```
DELETE /api/menu_item_options/:menu_item_option_id
```

#### Parameters

No parameters.

#### Response

Returns an 204 No Content.

```html
Status: 204 OK
```

