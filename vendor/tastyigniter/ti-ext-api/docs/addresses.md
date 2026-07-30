## Addresses

This endpoint lets you `list`, `create`, `retrieve`, `update` and `delete` customer addresses on your TastyIgniter site.

Responses follow the [JSON:API specification](https://jsonapi.org).

### The address object

#### Attributes

| Key          | Type     | Description                                                                 |
|--------------|----------|-----------------------------------------------------------------------------|
| `address_1`  | `string` | **Required**. First line of the address (between 3 and 128 characters).     |
| `address_2`  | `string` | Second line of the address (between 1 and 128 characters).                  |
| `city`       | `string` | **Required**. City or town (between 2 and 128 characters).                 |
| `state`      | `string` | State or county (max 128 characters).                                       |
| `postcode`   | `string` | Postcode or ZIP code (max 128 characters).                                 |
| `country_id` | `integer`| **Required**. Country ID from the countries table.                          |
| `customer_id`| `integer`| The customer this address belongs to. Set automatically for customer tokens.|

#### The country relation

When you request `?include=country`, each address may include a `country` relation with attributes such as `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `priority`.

### List addresses

Retrieves a list of addresses. Customers see only their own addresses; staff see all according to token abilities.

Required abilities: `addresses:read`

```
GET /api/addresses
```

#### Parameters

| Key         | Type      | Description                                                                 |
|-------------|-----------|-----------------------------------------------------------------------------|
| `page`      | `integer` | Page number.                                                               |
| `pageLimit` | `integer` | Number of items per page.                                                   |
| `include`   | `string`  | Relations to include. Options: `country`. Example: `?include=country`       |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "addresses",
            "id": "1",
            "attributes": {
                "address_1": "1 Some Road",
                "address_2": null,
                "city": "London",
                "state": "",
                "postcode": "W1A 3NN",
                "country_id": 222,
                "customer_id": 1
            }
        }
    ],
    "meta": {
        "pagination": {
            "total": 1,
            "count": 1,
            "per_page": 20,
            "current_page": 1,
            "total_pages": 1
        }
    },
    "links": {
        "self": "https://your.url/api/addresses?page=1",
        "first": "https://your.url/api/addresses?page=1",
        "last": "https://your.url/api/addresses?page=1"
    }
}
```

### Create an address

Creates a new address. For customer tokens, `customer_id` is set automatically.

Required abilities: `addresses:write`

```
POST /api/addresses
```

#### Parameters

| Key          | Type     | Description                                                |
|--------------|----------|------------------------------------------------------------|
| `address_1`  | `string` | **Required**. First line (3–128 characters).               |
| `address_2`  | `string` | Second line (optional).                                    |
| `city`       | `string` | **Required**. City (2–128 characters).                     |
| `state`      | `string` | State or county (optional).                                |
| `postcode`   | `string` | Postcode or ZIP (optional).                                 |
| `country_id` | `integer`| **Required**. Country ID.                                  |
| `customer_id`| `integer` | Customer ID (admin only; ignored for customer tokens).     |

#### Payload example

```json
{
    "address_1": "1 Some Road",
    "address_2": "Flat 2",
    "city": "London",
    "state": "",
    "postcode": "W1A 3NN",
    "country_id": 222
}
```

#### Response

```html
Status: 201 Created
```

```json
{
    "data": {
        "type": "addresses",
        "id": "1",
        "attributes": {
            "address_1": "1 Some Road",
            "address_2": "Flat 2",
            "city": "London",
            "state": "",
            "postcode": "W1A 3NN",
            "country_id": 222,
            "customer_id": 1
        }
    }
}
```

### Retrieve an address

Fetches a single address by ID.

Required abilities: `addresses:read`

```
GET /api/addresses/:id
```

#### Parameters

| Key       | Type     | Description                                                    |
|-----------|----------|----------------------------------------------------------------|
| `include` | `string` | Relations to include. Options: `country`. Example: `?include=country` |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": {
        "type": "addresses",
        "id": "1",
        "attributes": {
            "address_1": "1 Some Road",
            "address_2": null,
            "city": "London",
            "state": "",
            "postcode": "W1A 3NN",
            "country_id": 222,
            "customer_id": 1
        }
    }
}
```

### Update an address

Updates an existing address.

Required abilities: `addresses:write`

```
PUT /api/addresses/:id
PATCH /api/addresses/:id
```

#### Parameters

Same as create; all fields are optional when updating.

#### Response

```html
Status: 200 OK
```

Returns the updated address object in the same shape as the retrieve response.

### Delete an address

Permanently deletes an address.

Required abilities: `addresses:write`

```
DELETE /api/addresses/:id
```

#### Response

```html
Status: 204 No Content
```

No response body.
