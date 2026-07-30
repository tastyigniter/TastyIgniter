## Location Settings

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` location settings on your TastyIgniter site.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The location setting object

#### Attributes

| Key           | Type     | Description                                                                 |
|---------------|----------|-----------------------------------------------------------------------------|
| `location_id` | `integer` | **Required**. The ID of the location this setting belongs to              |
| `item`        | `string`  | **Required**. The setting item/key identifier                               |
| `data`        | `array`   | **Required**. The setting data/value as an array                            |

#### Location setting object example

```json
{
  "id": 1,
  "location_id": 1,
  "item": "delivery_settings",
  "data": {
    "enabled": true,
    "minimum_order": 10.00,
    "delivery_fee": 2.50
  }
}
```

### List location settings

Retrieves a list of location settings.

Required abilities: `location_settings:read`

```
GET /api/location_settings
```

#### Parameters

| Key         | Type      | Description                        |
|-------------|-----------|------------------------------------|
| `page`      | `integer` | The page number.                   |
| `pageLimit` | `integer` | The number of items per page.      |
| `location_id` | `integer` | Filter settings by location ID.    |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "location_settings",
            "id": "1",
            "attributes": {
                "location_id": 1,
                "item": "delivery_settings",
                "data": {
                    "enabled": true,
                    "minimum_order": 10.00,
                    "delivery_fee": 2.50
                }
            }
        },
        {
            "type": "location_settings",
            "id": "2",
            "attributes": {
                "location_id": 1,
                "item": "payment_settings",
                "data": {
                    "cash_enabled": true,
                    "card_enabled": true,
                    "online_payment_enabled": false
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
        "self": "https://your.url/api/location_settings?page=1",
        "first": "https://your.url/api/location_settings?page=1",
        "last": "https://your.url/api/location_settings?page=1"
    }
}
```

### Create a location setting

Creates a new location setting.

Required abilities: `location_settings:write`

```
POST /api/location_settings
```

#### Parameters

| Key          | Type     | Description                                                                 |
|--------------|----------|-----------------------------------------------------------------------------|
| `location_id` | `integer` | **Required**. The ID of the location this setting belongs to              |
| `item`       | `string`  | **Required**. The setting item/key identifier                               |
| `data`       | `array`   | **Required**. The setting data/value as an array                            |

#### Payload example

```json
{
  "location_id": 1,
  "item": "delivery_settings",
  "data": {
    "enabled": true,
    "minimum_order": 10.00,
    "delivery_fee": 2.50,
    "free_delivery_threshold": 25.00
  }
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
      "type": "location_settings",
      "id": "1",
      "attributes": {
        "location_id": 1,
        "item": "delivery_settings",
        "data": {
          "enabled": true,
          "minimum_order": 10.00,
          "delivery_fee": 2.50,
          "free_delivery_threshold": 25.00
        }
      }
    }
  ]
}
```

### Retrieve a location setting

Retrieves a specific location setting.

Required abilities: `location_settings:read`

```
GET /api/location_settings/:id
```

#### Parameters

No query parameters.

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "location_settings",
            "id": "1",
            "attributes": {
                "location_id": 1,
                "item": "delivery_settings",
                "data": {
                    "enabled": true,
                    "minimum_order": 10.00,
                    "delivery_fee": 2.50,
                    "free_delivery_threshold": 25.00
                }
            }
        }
    ],
    "included": []
}
```

### Update a location setting

Updates a location setting.

Required abilities: `location_settings:write`

```
PATCH /api/location_settings/:id
```

#### Parameters

| Key          | Type     | Description                                                                 |
|--------------|----------|-----------------------------------------------------------------------------|
| `location_id` | `integer` | **Required**. The ID of the location this setting belongs to              |
| `item`       | `string`  | **Required**. The setting item/key identifier                               |
| `data`       | `array`   | **Required**. The setting data/value as an array                            |

#### Payload example

```json
{
    "location_id": 1,
    "item": "delivery_settings",
    "data": {
        "enabled": true,
        "minimum_order": 15.00,
        "delivery_fee": 3.00,
        "free_delivery_threshold": 30.00
    }
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
            "type": "location_settings",
            "id": "1",
            "attributes": {
                "location_id": 1,
                "item": "delivery_settings",
                "data": {
                    "enabled": true,
                    "minimum_order": 15.00,
                    "delivery_fee": 3.00,
                    "free_delivery_threshold": 30.00
                }
            }
        }
    ]
}
```

### Delete a location setting

Permanently deletes a location setting. It cannot be undone.

Required abilities: `location_settings:write`

```
DELETE /api/location_settings/:id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the location setting ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
    "id": 1,
    "object": "location_setting",
    "deleted": true
}
```
