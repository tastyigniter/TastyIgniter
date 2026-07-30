
# Error Code

Indicates the specific error that occurred during a request to a
Square API.

## Enumeration

`ErrorCode`

## Fields

| Name | Description |
|  --- | --- |
| `INTERNAL_SERVER_ERROR` | A general server error occurred. |
| `UNAUTHORIZED` | A general authorization error occurred. |
| `ACCESS_TOKEN_EXPIRED` | The provided access token has expired. |
| `ACCESS_TOKEN_REVOKED` | The provided access token has been revoked. |
| `CLIENT_DISABLED` | The provided client has been disabled. |
| `FORBIDDEN` | A general access error occurred. |
| `INSUFFICIENT_SCOPES` | The provided access token does not have permission<br>to execute the requested action. |
| `APPLICATION_DISABLED` | The calling application was disabled. |
| `V1_APPLICATION` | The calling application was created prior to<br>2016-03-30 and is not compatible with v2 Square API calls. |
| `V1_ACCESS_TOKEN` | The calling application is using an access token<br>created prior to 2016-03-30 and is not compatible with v2 Square API<br>calls. |
| `CARD_PROCESSING_NOT_ENABLED` | The location provided in the API call is not<br>enabled for credit card processing. |
| `MERCHANT_SUBSCRIPTION_NOT_FOUND` | A required subscription was not found for the merchant |
| `BAD_REQUEST` | A general error occurred with the request. |
| `MISSING_REQUIRED_PARAMETER` | The request is missing a required path, query, or<br>body parameter. |
| `INCORRECT_TYPE` | The value provided in the request is the wrong<br>type. For example, a string instead of an integer. |
| `INVALID_TIME` | Formatting for the provided time value is<br>incorrect. |
| `INVALID_TIME_RANGE` | The time range provided in the request is invalid.<br>For example, the end time is before the start time. |
| `INVALID_VALUE` | The provided value is invalid. For example,<br>including `%` in a phone number. |
| `INVALID_CURSOR` | The pagination cursor included in the request is<br>invalid. |
| `UNKNOWN_QUERY_PARAMETER` | The query parameters provided is invalid for the<br>requested endpoint. |
| `CONFLICTING_PARAMETERS` | One or more of the request parameters conflict with<br>each other. |
| `EXPECTED_JSON_BODY` | The request body is not a JSON object. |
| `INVALID_SORT_ORDER` | The provided sort order is not a valid key.<br>Currently, sort order must be `ASC` or `DESC`. |
| `VALUE_REGEX_MISMATCH` | The provided value does not match an expected<br>regular expression. |
| `VALUE_TOO_SHORT` | The provided string value is shorter than the<br>minimum length allowed. |
| `VALUE_TOO_LONG` | The provided string value is longer than the<br>maximum length allowed. |
| `VALUE_TOO_LOW` | The provided value is less than the supported<br>minimum. |
| `VALUE_TOO_HIGH` | The provided value is greater than the supported<br>maximum. |
| `VALUE_EMPTY` | The provided value has a default (empty) value<br>such as a blank string. |
| `ARRAY_LENGTH_TOO_LONG` | The provided array has too many elements. |
| `ARRAY_LENGTH_TOO_SHORT` | The provided array has too few elements. |
| `ARRAY_EMPTY` | The provided array is empty. |
| `EXPECTED_BOOLEAN` | The endpoint expected the provided value to be a<br>boolean. |
| `EXPECTED_INTEGER` | The endpoint expected the provided value to be an<br>integer. |
| `EXPECTED_FLOAT` | The endpoint expected the provided value to be a<br>float. |
| `EXPECTED_STRING` | The endpoint expected the provided value to be a<br>string. |
| `EXPECTED_OBJECT` | The endpoint expected the provided value to be a<br>JSON object. |
| `EXPECTED_ARRAY` | The endpoint expected the provided value to be an<br>array or list. |
| `EXPECTED_MAP` | The endpoint expected the provided value to be a<br>map or associative array. |
| `EXPECTED_BASE64_ENCODED_BYTE_ARRAY` | The endpoint expected the provided value to be an<br>array encoded in base64. |
| `INVALID_ARRAY_VALUE` | One or more objects in the array does not match the<br>array type. |
| `INVALID_ENUM_VALUE` | The provided static string is not valid for the<br>field. |
| `INVALID_CONTENT_TYPE` | Invalid content type header. |
| `INVALID_FORM_VALUE` | Only relevant for applications created prior to<br>2016-03-30. Indicates there was an error while parsing form values. |
| `CUSTOMER_NOT_FOUND` | The provided customer id can't be found in the merchant's customers list. |
| `ONE_INSTRUMENT_EXPECTED` | A general error occurred. |
| `NO_FIELDS_SET` | A general error occurred. |
| `TOO_MANY_MAP_ENTRIES` | Too many entries in the map field. |
| `MAP_KEY_LENGTH_TOO_SHORT` | The length of one of the provided keys in the map is too short. |
| `MAP_KEY_LENGTH_TOO_LONG` | The length of one of the provided keys in the map is too long. |
| `CUSTOMER_MISSING_NAME` | The provided customer does not have a recorded name. |
| `CUSTOMER_MISSING_EMAIL` | The provided customer does not have a recorded email. |
| `INVALID_PAUSE_LENGTH` | The subscription cannot be paused longer than the duration of the current phase. |
| `INVALID_DATE` | The subscription cannot be paused/resumed on the given date. |
| `UNSUPPORTED_COUNTRY` | The API request references an unsupported country. |
| `UNSUPPORTED_CURRENCY` | The API request references an unsupported currency. |
| `CARD_EXPIRED` | The card issuer declined the request because the card is expired. |
| `INVALID_EXPIRATION` | The expiration date for the payment card is invalid. For example,<br>it indicates a date in the past. |
| `INVALID_EXPIRATION_YEAR` | The expiration year for the payment card is invalid. For example,<br>it indicates a year in the past or contains invalid characters. |
| `INVALID_EXPIRATION_DATE` | The expiration date for the payment card is invalid. For example,<br>it contains invalid characters. |
| `UNSUPPORTED_CARD_BRAND` | The credit card provided is not from a supported issuer. |
| `UNSUPPORTED_ENTRY_METHOD` | The entry method for the credit card (swipe, dip, tap) is not supported. |
| `INVALID_ENCRYPTED_CARD` | The encrypted card information is invalid. |
| `INVALID_CARD` | The credit card cannot be validated based on the provided details. |
| `PAYMENT_AMOUNT_MISMATCH` | The payment was declined because there was a payment amount mismatch.<br>The money amount Square was expecting does not match the amount provided. |
| `GENERIC_DECLINE` | Square received a decline without any additional information.<br>If the payment information seems correct, the buyer can contact their<br>issuer to ask for more information. |
| `CVV_FAILURE` | The card issuer declined the request because the CVV value is invalid. |
| `ADDRESS_VERIFICATION_FAILURE` | The card issuer declined the request because the postal code is invalid. |
| `INVALID_ACCOUNT` | The issuer was not able to locate the account on record. |
| `CURRENCY_MISMATCH` | The currency associated with the payment is not valid for the provided<br>funding source. For example, a gift card funded in USD cannot be used to process<br>payments in GBP. |
| `INSUFFICIENT_FUNDS` | The funding source has insufficient funds to cover the payment. |
| `INSUFFICIENT_PERMISSIONS` | The Square account does not have the permissions to accept<br>this payment. For example, Square may limit which merchants are<br>allowed to receive gift card payments. |
| `CARDHOLDER_INSUFFICIENT_PERMISSIONS` | The card issuer has declined the transaction due to restrictions on where the card can be used.<br>For example, a gift card is limited to a single merchant. |
| `INVALID_LOCATION` | The Square account cannot take payments in the specified region.<br>A Square account can take payments only from the region where the account was created. |
| `TRANSACTION_LIMIT` | The card issuer has determined the payment amount is either too high or too low.<br>The API returns the error code mostly for credit cards (for example, the card reached<br>the credit limit). However, sometimes the issuer bank can indicate the error for debit<br>or prepaid cards (for example, card has insufficient funds). |
| `VOICE_FAILURE` | The card issuer declined the request because the issuer requires voice authorization from the cardholder. The seller should ask the customer to contact the card issuing bank to authorize the payment. |
| `PAN_FAILURE` | The specified card number is invalid. For example, it is of<br>incorrect length or is incorrectly formatted. |
| `EXPIRATION_FAILURE` | The card expiration date is either invalid or indicates that the<br>card is expired. |
| `CARD_NOT_SUPPORTED` | The card is not supported either in the geographic region or by<br>the [merchant category code](https://developer.squareup.com/docs/locations-api#initialize-a-merchant-category-code) (MCC). |
| `INVALID_PIN` | The card issuer declined the request because the PIN is invalid. |
| `MISSING_PIN` | The payment is missing a required PIN. |
| `MISSING_ACCOUNT_TYPE` | The payment is missing a required ACCOUNT_TYPE parameter. |
| `INVALID_POSTAL_CODE` | The postal code is incorrectly formatted. |
| `INVALID_FEES` | The app_fee_money on a payment is too high. |
| `MANUALLY_ENTERED_PAYMENT_NOT_SUPPORTED` | The card must be swiped, tapped, or dipped. Payments attempted by manually entering the card number are declined. |
| `PAYMENT_LIMIT_EXCEEDED` | Square declined the request because the payment amount exceeded the processing limit for this merchant. |
| `GIFT_CARD_AVAILABLE_AMOUNT` | When a Gift Card is a payment source, you can allow taking a partial payment<br>by adding the `accept_partial_authorization` parameter in the request.<br>However, taking such a partial payment does not work if your request also includes<br>`tip_money`, `app_fee_money`, or both. Square declines such payments and returns<br>the `GIFT_CARD_AVAILABLE_AMOUNT` error.<br>For more information, see<br>[CreatePayment errors (additional information)](https://developer.squareup.com/docs/payments-api/error-codes#createpayment-errors-additional-information). |
| `ACCOUNT_UNUSABLE` | The account provided cannot carry out transactions. |
| `BUYER_REFUSED_PAYMENT` | Bank account rejected or was not authorized for the payment. |
| `DELAYED_TRANSACTION_EXPIRED` | The application tried to update a delayed-capture payment that has expired. |
| `DELAYED_TRANSACTION_CANCELED` | The application tried to cancel a delayed-capture payment that was already cancelled. |
| `DELAYED_TRANSACTION_CAPTURED` | The application tried to capture a delayed-capture payment that was already captured. |
| `DELAYED_TRANSACTION_FAILED` | The application tried to update a delayed-capture payment that failed. |
| `CARD_TOKEN_EXPIRED` | The provided card token (nonce) has expired. |
| `CARD_TOKEN_USED` | The provided card token (nonce) was already used to process the payment or refund. |
| `AMOUNT_TOO_HIGH` | The requested payment amount is too high for the provided payment source. |
| `UNSUPPORTED_INSTRUMENT_TYPE` | The API request references an unsupported instrument type. |
| `REFUND_AMOUNT_INVALID` | The requested refund amount exceeds the amount available to refund. |
| `REFUND_ALREADY_PENDING` | The payment already has a pending refund. |
| `PAYMENT_NOT_REFUNDABLE` | The payment is not refundable. For example, the payment has been disputed and is no longer eligible for<br>refunds. |
| `REFUND_DECLINED` | Request failed - The card issuer declined the refund. |
| `INSUFFICIENT_PERMISSIONS_FOR_REFUND` | The Square account does not have the permissions to process this refund. |
| `INVALID_CARD_DATA` | Generic error - the provided card data is invalid. |
| `SOURCE_USED` | The provided source id was already used to create a card. |
| `SOURCE_EXPIRED` | The provided source id has expired. |
| `UNSUPPORTED_LOYALTY_REWARD_TIER` | The referenced loyalty program reward tier is not supported.<br>This could happen if the reward tier created in a first party<br>application is incompatible with the Loyalty API. |
| `LOCATION_MISMATCH` | Generic error - the given location does not matching what is expected. |
| `IDEMPOTENCY_KEY_REUSED` | The provided idempotency key has already been used. |
| `UNEXPECTED_VALUE` | General error - the value provided was unexpected. |
| `SANDBOX_NOT_SUPPORTED` | The API request is not supported in sandbox. |
| `INVALID_EMAIL_ADDRESS` | The provided email address is invalid. |
| `INVALID_PHONE_NUMBER` | The provided phone number is invalid. |
| `CHECKOUT_EXPIRED` | The provided checkout URL has expired. |
| `BAD_CERTIFICATE` | Bad certificate. |
| `INVALID_SQUARE_VERSION_FORMAT` | The provided Square-Version is incorrectly formatted. |
| `API_VERSION_INCOMPATIBLE` | The provided Square-Version is incompatible with the requested action. |
| `CARD_PRESENCE_REQUIRED` | The transaction requires that a card be present. |
| `UNSUPPORTED_SOURCE_TYPE` | The API request references an unsupported source type. |
| `CARD_MISMATCH` | The provided card does not match what is expected. |
| `CARD_DECLINED` | The card was declined. |
| `VERIFY_CVV_FAILURE` | The CVV could not be verified. |
| `VERIFY_AVS_FAILURE` | The AVS could not be verified. |
| `CARD_DECLINED_CALL_ISSUER` | The payment card was declined with a request<br>for the card holder to call the issuer. |
| `CARD_DECLINED_VERIFICATION_REQUIRED` | The payment card was declined with a request<br>for additional verification. |
| `BAD_EXPIRATION` | The card expiration date is either missing or<br>incorrectly formatted. |
| `CHIP_INSERTION_REQUIRED` | The card issuer requires that the card be read<br>using a chip reader. |
| `ALLOWABLE_PIN_TRIES_EXCEEDED` | The card has exhausted its available pin entry<br>retries set by the card issuer. Resolving the error typically requires the<br>card holder to contact the card issuer. |
| `RESERVATION_DECLINED` | The card issuer declined the refund. |
| `UNKNOWN_BODY_PARAMETER` | The body parameter is not recognized by the requested endpoint. |
| `NOT_FOUND` | Not Found - a general error occurred. |
| `APPLE_PAYMENT_PROCESSING_CERTIFICATE_HASH_NOT_FOUND` | Square could not find the associated Apple Pay certificate. |
| `METHOD_NOT_ALLOWED` | Method Not Allowed - a general error occurred. |
| `NOT_ACCEPTABLE` | Not Acceptable - a general error occurred. |
| `REQUEST_TIMEOUT` | Request Timeout - a general error occurred. |
| `CONFLICT` | Conflict - a general error occurred. |
| `GONE` | The target resource is no longer available and this<br>condition is likely to be permanent. |
| `REQUEST_ENTITY_TOO_LARGE` | Request Entity Too Large - a general error occurred. |
| `UNSUPPORTED_MEDIA_TYPE` | Unsupported Media Type - a general error occurred. |
| `UNPROCESSABLE_ENTITY` | Unprocessable Entity - a general error occurred. |
| `RATE_LIMITED` | Rate Limited - a general error occurred. |
| `NOT_IMPLEMENTED` | Not Implemented - a general error occurred. |
| `BAD_GATEWAY` | Bad Gateway - a general error occurred. |
| `SERVICE_UNAVAILABLE` | Service Unavailable - a general error occurred. |
| `TEMPORARY_ERROR` | A temporary internal error occurred. You can safely retry your call<br>using the same idempotency key. |
| `GATEWAY_TIMEOUT` | Gateway Timeout - a general error occurred. |

