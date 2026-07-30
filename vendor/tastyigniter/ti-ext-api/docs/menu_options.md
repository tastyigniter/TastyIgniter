## Options

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` options on your TastyIgniter site.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The option object

#### Attributes

| Key                        | Type      | Description                                                                    |
|----------------------------|-----------|--------------------------------------------------------------------------------|
| `option_name`              | `string`  | **Required**. The option's name (between 2 and 255 characters in length)       |
| `display_type`             | `enum`    | **Required**. available options (`checkbox`, `radio`, `select`, `quantity`)    |
| `priority`                 | `integer` | The option's position in the storefront                                        |
| `update_related_menu_item` | `boolean` | Update option values of associated menu items                                  |
| `option_values`            | `array`   | The option's option_value's if any (see [OptionValues](menu_option_values.md)) |


#### Option object example

```json
{
    "option_name": "TestOption",
    "display_type": "checkbox",
    "priority": 0
}
```

### List options

Retrieves a list of options.

Required abilities: `menuoptions:read`

```
GET /api/menu_options
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
            "type": "menuoptions",
            "id": "1",
            "attributes": {
                "option_name": "Toppings",
                "display_type": "checkbox",
                "priority": 0,
                "update_related_menu_item": 0,
                "created_at": "2021-09-21T08:11:55.000000Z",
                "updated_at": "2021-09-21T08:11:55.000000Z"
            },
            "relationships": {
                "option_values": {
                    "data": []
                }
            }
        },
        {
            "type": "options",
            "id": "2",
            "attributes": {
                "option_name": "Sides",
                "display_type": "checkbox",
                "priority": 0,
                "update_related_menu_item": 0,
                "created_at": "2021-09-21T08:11:55.000000Z",
                "updated_at": "2021-09-21T08:11:55.000000Z"
            },
            "relationships": {
                "option_values": {
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
        "self": "https://your.url/api/options?page=1",
        "first": "https://your.url/api/options?page=1",
        "last": "https://your.url/api/options?page=1"
    }
}
```

### Create an option

Creates a new option.

Required abilities: `menuoptions:write`

```
POST /api/menu_options
```

#### Parameters

| Key                        | Type      | Description                                                                                                                                                         |
|----------------------------|-----------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `option_name`              | `string`  | **Required**. The option's name (between 2 and 255 characters in length)                                                                                            |
| `display_type`             | `enum`    | **Required**. available options (`checkbox`, `radio`, `select`, `quantity`)                                                                                         |
| `priority`                 | `integer` | The option's position in the storefront                                                                                                                             |
| `update_related_menu_item` | `boolean` | Update option values of associated menu items                                                                                                                       |
| `option_values`            | `array`   | **Optional**. The option's option_value's if any (see [OptionValues](menu_option_values.md)) **Response id are not set. to retrieve the id(s) perform a get Request |


#### Payload example

```json
{
    "option_name": "Toppings",
    "display_type": "checkbox",
    "priority": 0,
    "update_related_menu_item": 0
}
```

#### Response

```html
Status: 201 Created
```

```json
{
    "data": {
        "type": "menuoptions",
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

### Retrieve an option

Retrieves an option.

Required abilities: `menuoptions:read`

```
GET /api/menu_options/:option_id
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

### Update an option

Updates an option.

Required abilities: `menuoptions:write`

```
PATCH /api/menu_options/:option_id
```

#### Parameters

| Key                        | Type      | Description                                                                                                               |
|----------------------------|-----------|---------------------------------------------------------------------------------------------------------------------------|
| `option_name`              | `string`  | **Required**. The option's name (between 2 and 255 characters in length)                                                  |
| `display_type`             | `enum`    | **Required**. available options (`checkbox`, `radio`, `select`, `quantity`)                                               |
| `priority`                 | `integer` | The option's position in the storefront                                                                                   |
| `update_related_menu_item` | `boolean` | Update option values of associated menu items                                                                             |
| `option_values`            | `array`   | The option's option_value's if any (see [OptionValues](menu_option_values.md)) **new values id(s) are not set in response |


#### Payload example

```json
{
    "option_name": "Chin-Chin",
    "display_type": "radio"
}
```

#### Response

```html
Status: 200 OK
```

```json
{
    "data": {
        "type": "menuoptions",
        "id": "8",
        "attributes": {
            "option_name": "Chin-Chin",
            "display_type": "radio",
            "priority": 0,
            "update_related_menu_item": 0,
            "created_at": "2021-09-27T14:24:00.000000Z",
            "updated_at": "2021-09-28T12:25:37.000000Z"
        },
        "relationships": {
            "option_values": {
                "data": [
                    {
                        "type": "option_values",
                        "id": "44"
                    }
                ]
            }
        }
    },
    "included": [
        {
            "type": "option_values",
            "id": "44",
            "attributes": {
                "option_id": 8,
                "value": "Orange",
                "price": 1.1,
                "priority": 1,
                "currency": "GBP"
            }
        }
    ]
}
```

### Delete a option

Permanently deletes an option. It cannot be undone.

Required abilities: `menuoptions:write`

```
DELETE /api/menu_options/:option_id
```

#### Parameters

No parameters.

#### Response

Returns an 204 No Content.

```html
Status: 204 OK
```

