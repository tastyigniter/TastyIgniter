<?php

declare(strict_types=1);

namespace Square\Models;

/**
 * Indicates which high-level category of error has occurred during a
 * request to the Connect API.
 */
class ErrorCategory
{
    /**
     * An error occurred with the Connect API itself.
     */
    public const API_ERROR = 'API_ERROR';

    /**
     * An authentication error occurred. Most commonly, the request had
     * a missing, malformed, or otherwise invalid `Authorization` header.
     */
    public const AUTHENTICATION_ERROR = 'AUTHENTICATION_ERROR';

    /**
     * The request was invalid. Most commonly, a required parameter was
     * missing, or a provided parameter had an invalid value.
     */
    public const INVALID_REQUEST_ERROR = 'INVALID_REQUEST_ERROR';

    /**
     * Your application reached the Square API rate limit. You might receive this error if your application
     * sends a high number of requests
     * to Square APIs in a short period of time.
     *
     * Your application should monitor responses for `429 RATE_LIMITED` errors and use a retry mechanism
     * with an [exponential backoff](https://en.wikipedia.org/wiki/Exponential_backoff)
     * schedule to resend the requests at an increasingly slower rate. It is also a good practice to use a
     * randomized delay (jitter) in your retry schedule.
     */
    public const RATE_LIMIT_ERROR = 'RATE_LIMIT_ERROR';

    /**
     * An error occurred while processing a payment method. Most commonly,
     * the details of the payment method were invalid (such as a card's CVV
     * or expiration date).
     */
    public const PAYMENT_METHOD_ERROR = 'PAYMENT_METHOD_ERROR';

    /**
     * An error occurred while attempting to process a refund.
     */
    public const REFUND_ERROR = 'REFUND_ERROR';

    /**
     * An error occurred when checking a merchant subscription status
     */
    public const MERCHANT_SUBSCRIPTION_ERROR = 'MERCHANT_SUBSCRIPTION_ERROR';
}
