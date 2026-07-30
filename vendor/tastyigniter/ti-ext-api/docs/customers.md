## Customers

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` customers on your TastyIgniter site.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The customer object

#### Attributes

| Key                                                                           | Type        | Description                                                                                       |
|-------------------------------------------------------------------------------|-------------|---------------------------------------------------------------------------------------------------|
| `first_name`                                                                  | `string`    | **                                                                                                |
| Required**. The customer's first name (between 2 and 48 characters in length) |             |                                                                                                   |
| `last_name`                                                                   | `string`    | **                                                                                                |
| Required**. The customer's last name (between 2 and 48 characters in length)  |             |                                                                                                   |
| `full_name`                                                                   | `string`    | A concatenation of first_name and last_name                                                       |
| `email`                                                                       | `string`    | **Required**. The customer's email address                                                        |
| `telephone`                                                                   | `string`    | The customer's telephone number                                                                   |
| `created_at`                                                                  | `timestamp` | The date and time the customer was added to your site                                             |
| `updated_at`                                                                  | `timestamp` | The date and time the customer was updated                                                        |
| `newsletter`                                                                  | `boolean`   | Whether the customer opts into newsletter marketing                                               |
| `customer_group_id`                                                           | `integer`   | The group the customer belongs to, if any.                                                        |
| `status`                                                                      | `boolean`   | Has the value `true` if the customer is enabled or the value `false` if the customer is disabled. |
| `addresses`                                                                   | `array`     | The customer's addresses, if any                                                                  |
| `orders`                                                                      | `array`     | The customer's orders, if any (see [Orders](orders.md) for structure)                             |
| `reservations`                                                                | `array`     | The customer's addresses, if any (see [Reservations](reservations.md) for structure)              |

#### Customer object example

```json
{
    "customer_id": 1,
    "first_name": "Joe",
    "last_name": "Bloggs",
    "email": "joe@bloggs.com",
    "telephone": "1234512345",
    "newsletter": false,
    "customer_group_id": 1,
    "created_at": "2020-05-20 08:34:37",
    "updated_at": "2020-05-20 08:34:37",
    "status": true,
    "full_name": "Joe Bloggs",
    "addresses": [
        {
            "address_id": 1,
            "customer_id": 1,
            "address_1": "1 Some Road",
            "address_2": null,
            "city": "London",
            "state": "",
            "postcode": "W1A 3NN",
            "country_id": 222
        }
    ],
    "orders": [],
    "reservations": []
}
```

### The address object

#### Attributes

| Key                                                                                                              | Type      | Description                                                                    |
|------------------------------------------------------------------------------------------------------------------|-----------|--------------------------------------------------------------------------------|
| `address_1`                                                                                                      | `string`  | **                                                                             |
| Required**. The first line of the customer's address (between 3 and 128 characters)                              |           |                                                                                |
| `address_2`                                                                                                      | `string`  | The second line of the customer's address (between 3 and 128 characters)       |
| `city`                                                                                                           | `string`  | **                                                                             |
| Required**. The city or town of the customer's address (between state and 128 characters)                        |           |                                                                                |
| `state`                                                                                                          | `string`  | The state or county of the customer's address (maximum of 128 characters)      |
| `postcode`                                                                                                       | `string`  | The postcode or ZIP code of the customer's address (maximum of 128 characters) |
| `country_id`                                                                                                     | `integer` | **                                                                             |
| Required**. The country code of the customers address. Should reference an id in the "countries" database table. |           |                                                                                |

### List customers

Retrieves a list of customers.

Required abilities: `customers:read`

```
GET /api/customers
```

#### Parameters

| Key         | Type      | Description                                                                                                                                                          |
|-------------|-----------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `page`      | `integer` | The page number.                                                                                                                                                     |
| `pageLimit` | `integer` | The number of items per page.                                                                                                                                        |
| `include`   | `string`  | What relations to include in the response. Options are `addresses`, `orders`, `reservations`. To include multiple separate by comma (e.g. ?include=addresses,orders) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "customers",
            "id": "1",
            "attributes": {
                "first_name": "Joe",
                "last_name": "Bloggs",
                "email": "joe@bloggs.com",
                "telephone": "1234512345",
                "newsletter": false,
                "customer_group_id": 1,
                "created_at": "2020-05-20 08:34:37",
                "updated_at": "2020-05-20 08:34:37",
                "status": true,
                "full_name": "Joe Bloggs",
                "addresses": [
                    {
                        "address_id": 1,
                        "customer_id": 1,
                        "address_1": "1 Some Road",
                        "address_2": null,
                        "city": "London",
                        "state": "",
                        "postcode": "W1A 3NN",
                        "country_id": 222
                    }
                ],
                "orders": [],
                "reservations": []
            },
            "relationships": {
                "orders": {
                    "data": []
                },
                "reservations": {
                    "data": []
                }
            }
        },
        {
            "type": "customers",
            "id": "2",
            "attributes": {
                "first_name": "Sherlock",
                "last_name": "Holmes",
                "email": "sherlock@holmes.com",
                "telephone": "01234012345",
                "newsletter": true,
                "customer_group_id": 1,
                "created_at": "2020-05-21 09:12:17",
                "updated_at": "2020-05-21 09:12:17",
                "status": false,
                "full_name": "Sherlock Holmes",
                "addresses": [],
                "orders": [],
                "reservations": []
            },
            "relationships": {
                "orders": {
                    "data": []
                },
                "reservations": {
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
        "self": "https://your.url/api/customers?page=1",
        "first": "https://your.url/api/customers?page=1",
        "last": "https://your.url/api/customers?page=1"
    }
}
```

### Create a customer

Creates a new customer.

Required abilities: `customers:write`

```
POST /api/customers
```

#### Parameters

| Key                                                                           | Type      | Description                                                                                       |
|-------------------------------------------------------------------------------|-----------|---------------------------------------------------------------------------------------------------|
| `first_name`                                                                  | `string`  | **                                                                                                |
| Required**. The customer's first name (between 2 and 32 characters in length) |           |                                                                                                   |
| `last_name`                                                                   | `string`  | **                                                                                                |
| Required**. The customer's last name (between 2 and 32 characters in length)  |           |                                                                                                   |
| `email`                                                                       | `string`  | **Required**. The customer's email address                                                        |
| `telephone`                                                                   | `string`  | The customer's telephone number                                                                   |
| `newsletter`                                                                  | `boolean` | Whether the customer opts into newsletter marketing                                               |
| `customer_group_id`                                                           | `integer` | The group the customer belongs to, if any.                                                        |
| `status`                                                                      | `boolean` | Has the value `true` if the customer is enabled or the value `false` if the customer is disabled. |
| `addresses`                                                                   | `array`   | The customer's addresses, if any                                                                  |

#### Payload example

```json
{
    "first_name": "Joe",
    "last_name": "Bloggs",
    "email": "joe@bloggs.com",
    "telephone": "1234512345",
    "newsletter": false,
    "status": true,
    "addresses": [
        {
            "address_1": "1 Some Road",
            "address_2": null,
            "city": "London",
            "state": "",
            "postcode": "W1A 3NN",
            "country_id": 222
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
    "data": [
        {
            "type": "customers",
            "id": "1",
            "attributes": {
                "first_name": "Joe",
                "last_name": "Bloggs",
                "email": "joe@bloggs.com",
                "telephone": "1234512345",
                "newsletter": false,
                "customer_group_id": 1,
                "created_at": "2020-05-20 08:34:37",
                "updated_at": "2020-05-20 08:34:37",
                "status": true,
                "full_name": "Joe Bloggs",
                "addresses": [
                    {
                        "address_id": 1,
                        "customer_id": 1,
                        "address_1": "1 Some Road",
                        "address_2": null,
                        "city": "London",
                        "state": "",
                        "postcode": "W1A 3NN",
                        "country_id": 222
                    }
                ]
            }
        }
    ]
}
```

### Retrieve a customer

Retrieves a customer.

Required abilities: `customers:read`

```
GET /api/customers/:customer_id
```

#### Parameters

| Key       | Type     | Description                                                                                                                                                          |
|-----------|----------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| `include` | `string` | What relations to include in the response. Options are `addresses`, `orders`, `reservations`. To include multiple separate by comma (e.g. ?include=addresses,orders) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "customers",
            "id": "1",
            "attributes": {
                "first_name": "Joe",
                "last_name": "Bloggs",
                "email": "joe@bloggs.com",
                "telephone": "1234512345",
                "newsletter": false,
                "customer_group_id": 1,
                "created_at": "2020-05-20 08:34:37",
                "updated_at": "2020-05-20 08:34:37",
                "status": true,
                "full_name": "Joe Bloggs",
                "addresses": [
                    {
                        "address_id": 1,
                        "customer_id": 1,
                        "address_1": "1 Some Road",
                        "address_2": null,
                        "city": "London",
                        "state": "",
                        "postcode": "W1A 3NN",
                        "country_id": 222
                    }
                ]
            },
            "relationships": {
                "orders": {
                    "data": []
                },
                "reservations": {
                    "data": []
                }
            }
        }
    ],
    "included": []
}
```

### Update a customer

Updates a customer.

Required abilities: `customers:write`

```
PATCH /api/customers/:customer_id
```

#### Parameters

| Key                 | Type      | Description                                                                                       |
|---------------------|-----------|---------------------------------------------------------------------------------------------------|
| `first_name`        | `string`  | The customer's first name (between 2 and 32 characters in length)                                 |
| `last_name`         | `string`  | The customer's last name (between 2 and 32 characters in length)                                  |
| `email`             | `string`  | The customer's email address                                                                      |
| `telephone`         | `string`  | The customer's telephone number                                                                   |
| `newsletter`        | `boolean` | Whether the customer opts into newsletter marketing                                               |
| `customer_group_id` | `integer` | The group the customer belongs to, if any.                                                        |
| `status`            | `boolean` | Has the value `true` if the customer is enabled or the value `false` if the customer is disabled. |
| `addresses`         | `array`   | The customer's addresses, if any                                                                  |

#### Payload example

```json
{
    "first_name": "Joseph",
    "email": "joseph@bloggs.com"
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
            "type": "customers",
            "id": "1",
            "attributes": {
                "first_name": "Joseph",
                "last_name": "Bloggs",
                "email": "joseph@bloggs.com",
                "telephone": "1234512345",
                "newsletter": false,
                "customer_group_id": 1,
                "created_at": "2020-05-20 08:34:37",
                "updated_at": "2020-05-20 08:34:37",
                "status": true,
                "full_name": "Joe Bloggs",
                "addresses": [
                    {
                        "address_id": 1,
                        "customer_id": 1,
                        "address_1": "1 Some Road",
                        "address_2": null,
                        "city": "London",
                        "state": "",
                        "postcode": "W1A 3NN",
                        "country_id": 222
                    }
                ]
            }
        }
    ]
}
```

### Delete a customer

Permanently deletes a customer. It cannot be undone.

Required abilities: `customers:write`

```
DELETE /api/customers/:customer_id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the customer ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
    "id": 1,
    "object": "customer",
    "deleted": true
}
```
