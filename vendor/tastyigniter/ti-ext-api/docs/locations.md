## Locations

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` locations on your TastyIgniter site.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The location object

#### Attributes

| Key                                                                                                                        | Type               | Description                                                                                                     |
|----------------------------------------------------------------------------------------------------------------------------|--------------------|-----------------------------------------------------------------------------------------------------------------|
| `location_name`                                                                                                            | `string`           | **                                                                                                              |
| Required**. The location's name (between 2 and 48 characters in length)                                                    |                    |                                                                                                                 |
| `location_email`                                                                                                           | `string`           | **Required**. The location's email address                                                                      |
| `location_telephone`                                                                                                       | `string`           | The location's telephone number (between 2 and 15 characters in length)                                         |
| `location_address_1`                                                                                                       | `string`           | **                                                                                                              |
| Required**. The first line of the location's physical address (between 2 and 128 characters)                               |                    |                                                                                                                 |
| `location_address_2`                                                                                                       | `string`           | The second line of the location's physical address (maximum 128 characters)                                     |
| `location_city`                                                                                                            | `string`           | The city in which the location is situated  (maximum 128 characters)                                            |
| `location_state`                                                                                                           | `string`           | The state or county in which the location is situated  (maximum 128 characters)                                 |
| `location_postcode`                                                                                                        | `string`           | The postal or ZIP code of the location (maximum 10 characters)                                                  |
| `location_country_id`                                                                                                      | `integer`          | **                                                                                                              |
| Required**. The country code of the location's physical address. Should reference an id in the "countries" database table. |                    |                                                                                                                 |
| `location_lat`                                                                                                             | `decimal`          | The latitude of the location                                                                                    |
| `location_lng`                                                                                                             | `decimal`          | The longitude of the location                                                                                   |
| `description`                                                                                                              | `string`           | A description of the location to display to users (maximum of 3028 characters)                                  |
| `options`                                                                                                                  | `object`           | An object containing additional meta information about the location                                             |
| `options.offer_delivery`                                                                                                   | `boolean`          | Has the value `true` if the location offers delivery or the value `false` if the location does not.             |
| `options.offer_collection`                                                                                                 | `boolean`          | Has the value `true` if the location offers collection or the value `false` if the location does not.           |
| `options.delivery_time_interval`                                                                                           | `integer`          | The minutes between each delivery order time available to your customer                                         |
| `options.collection_time_interval`                                                                                         | `integer`          | The minutes between each pick-up order time available to your customer                                          |
| `options.delivery_lead_time`                                                                                               | `integer`          | The average time in minutes it takes an order to be delivered after being placed                                |
| `options.collection_lead_time`                                                                                             | `integer`          | The average time in minutes it takes an order to be available for collection after being placed                 |
| `options.reservation_time_interval`                                                                                        | `integer`          | The number of minutes between each reservation time                                                             |
| `options.reservation_stay_time`                                                                                            | `integer`          | The average time in minutes a guest will stay at a table                                                        |
| `location_status`                                                                                                          | `boolean`          | Has the value `true` if the location is enabled or the value `false` if the location is disabled.               |
| `permalink_slug`                                                                                                           | `string`           | The URL slug for this location. Use only alpha-numeric lowercase characters, _ or - and make sure it is unique. |
| `location_thumb`                                                                                                           | `string` or `null` | The thumbnail image of the location (if available)                                                              |
| `location_image`                                                                                                           | `string` or `null` | An image of the location (if available)                                                                         |
| `media`                                                                                                                    | `array`            | An array of media associated with the location (if available)                                                   |

#### Location object example

```json
{
  "location_id": 1,
  "location_name": "My restaurant",
  "location_email": "restaurant@bloggs.com",
  "description": "My TastyIgniter restaurant",
  "location_address_1": "1 Some Street",
  "location_address_2": "",
  "location_city": "London",
  "location_state": "London",
  "location_postcode": "WA4 3NN",
  "location_country_id": 222,
  "location_telephone": "1234512345",
  "location_lat": 50.6008818,
  "location_lng": -6.8794655,
  "location_status": true,
  "permalink_slug": "my-restaurant",
  "options": {
    "offer_delivery": false,
    "offer_collection": true,
    "delivery_time_interval": 15,
    "collection_time_interval": 15,
    "delivery_lead_time": 15,
    "collection_lead_time": 15,
    "reservation_time_interval": 15,
    "reservation_lead_time": 45,
    "payments": [],
    "gallery": {}
  },
  "media": []
}
```

### List locations

Retrieves a list of locations.

Required abilities: `locations:read`

```
GET /api/locations
```

#### Parameters

| Key         | Type      | Description                                                                                                                                                                              |
|-------------|-----------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `page`      | `integer` | The page number.                                                                                                                                                                         |
| `pageLimit` | `integer` | The number of items per page.                                                                                                                                                            |
| `sort`      | `string`  | The order to return results in. Possible values are `distance asc`, `distance desc`, `location_id asc`, `location_id desc`, `location_name asc`, `location_name desc`                    |
| `latitude`  | `string`  | The latitude you want to search for a location around                                                                                                                                    |
| `longitude` | `string`  | The longitude you want to search for a location around                                                                                                                                   |
| `search`    | `string`  | The phrase to search for in the location name, address and description                                                                                                                   |
| `include`   | `string`  | What relations to include in the response. Options are `media`, `working_hours`, `delivery_areas`, `reviews`. To include multiple separate by comma (e.g. ?include= working_hours,media) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "locations",
            "id": "1",
            "attributes": {
                "location_name": "My restaurant",
                "location_email": "restaurant@bloggs.com",
                "description": "My TastyIgniter restaurant",
                "location_address_1": "1 Some Street",
                "location_address_2": "",
                "location_city": "London",
                "location_state": "London",
                "location_postcode": "WA4 3NN",
                "location_country_id": 222,
                "location_telephone": "1234512345",
                "location_lat": 50.6008818,
                "location_lng": -6.8794655,
                "location_status": true,
                "permalink_slug": "my-restaurant",
                "media": [],
                "working_hours": [],
                "delivery_areas": [],
                "reviews": []
            },
            "relationships": {
                "working_hours": {
                    "data": []
                },
                "delivery_areas": {
                    "data": []
                },
                "reviews": {
                    "data": []
                }
            }
        },
        {
            "type": "locations",
            "id": "2",
            "attributes": {
                "location_name": "My other restaurant",
                "location_email": "other.restaurant@bloggs.com",
                "description": "My second TastyIgniter restaurant",
                "location_address_1": "1 Another Street",
                "location_address_2": "",
                "location_city": "London",
                "location_state": "London",
                "location_postcode": "WA3 1NA",
                "location_country_id": 222,
                "location_telephone": "1234512345",
                "location_lat": 50.6108818,
                "location_lng": -6.8994655,
                "location_status": true,
                "permalink_slug": "my-other-restaurant",
                "media": [],
                "working_hours": [],
                "delivery_areas": [],
                "reviews": []
            },
            "relationships": {
                "working_hours": {
                    "data": []
                },
                "delivery_areas": {
                    "data": []
                },
                "reviews": {
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
        "self": "https://your.url/api/locations?page=1",
        "first": "https://your.url/api/locations?page=1",
        "last": "https://your.url/api/locations?page=1"
    }
}
```

### Create a location

Creates a new location.

Required abilities: `locations:write`

```
POST /api/location
```

#### Parameters

| Key                                                                                                                        | Type      | Description                                                                                                     |
|----------------------------------------------------------------------------------------------------------------------------|-----------|-----------------------------------------------------------------------------------------------------------------|
| `location_name`                                                                                                            | `string`  | **                                                                                                              |
| Required**. The location's name (between 2 and 48 characters in length)                                                    |           |                                                                                                                 |
| `location_email`                                                                                                           | `string`  | **Required**. The location's email address                                                                      |
| `location_telephone`                                                                                                       | `string`  | The location's telephone number (between 2 and 15 characters in length)                                         |
| `location_address_1`                                                                                                       | `string`  | **                                                                                                              |
| Required**. The first line of the location's physical address (between 2 and 128 characters)                               |           |                                                                                                                 |
| `location_address_2`                                                                                                       | `string`  | The second line of the location's physical address (maximum 128 characters)                                     |
| `location_city`                                                                                                            | `string`  | The city in which the location is situated  (maximum 128 characters)                                            |
| `location_state`                                                                                                           | `string`  | The state or county in which the location is situated  (maximum 128 characters)                                 |
| `location_postcode`                                                                                                        | `string`  | The postal or ZIP code of the location (maximum 10 characters)                                                  |
| `location_country_id`                                                                                                      | `integer` | **                                                                                                              |
| Required**. The country code of the location's physical address. Should reference an id in the "countries" database table. |           |                                                                                                                 |
| `location_lat`                                                                                                             | `decimal` | The latitude of the location                                                                                    |
| `location_lng`                                                                                                             | `decimal` | The longitude of the location                                                                                   |
| `description`                                                                                                              | `string`  | A description of the location to display to users (maximum of 3028 characters)                                  |
| `location_status`                                                                                                          | `boolean` | Has the value `true` if the location is enabled or the value `false` if the location is disabled.               |
| `permalink_slug`                                                                                                           | `string`  | The URL slug for this location. Use only alpha-numeric lowercase characters, _ or - and make sure it is unique. |

#### Payload example

```json
{
  "location_name": "My restaurant",
  "location_email": "restaurant@bloggs.com",
  "description": "My TastyIgniter restaurant",
  "location_address_1": "1 Some Street",
  "location_address_2": "",
  "location_city": "London",
  "location_state": "London",
  "location_postcode": "WA4 3NN",
  "location_country_id": 222,
  "location_telephone": "1234512345",
  "location_status":true
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
      "type": "locations",
      "id": "1",
      "attributes": {
        "location_name": "My restaurant",
        "location_email": "restaurant@bloggs.com",
        "description": "My TastyIgniter restaurant",
        "location_address_1": "1 Some Street",
        "location_address_2": "",
        "location_city": "London",
        "location_state": "London",
        "location_postcode": "WA4 3NN",
        "location_country_id": 222,
        "location_telephone": "1234512345",
        "location_lat": 50.6008818,
        "location_lng": -6.8794655,
        "location_status": true,
        "permalink_slug": "my-restaurant",
        "media": []
      }
    }
  ]
}
```

### Retrieve a location

Retrieves a location.

Required abilities: `locations:read`

```
GET /api/locations/:location_id
```

#### Parameters

| Key       | Type     | Description                                                                                                                                                                              |
|-----------|----------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `include` | `string` | What relations to include in the response. Options are `media`, `working_hours`, `delivery_areas`, `reviews`. To include multiple separate by comma (e.g. ?include= working_hours,media) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "locations",
            "id": "1",
            "attributes": {
                "location_name": "My restaurant",
                "location_email": "restaurant@bloggs.com",
                "description": "My TastyIgniter restaurant",
                "location_address_1": "1 Some Street",
                "location_address_2": "",
                "location_city": "London",
                "location_state": "London",
                "location_postcode": "WA4 3NN",
                "location_country_id": 222,
                "location_telephone": "1234512345",
                "location_lat": 50.6008818,
                "location_lng": -6.8794655,
                "location_status": true,
                "permalink_slug": "my-restaurant",
                "media": [],
                "working_hours": [],
                "delivery_areas": [],
                "reviews": []
            },
            "relationships": {
                "working_hours": {
                    "data": []
                },
                "delivery_areas": {
                    "data": []
                },
                "reviews": {
                    "data": []
                }
            }
        }
    ],
    "included": []
}
```

### Update a location

Updates a location.

Required abilities: `locations:write`

```
PATCH /api/locations/:location_id
```

#### Parameters

| Key                                                                                                                        | Type      | Description                                                                                                     |
|----------------------------------------------------------------------------------------------------------------------------|-----------|-----------------------------------------------------------------------------------------------------------------|
| `location_name`                                                                                                            | `string`  | **                                                                                                              |
| Required**. The location's name (between 2 and 48 characters in length)                                                    |           |                                                                                                                 |
| `location_email`                                                                                                           | `string`  | **Required**. The location's email address                                                                      |
| `location_telephone`                                                                                                       | `string`  | The location's telephone number (between 2 and 15 characters in length)                                         |
| `location_address_1`                                                                                                       | `string`  | **                                                                                                              |
| Required**. The first line of the location's physical address (between 2 and 128 characters)                               |           |                                                                                                                 |
| `location_address_2`                                                                                                       | `string`  | The second line of the location's physical address (maximum 128 characters)                                     |
| `location_city`                                                                                                            | `string`  | The city in which the location is situated  (maximum 128 characters)                                            |
| `location_state`                                                                                                           | `string`  | The state or county in which the location is situated  (maximum 128 characters)                                 |
| `location_postcode`                                                                                                        | `string`  | The postal or ZIP code of the location (maximum 10 characters)                                                  |
| `location_country_id`                                                                                                      | `integer` | **                                                                                                              |
| Required**. The country code of the location's physical address. Should reference an id in the "countries" database table. |           |                                                                                                                 |
| `location_lat`                                                                                                             | `decimal` | The latitude of the location                                                                                    |
| `location_lng`                                                                                                             | `decimal` | The longitude of the location                                                                                   |
| `description`                                                                                                              | `string`  | A description of the location to display to users (maximum of 3028 characters)                                  |
| `location_status`                                                                                                          | `boolean` | Has the value `true` if the location is enabled or the value `false` if the location is disabled.               |
| `permalink_slug`                                                                                                           | `string`  | The URL slug for this location. Use only alpha-numeric lowercase characters, _ or - and make sure it is unique. |

#### Payload example

```json
{
    "location_name": "My new restaurant",
    "location_email": "new@bloggs.com"
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
            "type": "locations",
            "id": "1",
            "attributes": {
                "location_name": "My new restaurant",
                "location_email": "new@bloggs.com",
                "description": "My TastyIgniter restaurant",
                "location_address_1": "1 Some Street",
                "location_address_2": "",
                "location_city": "London",
                "location_state": "London",
                "location_postcode": "WA4 3NN",
                "location_country_id": 222,
                "location_telephone": "1234512345",
                "location_lat": 50.6008818,
                "location_lng": -6.8794655,
                "location_status": true,
                "permalink_slug": "my-restaurant",
                "media": []
            }
        }
    ]
}
```

### Delete a location

Permanently deletes a location. It cannot be undone.

Required abilities: `locations:write`

```
DELETE /api/locations/:location_id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the location ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
    "id": 1,
    "object": "location",
    "deleted": true
}
```
