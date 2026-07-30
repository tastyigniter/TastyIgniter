## Menus

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` menus on your TastyIgniter site.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The menu object

#### Attributes

| Key                 | Type      | Description                                                                                                                                                                                                                   |
|---------------------|-----------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `menu_name`         | `string`  | **Required**. The menu's name (between 2 and 255 characters in length)                                                                                                                                                        |
| `menu_description`  | `text`    | A short description of the menu (between 2 and 1028 characters in length)                                                                                                                                                     |
| `menu_price`        | `float`   | **Required**. The menu's price                                                                                                                                                                                                |
| `minimum_qty`       | `integer` | The minimum quantity required to order.                                                                                                                                                                                       |
| `menu_status`       | `boolean` | Has the value `true` if the menu is enabled or the value `false` if the menu is disabled.                                                                                                                                     |
| `menu_priority`     | `integer` | The menu's ordering priority.                                                                                                                                                                                                 |
| `order_restriction` | `string`  | Has the value `delivery` if the menu is only available for delivery orders, the value `collection` if the menu is only available for pick-up orders, or the value `0` if the menu is available for both pick-up and delivery. |
| `categories`        | `array`   | The menu's categories, if any (see [Categories](locations.md))                                                                                                                                                                |
| `menu_options`      | `array`   | The menu's options, if any                                                                                                                                                                                                    |
| `mealtimes`         | `array`   | The menu's mealtimes, if any                                                                                                                                                                                                  |
| `stocks`            | `array`   | The menu's stocks, if any                                                                                                                                                                                                     |
| `locations`         | `array`   | The menu's locations, if any                                                                                                                                                                                                  |

#### Menu object example

```json
{
    "menu_id": 1,
    "menu_name": "Puff-Puff",
    "menu_description": "Traditional Nigerian donut ball, rolled in sugar",
    "menu_price": "4.99",
    "currency": "GBP",
    "minimum_qty": 3,
    "menu_status": true,
    "menu_priority": 0,
    "order_restriction": null,
    "categories": [],
    "stocks": [],
    "mealtimes": [],
    "locations": [],
    "menu_options": [
        {
            "menu_option_id": 1,
            "option_id": 4,
            "menu_id": 1,
            "required": false,
            "priority": 0,
            "min_selected": 0,
            "max_selected": 0,
            "option_name": "Drinks",
            "display_type": "checkbox",
            "option": {
                "option_id": 4,
                "option_name": "Drinks",
                "display_type": "checkbox",
                "priority": 0
            },
            "menu_option_values": [
                {
                    "menu_option_value_id": 1,
                    "menu_option_id": 1,
                    "option_value_id": 9,
                    "new_price": "0",
                    "quantity": 0,
                    "subtract_stock": 0,
                    "priority": 1,
                    "is_default": null,
                    "name": "Coke",
                    "price": "0",
                    "currency": "GBP",
                    "option_value": {
                        "option_value_id": 9,
                        "option_id": 4,
                        "value": "Coke",
                        "price": "0",
                        "currency": "GBP",
                        "priority": 1
                    }
                }
            ]
        }
    ]
}
```

### List menus

Retrieves a list of menus.

Required abilities: `menus:read`

```
GET /api/menus
```

#### Parameters

| Key         | Type      | Description                                                                                                                                                                                        |
|-------------|-----------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `page`      | `integer` | The page number.                                                                                                                                                                                   |
| `pageLimit` | `integer` | The number of items per page.                                                                                                                                                                      |
| `enabled`   | `boolean` | If true only menu items that are enabled will be returned                                                                                                                                          |
| `location`  | `integer` | The id of the location you wan to return menu items for                                                                                                                                            |
| `category`  | `string`  | The slug of the category you wan to return menu items for                                                                                                                                          |
| `search`    | `string`  | The phrase to search for in the menu item name and description                                                                                                                                     |
| `include`   | `string`  | What relations to include in the response. Options are `media`, `categories`, `mealtimes`, `stocks`, `menu_options`. To include multiple separate by comma (e.g. ?include=categories,menu_options) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "menus",
            "id": "1",
            "attributes": {
                "menu_name": "Puff-Puff",
                "menu_description": "Traditional Nigerian donut ball, rolled in sugar",
                "menu_price": "4.99",
                "currency": "GBP",
                "minimum_qty": 3,
                "menu_status": true,
                "menu_priority": 0,
                "order_restriction": null,
                "media": [],
                "categories": [],
                "menu_options": [],
                "mealtimes": [],
                "stocks": [],
                "locations": []
            },
            "relationships": {
                "categories": {
                    "data": []
                },
                "menu_options": {
                    "data": []
                },
                "mealtimes": {
                    "data": []
                },
                "stocks": {
                    "data": []
                },
                "locations": {
                    "data": []
                }
            }
        },
        {
            "type": "menus",
            "id": "2",
            "attributes": {
                "menu_name": "Doughnut",
                "menu_description": "Deep fried from a flour dough with sweet fillings",
                "menu_price": "0.99",
                "currency": "GBP",
                "minimum_qty": 1,
                "menu_status": true,
                "menu_priority": 0,
                "order_restriction": null,
                "media": [],
                "categories": [],
                "menu_options": [],
                "mealtimes": [],
                "stocks": [],
                "locations": []
            },
            "relationships": {
                "categories": {
                    "data": []
                },
                "menu_options": {
                    "data": []
                },
                "mealtimes": {
                    "data": []
                },
                "stocks": {
                    "data": []
                },
                "locations": {
                    "data": []
                }
            }
        }
    ],
    "included": [],
    "meta": {
        "pagination": {
            "total": 2,
            "count": 2,
            "per_page": 20,
            "current_page": 1,
            "total_pages": 1
        }
    },
    "links": {
        "self": "https://your.url/api/menus?page=1",
        "first": "https://your.url/api/menus?page=1",
        "last": "https://your.url/api/menus?page=1"
    }
}
```

### Create a menu

Creates a new menu.

Required abilities: `menus:write`

```
POST /api/menus
```

#### Parameters

| Key                 | Type      | Description                                                                                                                                                                                                                   |
|---------------------|-----------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `menu_name`         | `string`  | **Required**. The menu's name (between 2 and 255 characters in length)                                                                                                                                                        |
| `menu_description`  | `text`    | A short description of the menu (between 2 and 1028 characters in length)                                                                                                                                                     |
| `menu_price`        | `float`   | **Required**. The menu's price                                                                                                                                                                                                |
| `minimum_qty`       | `integer` | The minimum quantity required to order.                                                                                                                                                                                       |
| `menu_status`       | `boolean` | Has the value `true` if the menu is enabled or the value `false` if the menu is disabled.                                                                                                                                     |
| `menu_priority`     | `integer` | The menu's ordering priority.                                                                                                                                                                                                 |
| `order_restriction` | `string`  | Has the value `delivery` if the menu is only available for delivery orders, the value `collection` if the menu is only available for pick-up orders, or the value `0` if the menu is available for both pick-up and delivery. |
| `categories`        | `array`   | The menu's categories, if any (see [Categories](locations.md))                                                                                                                                                                |
| `menu_options`      | `array`   | The menu's options, if any                                                                                                                                                                                                    |
| `mealtimes`         | `array`   | The mealtime's options, if any                                                                                                                                                                                                |
| `stocks`            | `array`   | The stock's options, if any                                                                                                                                                                                                   |
| `locations`         | `array`   | The location's options, if any                                                                                                                                                                                                |

#### Payload example

```json
{
    "menu_name": "Chin-Chin",
    "menu_price": 1.99,
    "order_restriction": null
}
```

#### Response

```html
Status: 201 Created
```

```json
{
    "data": [
        {
            "type": "menus",
            "id": "1",
            "attributes": {
                "menu_name": "Puff-Puff",
                "menu_description": "Traditional Nigerian donut ball, rolled in sugar",
                "menu_price": "4.99",
                "currency": "GBP",
                "minimum_qty": 3,
                "menu_status": true,
                "menu_priority": 0,
                "order_restriction": null
            }
        }
    ]
}
```

### Retrieve a menu

Retrieves a menu.

Required abilities: `menus:read`

```
GET /api/menus/:menu_id
```

#### Parameters

| Key       | Type     | Description                                                                                                                                                                                                     |
|-----------|----------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `include` | `string` | What relations to include in the response. Options are `media`, `mealtimes`, `categories`, `menu_options`, `stocks`, `locations`. To include multiple separate by comma (e.g. ?include=categories,menu_options) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "menus",
            "id": "1",
            "attributes": {
                "menu_name": "Puff-Puff",
                "menu_description": "Traditional Nigerian donut ball, rolled in sugar",
                "menu_price": "4.99",
                "currency": "GBP",
                "minimum_qty": 3,
                "menu_status": true,
                "menu_priority": 0,
                "order_restriction": null,
                "media": [],
                "categories": [],
                "menu_options": [],
                "mealtimes": [],
                "stocks": [],
                "locations": []
            },
            "relationships": {
                "categories": {
                    "data": []
                },
                "menu_options": {
                    "data": []
                },
                "mealtimes": {
                    "data": []
                },
                "stocks": {
                    "data": []
                },
                "locations": {
                    "data": []
                }
            }
        }
    ],
    "included": []
}
```

### Update a menu

Updates a menu.

Required abilities: `menus:write`

```
PATCH /api/menus/:menu_id
```

#### Parameters

| Key                 | Type      | Description                                                                                                                                                                                                                   |
|---------------------|-----------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `menu_name`         | `string`  | **Required**. The menu's name (between 2 and 255 characters in length)                                                                                                                                                        |
| `menu_description`  | `text`    | A short description of the menu (between 2 and 1028 characters in length)                                                                                                                                                     |
| `menu_price`        | `float`   | **Required**. The menu's price                                                                                                                                                                                                |
| `minimum_qty`       | `integer` | The minimum quantity required to order.                                                                                                                                                                                       |
| `menu_status`       | `boolean` | Has the value `true` if the menu is enabled or the value `false` if the menu is disabled.                                                                                                                                     |
| `menu_priority`     | `integer` | The menu's priority.                                                                                                                                                                                                          |
| `order_restriction` | `string`  | Has the value `delivery` if the menu is only available for delivery orders, the value `collection` if the menu is only available for pick-up orders, or the value `0` if the menu is available for both pick-up and delivery. |
| `categories`        | `array`   | The menu's categories, if any (see [Categories](locations.md))                                                                                                                                                                |
| `menu_options`      | `array`   | The menu's options, if any                                                                                                                                                                                                    |
| `mealtimes`         | `array`   | The mealtime's options, if any                                                                                                                                                                                                |
| `stocks`            | `array`   | The stock's options, if any                                                                                                                                                                                                   |
| `locations`         | `array`   | The location's options, if any                                                                                                                                                                                                |

#### Payload example

```json
{
    "name": "Chin-Chin",
    "menu_status": false
}
```

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "menus",
            "id": "1",
            "attributes": {
                "menu_name": "Chin-Chin",
                "menu_description": "Traditional Nigerian donut ball, rolled in sugar",
                "menu_price": "4.99",
                "currency": "GBP",
                "minimum_qty": 3,
                "menu_status": false,
                "menu_priority": 0,
                "order_restriction": null
            }
        }
    ]
}
```

### Delete a menu

Permanently deletes a menu. It cannot be undone.

Required abilities: `menus:write`

```
DELETE /api/menus/:menu_id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the menu ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
    "id": 1,
    "object": "menu",
    "deleted": true
}
```
