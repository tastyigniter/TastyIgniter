<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates the specific error that occurred during a request to a
 * Square API.
 */
class ErrorCode
{
    /**
     * A general server error occurred.
     */
    public const INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';

    /**
     * A general authorization error occurred.
     */
    public const UNAUTHORIZED = 'UNAUTHORIZED';

    /**
     * The provided access token has expired.
     */
    public const ACCESS_TOKEN_EXPIRED = 'ACCESS_TOKEN_EXPIRED';

    /**
     * The provided access token has been revoked.
     */
    public const ACCESS_TOKEN_REVOKED = 'ACCESS_TOKEN_REVOKED';

    /**
     * The provided client has been disabled.
     */
    public const CLIENT_DISABLED = 'CLIENT_DISABLED';

    /**
     * A general access error occurred.
     */
    public const FORBIDDEN = 'FORBIDDEN';

    /**
     * The provided access token does not have permission
     * to execute the requested action.
     */
    public const INSUFFICIENT_SCOPES = 'INSUFFICIENT_SCOPES';

    /**
     * The calling application was disabled.
     */
    public const APPLICATION_DISABLED = 'APPLICATION_DISABLED';

    /**
     * The calling application was created prior to
     * 2016-03-30 and is not compatible with v2 Square API calls.
     */
    public const V1_APPLICATION = 'V1_APPLICATION';

    /**
     * The calling application is using an access token
     * created prior to 2016-03-30 and is not compatible with v2 Square API
     * calls.
     */
    public const V1_ACCESSTOKEN = 'V1_ACCESS_TOKEN';

    /**
     * The location provided in the API call is not
     * enabled for credit card processing.
     */
    public const CARD_PROCESSING_NOT_ENABLED = 'CARD_PROCESSING_NOT_ENABLED';

    /**
     * A required subscription was not found for the merchant
     */
    public const MERCHANT_SUBSCRIPTION_NOT_FOUND = 'MERCHANT_SUBSCRIPTION_NOT_FOUND';

    /**
     * A general error occurred with the request.
     */
    public const BAD_REQUEST = 'BAD_REQUEST';

    /**
     * The request is missing a required path, query, or
     * body parameter.
     */
    public const MISSING_REQUIRED_PARAMETER = 'MISSING_REQUIRED_PARAMETER';

    /**
     * The value provided in the request is the wrong
     * type. For example, a string instead of an integer.
     */
    public const INCORRECT_TYPE = 'INCORRECT_TYPE';

    /**
     * Formatting for the provided time value is
     * incorrect.
     */
    public const INVALID_TIME = 'INVALID_TIME';

    /**
     * The time range provided in the request is invalid.
     * For example, the end time is before the start time.
     */
    public const INVALID_TIME_RANGE = 'INVALID_TIME_RANGE';

    /**
     * The provided value is invalid. For example,
     * including `%` in a phone number.
     */
    public const INVALID_VALUE = 'INVALID_VALUE';

    /**
     * The pagination cursor included in the request is
     * invalid.
     */
    public const INVALID_CURSOR = 'INVALID_CURSOR';

    /**
     * The query parameters provided is invalid for the
     * requested endpoint.
     */
    public const UNKNOWN_QUERY_PARAMETER = 'UNKNOWN_QUERY_PARAMETER';

    /**
     * One or more of the request parameters conflict with
     * each other.
     */
    public const CONFLICTING_PARAMETERS = 'CONFLICTING_PARAMETERS';

    /**
     * The request body is not a JSON object.
     */
    public const EXPECTED_JSON_BODY = 'EXPECTED_JSON_BODY';

    /**
     * The provided sort order is not a valid key.
     * Currently, sort order must be `ASC` or `DESC`.
     */
    public const INVALID_SORT_ORDER = 'INVALID_SORT_ORDER';

    /**
     * The provided value does not match an expected
     * regular expression.
     */
    public const VALUE_REGEX_MISMATCH = 'VALUE_REGEX_MISMATCH';

    /**
     * The provided string value is shorter than the
     * minimum length allowed.
     */
    public const VALUE_TOO_SHORT = 'VALUE_TOO_SHORT';

    /**
     * The provided string value is longer than the
     * maximum length allowed.
     */
    public const VALUE_TOO_LONG = 'VALUE_TOO_LONG';

    /**
     * The provided value is less than the supported
     * minimum.
     */
    public const VALUE_TOO_LOW = 'VALUE_TOO_LOW';

    /**
     * The provided value is greater than the supported
     * maximum.
     */
    public const VALUE_TOO_HIGH = 'VALUE_TOO_HIGH';

    /**
     * The provided value has a default (empty) value
     * such as a blank string.
     */
    public const VALUE_EMPTY = 'VALUE_EMPTY';

    /**
     * The provided array has too many elements.
     */
    public const ARRAY_LENGTH_TOO_LONG = 'ARRAY_LENGTH_TOO_LONG';

    /**
     * The provided array has too few elements.
     */
    public const ARRAY_LENGTH_TOO_SHORT = 'ARRAY_LENGTH_TOO_SHORT';

    /**
     * The provided array is empty.
     */
    public const ARRAY_EMPTY = 'ARRAY_EMPTY';

    /**
     * The endpoint expected the provided value to be a
     * boolean.
     */
    public const EXPECTED_BOOLEAN = 'EXPECTED_BOOLEAN';

    /**
     * The endpoint expected the provided value to be an
     * integer.
     */
    public const EXPECTED_INTEGER = 'EXPECTED_INTEGER';

    /**
     * The endpoint expected the provided value to be a
     * float.
     */
    public const EXPECTED_FLOAT = 'EXPECTED_FLOAT';

    /**
     * The endpoint expected the provided value to be a
     * string.
     */
    public const EXPECTED_STRING = 'EXPECTED_STRING';

    /**
     * The endpoint expected the provided value to be a
     * JSON object.
     */
    public const EXPECTED_OBJECT = 'EXPECTED_OBJECT';

    /**
     * The endpoint expected the provided value to be an
     * array or list.
     */
    public const EXPECTED_ARRAY = 'EXPECTED_ARRAY';

    /**
     * The endpoint expected the provided value to be a
     * map or associative array.
     */
    public const EXPECTED_MAP = 'EXPECTED_MAP';

    /**
     * The endpoint expected the provided value to be an
     * array encoded in base64.
     */
    public const EXPECTED_BASE64_ENCODED_BYTE_ARRAY = 'EXPECTED_BASE64_ENCODED_BYTE_ARRAY';

    /**
     * One or more objects in the array does not match the
     * array type.
     */
    public const INVALID_ARRAY_VALUE = 'INVALID_ARRAY_VALUE';

    /**
     * The provided static string is not valid for the
     * field.
     */
    public const INVALID_ENUM_VALUE = 'INVALID_ENUM_VALUE';

    /**
     * Invalid content type header.
     */
    public const INVALID_CONTENT_TYPE = 'INVALID_CONTENT_TYPE';

    /**
     * Only relevant for applications created prior to
     * 2016-03-30. Indicates there was an error while parsing form values.
     */
    public const INVALID_FORM_VALUE = 'INVALID_FORM_VALUE';

    /**
     * The provided customer id can't be found in the merchant's customers list.
     */
    public const CUSTOMER_NOT_FOUND = 'CUSTOMER_NOT_FOUND';

    /**
     * A general error occurred.
     */
    public const ONE_INSTRUMENT_EXPECTED = 'ONE_INSTRUMENT_EXPECTED';

    /**
     * A general error occurred.
     */
    public const NO_FIELDS_SET = 'NO_FIELDS_SET';

    /**
     * Too many entries in the map field.
     */
    public const TOO_MANY_MAP_ENTRIES = 'TOO_MANY_MAP_ENTRIES';

    /**
     * The length of one of the provided keys in the map is too short.
     */
    public const MAP_KEY_LENGTH_TOO_SHORT = 'MAP_KEY_LENGTH_TOO_SHORT';

    /**
     * The length of one of the provided keys in the map is too long.
     */
    public const MAP_KEY_LENGTH_TOO_LONG = 'MAP_KEY_LENGTH_TOO_LONG';

    /**
     * The provided customer does not have a recorded name.
     */
    public const CUSTOMER_MISSING_NAME = 'CUSTOMER_MISSING_NAME';

    /**
     * The provided customer does not have a recorded email.
     */
    public const CUSTOMER_MISSING_EMAIL = 'CUSTOMER_MISSING_EMAIL';

    /**
     * The subscription cannot be paused longer than the duration of the current phase.
     */
    public const INVALID_PAUSE_LENGTH = 'INVALID_PAUSE_LENGTH';

    /**
     * The subscription cannot be paused/resumed on the given date.
     */
    public const INVALID_DATE = 'INVALID_DATE';

    /**
     * The API request references an unsupported country.
     */
    public const UNSUPPORTED_COUNTRY = 'UNSUPPORTED_COUNTRY';

    /**
     * The API request references an unsupported currency.
     */
    public const UNSUPPORTED_CURRENCY = 'UNSUPPORTED_CURRENCY';

    /**
     * The card issuer declined the request because the card is expired.
     */
    public const CARD_EXPIRED = 'CARD_EXPIRED';

    /**
     * The expiration date for the payment card is invalid. For example,
     * it indicates a date in the past.
     */
    public const INVALID_EXPIRATION = 'INVALID_EXPIRATION';

    /**
     * The expiration year for the payment card is invalid. For example,
     * it indicates a year in the past or contains invalid characters.
     */
    public const INVALID_EXPIRATION_YEAR = 'INVALID_EXPIRATION_YEAR';

    /**
     * The expiration date for the payment card is invalid. For example,
     * it contains invalid characters.
     */
    public const INVALID_EXPIRATION_DATE = 'INVALID_EXPIRATION_DATE';

    /**
     * The credit card provided is not from a supported issuer.
     */
    public const UNSUPPORTED_CARD_BRAND = 'UNSUPPORTED_CARD_BRAND';

    /**
     * The entry method for the credit card (swipe, dip, tap) is not supported.
     */
    public const UNSUPPORTED_ENTRY_METHOD = 'UNSUPPORTED_ENTRY_METHOD';

    /**
     * The encrypted card information is invalid.
     */
    public const INVALID_ENCRYPTED_CARD = 'INVALID_ENCRYPTED_CARD';

    /**
     * The credit card cannot be validated based on the provided details.
     */
    public const INVALID_CARD = 'INVALID_CARD';

    /**
     * The payment was declined because there was a payment amount mismatch.
     * The money amount Square was expecting does not match the amount provided.
     */
    public const PAYMENT_AMOUNT_MISMATCH = 'PAYMENT_AMOUNT_MISMATCH';

    /**
     * Square received a decline without any additional information.
     * If the payment information seems correct, the buyer can contact their
     * issuer to ask for more information.
     */
    public const GENERIC_DECLINE = 'GENERIC_DECLINE';

    /**
     * The card issuer declined the request because the CVV value is invalid.
     */
    public const CVV_FAILURE = 'CVV_FAILURE';

    /**
     * The card issuer declined the request because the postal code is invalid.
     */
    public const ADDRESS_VERIFICATION_FAILURE = 'ADDRESS_VERIFICATION_FAILURE';

    /**
     * The issuer was not able to locate the account on record.
     */
    public const INVALID_ACCOUNT = 'INVALID_ACCOUNT';

    /**
     * The currency associated with the payment is not valid for the provided
     * funding source. For example, a gift card funded in USD cannot be used to process
     * payments in GBP.
     */
    public const CURRENCY_MISMATCH = 'CURRENCY_MISMATCH';

    /**
     * The funding source has insufficient funds to cover the payment.
     */
    public const INSUFFICIENT_FUNDS = 'INSUFFICIENT_FUNDS';

    /**
     * The Square account does not have the permissions to accept
     * this payment. For example, Square may limit which merchants are
     * allowed to receive gift card payments.
     */
    public const INSUFFICIENT_PERMISSIONS = 'INSUFFICIENT_PERMISSIONS';

    /**
     * The card issuer has declined the transaction due to restrictions on where the card can be used.
     * For example, a gift card is limited to a single merchant.
     */
    public const CARDHOLDER_INSUFFICIENT_PERMISSIONS = 'CARDHOLDER_INSUFFICIENT_PERMISSIONS';

    /**
     * The Square account cannot take payments in the specified region.
     * A Square account can take payments only from the region where the account was created.
     */
    public const INVALID_LOCATION = 'INVALID_LOCATION';

    /**
     * The card issuer has determined the payment amount is either too high or too low.
     * The API returns the error code mostly for credit cards (for example, the card reached
     * the credit limit). However, sometimes the issuer bank can indicate the error for debit
     * or prepaid cards (for example, card has insufficient funds).
     */
    public const TRANSACTION_LIMIT = 'TRANSACTION_LIMIT';

    /**
     * The card issuer declined the request because the issuer requires voice authorization from the
     * cardholder. The seller should ask the customer to contact the card issuing bank to authorize the
     * payment.
     */
    public const VOICE_FAILURE = 'VOICE_FAILURE';

    /**
     * The specified card number is invalid. For example, it is of
     * incorrect length or is incorrectly formatted.
     */
    public const PAN_FAILURE = 'PAN_FAILURE';

    /**
     * The card expiration date is either invalid or indicates that the
     * card is expired.
     */
    public const EXPIRATION_FAILURE = 'EXPIRATION_FAILURE';

    /**
     * The card is not supported either in the geographic region or by
     * the [merchant category code](https://developer.squareup.com/docs/locations-api#initialize-a-merchant-
     * category-code) (MCC).
     */
    public const CARD_NOT_SUPPORTED = 'CARD_NOT_SUPPORTED';

    /**
     * The card issuer declined the request because the PIN is invalid.
     */
    public const INVALID_PIN = 'INVALID_PIN';

    /**
     * The payment is missing a required PIN.
     */
    public const MISSING_PIN = 'MISSING_PIN';

    /**
     * The payment is missing a required ACCOUNT_TYPE parameter.
     */
    public const MISSING_ACCOUNT_TYPE = 'MISSING_ACCOUNT_TYPE';

    /**
     * The postal code is incorrectly formatted.
     */
    public const INVALID_POSTAL_CODE = 'INVALID_POSTAL_CODE';

    /**
     * The app_fee_money on a payment is too high.
     */
    public const INVALID_FEES = 'INVALID_FEES';

    /**
     * The card must be swiped, tapped, or dipped. Payments attempted by manually entering the card number
     * are declined.
     */
    public const MANUALLY_ENTERED_PAYMENT_NOT_SUPPORTED = 'MANUALLY_ENTERED_PAYMENT_NOT_SUPPORTED';

    /**
     * Square declined the request because the payment amount exceeded the processing limit for this
     * merchant.
     */
    public const PAYMENT_LIMIT_EXCEEDED = 'PAYMENT_LIMIT_EXCEEDED';

    /**
     * When a Gift Card is a payment source, you can allow taking a partial payment
     * by adding the `accept_partial_authorization` parameter in the request.
     * However, taking such a partial payment does not work if your request also includes
     * `tip_money`, `app_fee_money`, or both. Square declines such payments and returns
     * the `GIFT_CARD_AVAILABLE_AMOUNT` error.
     * For more information, see
     * [CreatePayment errors (additional information)](https://developer.squareup.com/docs/payments-
     * api/error-codes#createpayment-errors-additional-information).
     */
    public const GIFT_CARD_AVAILABLE_AMOUNT = 'GIFT_CARD_AVAILABLE_AMOUNT';

    /**
     * The account provided cannot carry out transactions.
     */
    public const ACCOUNT_UNUSABLE = 'ACCOUNT_UNUSABLE';

    /**
     * Bank account rejected or was not authorized for the payment.
     */
    public const BUYER_REFUSED_PAYMENT = 'BUYER_REFUSED_PAYMENT';

    /**
     * The application tried to update a delayed-capture payment that has expired.
     */
    public const DELAYED_TRANSACTION_EXPIRED = 'DELAYED_TRANSACTION_EXPIRED';

    /**
     * The application tried to cancel a delayed-capture payment that was already cancelled.
     */
    public const DELAYED_TRANSACTION_CANCELED = 'DELAYED_TRANSACTION_CANCELED';

    /**
     * The application tried to capture a delayed-capture payment that was already captured.
     */
    public const DELAYED_TRANSACTION_CAPTURED = 'DELAYED_TRANSACTION_CAPTURED';

    /**
     * The application tried to update a delayed-capture payment that failed.
     */
    public const DELAYED_TRANSACTION_FAILED = 'DELAYED_TRANSACTION_FAILED';

    /**
     * The provided card token (nonce) has expired.
     */
    public const CARD_TOKEN_EXPIRED = 'CARD_TOKEN_EXPIRED';

    /**
     * The provided card token (nonce) was already used to process the payment or refund.
     */
    public const CARD_TOKEN_USED = 'CARD_TOKEN_USED';

    /**
     * The requested payment amount is too high for the provided payment source.
     */
    public const AMOUNT_TOO_HIGH = 'AMOUNT_TOO_HIGH';

    /**
     * The API request references an unsupported instrument type.
     */
    public const UNSUPPORTED_INSTRUMENT_TYPE = 'UNSUPPORTED_INSTRUMENT_TYPE';

    /**
     * The requested refund amount exceeds the amount available to refund.
     */
    public const REFUND_AMOUNT_INVALID = 'REFUND_AMOUNT_INVALID';

    /**
     * The payment already has a pending refund.
     */
    public const REFUND_ALREADY_PENDING = 'REFUND_ALREADY_PENDING';

    /**
     * The payment is not refundable. For example, the payment has been disputed and is no longer eligible
     * for
     * refunds.
     */
    public const PAYMENT_NOT_REFUNDABLE = 'PAYMENT_NOT_REFUNDABLE';

    /**
     * Request failed - The card issuer declined the refund.
     */
    public const REFUND_DECLINED = 'REFUND_DECLINED';

    /**
     * The Square account does not have the permissions to process this refund.
     */
    public const INSUFFICIENT_PERMISSIONS_FOR_REFUND = 'INSUFFICIENT_PERMISSIONS_FOR_REFUND';

    /**
     * Generic error - the provided card data is invalid.
     */
    public const INVALID_CARD_DATA = 'INVALID_CARD_DATA';

    /**
     * The provided source id was already used to create a card.
     */
    public const SOURCE_USED = 'SOURCE_USED';

    /**
     * The provided source id has expired.
     */
    public const SOURCE_EXPIRED = 'SOURCE_EXPIRED';

    /**
     * The referenced loyalty program reward tier is not supported.
     * This could happen if the reward tier created in a first party
     * application is incompatible with the Loyalty API.
     */
    public const UNSUPPORTED_LOYALTY_REWARD_TIER = 'UNSUPPORTED_LOYALTY_REWARD_TIER';

    /**
     * Generic error - the given location does not matching what is expected.
     */
    public const LOCATION_MISMATCH = 'LOCATION_MISMATCH';

    /**
     * The provided idempotency key has already been used.
     */
    public const IDEMPOTENCY_KEY_REUSED = 'IDEMPOTENCY_KEY_REUSED';

    /**
     * General error - the value provided was unexpected.
     */
    public const UNEXPECTED_VALUE = 'UNEXPECTED_VALUE';

    /**
     * The API request is not supported in sandbox.
     */
    public const SANDBOX_NOT_SUPPORTED = 'SANDBOX_NOT_SUPPORTED';

    /**
     * The provided email address is invalid.
     */
    public const INVALID_EMAIL_ADDRESS = 'INVALID_EMAIL_ADDRESS';

    /**
     * The provided phone number is invalid.
     */
    public const INVALID_PHONE_NUMBER = 'INVALID_PHONE_NUMBER';

    /**
     * The provided checkout URL has expired.
     */
    public const CHECKOUT_EXPIRED = 'CHECKOUT_EXPIRED';

    /**
     * Bad certificate.
     */
    public const BAD_CERTIFICATE = 'BAD_CERTIFICATE';

    /**
     * The provided Square-Version is incorrectly formatted.
     */
    public const INVALID_SQUARE_VERSION_FORMAT = 'INVALID_SQUARE_VERSION_FORMAT';

    /**
     * The provided Square-Version is incompatible with the requested action.
     */
    public const API_VERSION_INCOMPATIBLE = 'API_VERSION_INCOMPATIBLE';

    /**
     * The transaction requires that a card be present.
     */
    public const CARD_PRESENCE_REQUIRED = 'CARD_PRESENCE_REQUIRED';

    /**
     * The API request references an unsupported source type.
     */
    public const UNSUPPORTED_SOURCE_TYPE = 'UNSUPPORTED_SOURCE_TYPE';

    /**
     * The provided card does not match what is expected.
     */
    public const CARD_MISMATCH = 'CARD_MISMATCH';

    /**
     * The card was declined.
     */
    public const CARD_DECLINED = 'CARD_DECLINED';

    /**
     * The CVV could not be verified.
     */
    public const VERIFY_CVV_FAILURE = 'VERIFY_CVV_FAILURE';

    /**
     * The AVS could not be verified.
     */
    public const VERIFY_AVS_FAILURE = 'VERIFY_AVS_FAILURE';

    /**
     * The payment card was declined with a request
     * for the card holder to call the issuer.
     */
    public const CARD_DECLINED_CALL_ISSUER = 'CARD_DECLINED_CALL_ISSUER';

    /**
     * The payment card was declined with a request
     * for additional verification.
     */
    public const CARD_DECLINED_VERIFICATION_REQUIRED = 'CARD_DECLINED_VERIFICATION_REQUIRED';

    /**
     * The card expiration date is either missing or
     * incorrectly formatted.
     */
    public const BAD_EXPIRATION = 'BAD_EXPIRATION';

    /**
     * The card issuer requires that the card be read
     * using a chip reader.
     */
    public const CHIP_INSERTION_REQUIRED = 'CHIP_INSERTION_REQUIRED';

    /**
     * The card has exhausted its available pin entry
     * retries set by the card issuer. Resolving the error typically requires the
     * card holder to contact the card issuer.
     */
    public const ALLOWABLE_PIN_TRIES_EXCEEDED = 'ALLOWABLE_PIN_TRIES_EXCEEDED';

    /**
     * The card issuer declined the refund.
     */
    public const RESERVATION_DECLINED = 'RESERVATION_DECLINED';

    /**
     * The body parameter is not recognized by the requested endpoint.
     */
    public const UNKNOWN_BODY_PARAMETER = 'UNKNOWN_BODY_PARAMETER';

    /**
     * Not Found - a general error occurred.
     */
    public const NOT_FOUND = 'NOT_FOUND';

    /**
     * Square could not find the associated Apple Pay certificate.
     */
    public const APPLE_PAYMENT_PROCESSING_CERTIFICATE_HASH_NOT_FOUND =
        'APPLE_PAYMENT_PROCESSING_CERTIFICATE_HASH_NOT_FOUND';

    /**
     * Method Not Allowed - a general error occurred.
     */
    public const METHOD_NOT_ALLOWED = 'METHOD_NOT_ALLOWED';

    /**
     * Not Acceptable - a general error occurred.
     */
    public const NOT_ACCEPTABLE = 'NOT_ACCEPTABLE';

    /**
     * Request Timeout - a general error occurred.
     */
    public const REQUEST_TIMEOUT = 'REQUEST_TIMEOUT';

    /**
     * Conflict - a general error occurred.
     */
    public const CONFLICT = 'CONFLICT';

    /**
     * The target resource is no longer available and this
     * condition is likely to be permanent.
     */
    public const GONE = 'GONE';

    /**
     * Request Entity Too Large - a general error occurred.
     */
    public const REQUEST_ENTITY_TOO_LARGE = 'REQUEST_ENTITY_TOO_LARGE';

    /**
     * Unsupported Media Type - a general error occurred.
     */
    public const UNSUPPORTED_MEDIA_TYPE = 'UNSUPPORTED_MEDIA_TYPE';

    /**
     * Unprocessable Entity - a general error occurred.
     */
    public const UNPROCESSABLE_ENTITY = 'UNPROCESSABLE_ENTITY';

    /**
     * Rate Limited - a general error occurred.
     */
    public const RATE_LIMITED = 'RATE_LIMITED';

    /**
     * Not Implemented - a general error occurred.
     */
    public const NOT_IMPLEMENTED = 'NOT_IMPLEMENTED';

    /**
     * Bad Gateway - a general error occurred.
     */
    public const BAD_GATEWAY = 'BAD_GATEWAY';

    /**
     * Service Unavailable - a general error occurred.
     */
    public const SERVICE_UNAVAILABLE = 'SERVICE_UNAVAILABLE';

    /**
     * A temporary internal error occurred. You can safely retry your call
     * using the same idempotency key.
     */
    public const TEMPORARY_ERROR = 'TEMPORARY_ERROR';

    /**
     * Gateway Timeout - a general error occurred.
     */
    public const GATEWAY_TIMEOUT = 'GATEWAY_TIMEOUT';
}
