
# Error Category

Indicates which high-level category of error has occurred during a
request to the Connect API.

## Enumeration

`ErrorCategory`

## Fields

| Name | Description |
|  --- | --- |
| `API_ERROR` | An error occurred with the Connect API itself. |
| `AUTHENTICATION_ERROR` | An authentication error occurred. Most commonly, the request had<br>a missing, malformed, or otherwise invalid `Authorization` header. |
| `INVALID_REQUEST_ERROR` | The request was invalid. Most commonly, a required parameter was<br>missing, or a provided parameter had an invalid value. |
| `RATE_LIMIT_ERROR` | Your application reached the Square API rate limit. You might receive this error if your application sends a high number of requests<br>to Square APIs in a short period of time.<br><br>Your application should monitor responses for `429 RATE_LIMITED` errors and use a retry mechanism with an [exponential backoff](https://en.wikipedia.org/wiki/Exponential_backoff)<br>schedule to resend the requests at an increasingly slower rate. It is also a good practice to use a randomized delay (jitter) in your retry schedule. |
| `PAYMENT_METHOD_ERROR` | An error occurred while processing a payment method. Most commonly,<br>the details of the payment method were invalid (such as a card's CVV<br>or expiration date). |
| `REFUND_ERROR` | An error occurred while attempting to process a refund. |
| `MERCHANT_SUBSCRIPTION_ERROR` | An error occurred when checking a merchant subscription status |

