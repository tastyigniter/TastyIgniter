## Reviews

This endpoint allows you to `list`, `create`, `retrieve`, `update` and `delete` reviews on your TastyIgniter site.

The endpoint responses are formatted according to the [JSON:API specification](https://jsonapi.org).

### The review object

#### Attributes

| Key                | Type                | Description                                                                                       |
|--------------------|---------------------|---------------------------------------------------------------------------------------------------|
| `reviewable_id`    | `int`               | **Required**. The ID of the sale or reservation the review references                             |
| `reviewable_type ` | `string`            | **Required**. The type of review, one of orders or reservations                                   |
| `author`           | `integer` or `null` | The ID of the admin user writing the review or null                                               |
| `quality `         | `integer`           | Score from 0 to 5 for the quality of the food received                                            |
| `delivery `        | `integer`           | Score from 0 to 5 for the quality of the delivery service received                                |
| `service `         | `integer`           | Score from 0 to 5 for the quality of the customer service received                                |
| `review_text `     | `string`            | The customer text review (if any)                                                                 |
| `review_status`    | `boolean`           | Has the value `true` if the category is enabled or the value `false` if the category is disabled. |
| `location`         | `object`            | The location associated with the review (see [Locations](locations.md))                           |
| `customer`         | `object `           | The customer associated with the review (see [Customers](customers.md))                           |

#### Review object example

```json
{
    "review_id": 1,
    "customer_id": 1,
    "reviewable_id": 1,
    "reviewable_type": "orders",
    "author": 1,
    "location_id": 1,
    "quality": 5,
    "delivery": 5,
    "service": 5,
    "review_text": "This restaurant is amazing!",
    "created_at": "2020-06-03 09:17:12",
    "updated_at": "2020-06-03 09:17:12",
    "review_status": true,
    "location": {},
    "customer": {}
}
```


### List reviews

Retrieves a list of reviews.

Required abilities: `reviews:read`

```
GET /api/reviews
```

#### Parameters

| Key         | Type      | Description                                                                                                                                            |
|-------------|-----------|--------------------------------------------------------------------------------------------------------------------------------------------------------|
| `page`      | `integer` | The page number.                                                                                                                                       |
| `pageLimit` | `integer` | The number of items per page.                                                                                                                          |
| `sort`      | `string`  | The order to return results in. Possible values are `created_at asc`, `created_at desc`                                                                |
| `enabled`   | `boolean` | If true only menu items that are enabled will be returned                                                                                              |
| `location`  | `integer` | The id of the location you wan to return reviews for                                                                                                   |
| `customer`  | `integer` | The id of the customer you wan to return reviews for                                                                                                   |
| `include`   | `string`  | What relations to include in the response. Options are `location`, `customer`. To include multiple separate by comma (e.g. ?include=location,customer) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "reviews",
            "id": "1",
            "attributes": {
                "review_id": 1,
                "customer_id": 1,
                "reviewable_id": 1,
                "reviewable_type": "orders",
                "author": 1,
                "location_id": 1,
                "quality": 4,
                "delivery": 5,
                "service": 5,
                "review_text": "This restaurant is amazing!",
                "created_at": "2020-06-03 09:17:12",
                "updated_at": "2020-06-03 09:17:12",
                "review_status": true,
                "location": {},
                "customer": {}
            },
            "relationships": {
                "location": {
                    "data": []
                },
                "customer": {
                    "data": []
                }
            }
        }
    ],
    "included": [],
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
        "self": "https://your.url/api/reviews?page=1",
        "first": "https://your.url/api/reviews?page=1",
        "last": "https://your.url/api/reviews?page=1"
    }
}
```

### Create a review

Creates a new review.

Required abilities: `reviews:write`

```
POST /api/reviews
```

#### Parameters

| Key                | Type                | Description                                                                                   |
|--------------------|---------------------|-----------------------------------------------------------------------------------------------|
| `reviewable_id`    | `int`               | **Required**. The ID of the sale or reservation the review references                         |
| `reviewable_type ` | `string`            | **Required**. The type of review, one of orders or reservations                               |
| `author`           | `integer` or `null` | The ID of the admin user writing the review or null                                           |
| `quality `         | `integer`           | Score from 0 to 5 for the quality of the food received                                        |
| `delivery `        | `integer`           | Score from 0 to 5 for the quality of the delivery service received                            |
| `service `         | `integer`           | Score from 0 to 5 for the quality of the customer service received                            |
| `review_text `     | `string`            | The customer text review                                                                      |
| `review_status`    | `boolean`           | Has the value `true` if the review is enabled or the value `false` if the review is disabled. |
| `location_id`      | `integer`           | The ID of the location associated with the review                                             |
| `customer_id`      | `integer `          | The ID of the customer associated with the review                                             |

#### Payload example

```json
{
  "reviewable_id": 1,
  "reviewable_type": "orders",
  "quality": 4,
  "delivery": 5,
  "service": 5,
  "review_text": "This restaurant is amazing!",
  "review_status": true,
  "customer_id": 1,
  "location_id": 1
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
      "type": "reviews",
      "id": "1",
      "attributes": {
        "customer_id": 1,
        "reviewable_id": 1,
        "reviewable_type": "orders",
        "author": 1,
        "location_id": 1,
        "quality": 4,
        "delivery": 5,
        "service": 5,
        "review_text": "This restaurant is amazing!",
        "created_at": "2020-06-03 09:17:12",
        "updated_at": "2020-06-03 09:17:12",
        "review_status": true,
        "location": {},
        "customer": {}
      }
    }
  ]
}
```

### Retrieve a review

Retrieves a review.

Required abilities: `reviews:read`

```
GET /api/reviews/:review_id
```

#### Parameters

| Key       | Type     | Description                                                                                                                                            |
|-----------|----------|--------------------------------------------------------------------------------------------------------------------------------------------------------|
| `include` | `string` | What relations to include in the response. Options are `location`, `customer`. To include multiple separate by comma (e.g. ?include=location,customer) |

#### Response

```html
Status: 200 OK
```

```json
{
    "data": [
        {
            "type": "reviews",
            "id": "1",
            "attributes": {
                "review_id": 1,
                "customer_id": 1,
                "reviewable_id": 1,
                "reviewable_type": "orders",
                "author": 1,
                "location_id": 1,
                "quality": 4,
                "delivery": 5,
                "service": 5,
                "review_text": "This restaurant is amazing!",
                "created_at": "2020-06-03 09:17:12",
                "updated_at": "2020-06-03 09:17:12",
                "review_status": true,
                "location": {},
                "customer": {}
            },
            "relationships": {
                "location": {
                    "data": []
                },
                "customer": {
                    "data": []
                }
            }
        }
    ],
    "included": []
}
```

### Update a review

Updates a review.

Required abilities: `reviews:write`

```
PATCH /api/reviews/:review_id
```

#### Parameters

| Key                | Type                | Description                                                                                   |
|--------------------|---------------------|-----------------------------------------------------------------------------------------------|
| `reviewable_id`    | `int`               | **Required**. The ID of the sale or reservation the review references                         |
| `reviewable_type ` | `string`            | **Required**. The type of review, one of orders or reservations                               |
| `author`           | `integer` or `null` | The ID of the admin user writing the review or null                                           |
| `quality `         | `integer`           | Score from 0 to 5 for the quality of the food received                                        |
| `delivery `        | `integer`           | Score from 0 to 5 for the quality of the delivery service received                            |
| `service `         | `integer`           | Score from 0 to 5 for the quality of the customer service received                            |
| `review_text `     | `string`            | The customer text review                                                                      |
| `review_status`    | `boolean`           | Has the value `true` if the review is enabled or the value `false` if the review is disabled. |
| `location_id`      | `integer`           | The ID of the location associated with the review                                             |
| `customer_id`      | `integer `          | The ID of the customer associated with the review                                             |

#### Payload example

```json
{
    "quality": 5,
    "review_text": "This restaurant is *really* amazing!"
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
            "type": "reviews",
            "id": "1",
            "attributes": {
                "customer_id": 1,
                "reviewable_id": 1,
                "reviewable_type": "orders",
                "author": 1,
                "location_id": 1,
                "quality": 5,
                "delivery": 5,
                "service": 5,
                "review_text": "This restaurant is *really* amazing!",
                "created_at": "2020-06-03 09:17:12",
                "updated_at": "2020-06-03 09:17:12",
                "review_status": true,
                "location": {},
                "customer": {}
            }
        }
    ]
}
```

### Delete a review

Permanently deletes a review. It cannot be undone.

Required abilities: `reviews:write`

```
DELETE /api/reviews/:review_id
```

#### Parameters

No parameters.

#### Response

Returns an object with a deleted parameter on success. If the review ID does not exist, this call returns an error.

```html
Status: 200 OK
```

```json
{
    "id": 1,
    "object": "review",
    "deleted": true
}
```
