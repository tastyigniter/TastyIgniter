<?php

namespace Mollie\Api\Types;

class PaymentMethodStatus
{
    /**
     * The payment method is activated and ready for use.
     *
     * @link https://docs.mollie.com/reference/v2/methods-api/get-method#parameters
     */
    public const ACTIVATED = "activated";

    /**
     * Mollie is waiting for you to finish onboarding in the Merchant Dashboard before
     * the payment method can be activated.
     *
     * @link https://docs.mollie.com/reference/v2/methods-api/get-method#parameters
     */
    public const PENDING_BOARDING = "pending-boarding";

    /**
     * Mollie needs to review your request for this payment method before it can be activated.
     *
     * @link https://docs.mollie.com/reference/v2/methods-api/get-method#parameters
     */
    public const PENDING_REVIEW = "pending-review";

    /**
     * Activation of this payment method relies on you taking action with an external party,
     * for example signing up with PayPal or a giftcard issuer.
     *
     * @link https://docs.mollie.com/reference/v2/methods-api/get-method#parameters
     */
    public const PENDING_EXTERNAL = "pending-external";

    /**
     * Your request for this payment method was rejected.
     * Whenever Mollie rejects such a request, you will always be informed via email.
     *
     * @link https://docs.mollie.com/reference/v2/methods-api/get-method#parameters
     */
    public const REJECTED = "rejected";

    /**
     * This payment method was not requested.
     *
     * @link https://docs.mollie.com/reference/v2/methods-api/get-method#parameters
     */
    public const NOT_REQUESTED = null;
}
