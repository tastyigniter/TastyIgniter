<?php

namespace Mollie\Api\Resources;

use Mollie\Api\Exceptions\ApiException;
use Mollie\Api\MollieApiClient;
use Mollie\Api\Types\PaymentStatus;
use Mollie\Api\Types\SequenceType;

class Payment extends BaseResource
{
    use HasPresetOptions;

    /**
     * Id of the payment (on the Mollie platform).
     *
     * @var string
     */
    public $id;

    /**
     * Mode of the payment, either "live" or "test" depending on the API Key that was
     * used.
     *
     * @var string
     */
    public $mode;

    /**
     * Amount object containing the value and currency
     *
     * @var \stdClass
     */
    public $amount;

    /**
     * The amount that has been settled containing the value and currency
     *
     * @var \stdClass|null
     */
    public $settlementAmount;

    /**
     * The amount of the payment that has been refunded to the consumer, in EURO with
     * 2 decimals. This field will be null if the payment can not be refunded.
     *
     * @var \stdClass|null
     */
    public $amountRefunded;

    /**
     * The amount of a refunded payment that can still be refunded, in EURO with 2
     * decimals. This field will be null if the payment can not be refunded.
     *
     * For some payment methods this amount can be higher than the payment amount.
     * This is possible to reimburse the costs for a return shipment to your customer
     * for example.
     *
     * @var \stdClass|null
     */
    public $amountRemaining;

    /**
     * The total amount that was charged back for this payment. Only available when the
     * total charged back amount is not zero.
     *
     * @var \stdClass|null
     */
    public $amountChargedBack;

    /**
     * Description of the payment that is shown to the customer during the payment,
     * and possibly on the bank or credit card statement.
     *
     * @var string
     */
    public $description;

    /**
     * If method is empty/null, the customer can pick his/her preferred payment
     * method.
     *
     * @see Method
     * @var string|null
     */
    public $method;

    /**
     * The status of the payment.
     *
     * @var string
     */
    public $status = PaymentStatus::STATUS_OPEN;

    /**
     * UTC datetime the payment was created in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $createdAt;

    /**
     * UTC datetime the payment was paid in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $paidAt;

    /**
     * UTC datetime the payment was canceled in ISO-8601 format.
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $canceledAt;

    /**
     * UTC datetime the payment expired in ISO-8601 format.
     *
     * @var string|null
     */
    public $expiresAt;

    /**
     * UTC datetime the payment failed in ISO-8601 format.
     *
     * @var string|null
     */
    public $failedAt;

    /**
     * $dueDate is used only for banktransfer method
     * The date the payment should expire. Please note: the minimum date is tomorrow and the maximum date is 100 days after tomorrow.
     * UTC due date for the banktransfer payment in ISO-8601 format.
     *
     * @example "2021-01-19"
     * @var string|null
     */
    public $dueDate;

    /**
     * Consumer’s email address, to automatically send the bank transfer details to.
     * Please note: the payment instructions will be sent immediately when creating the payment.
     *
     * @example "user@mollie.com"
     * @var string|null
     * @deprecated 2024-06-01 The billingEmail field is deprecated. Use the "billingAddress" field instead.
     */
    public $billingEmail;

    /**
     * The profile ID this payment belongs to.
     *
     * @example pfl_xH2kP6Nc6X
     * @var string
     */
    public $profileId;

    /**
     * Either "first", "recurring", or "oneoff" for regular payments.
     *
     * @var string|null
     */
    public $sequenceType;

    /**
     * Redirect URL set on this payment
     *
     * @var string
     */
    public $redirectUrl;

    /**
     * Cancel URL set on this payment
     *
     * @var string
     */
    public $cancelUrl;

    /**
     * Webhook URL set on this payment
     *
     * @var string|null
     */
    public $webhookUrl;

    /**
     * The mandate ID this payment is performed with.
     *
     * @example mdt_pXm1g3ND
     * @var string|null
     */
    public $mandateId;

    /**
     * The subscription ID this payment belongs to.
     *
     * @example sub_rVKGtNd6s3
     * @var string|null
     */
    public $subscriptionId;

    /**
     * The order ID this payment belongs to.
     *
     * @example ord_pbjz8x
     * @var string|null
     */
    public $orderId;

    /**
     * The lines contain the actual items the customer bought.
     *
     * @var array|object[]|null
     */
    public $lines;

    /**
     * The person and the address the order is billed to.
     *
     * @var \stdClass|null
     */
    public $billingAddress;

    /**
     * The person and the address the order is shipped to.
     *
     * @var \stdClass|null
     */
    public $shippingAddress;

    /**
     * The settlement ID this payment belongs to.
     *
     * @example stl_jDk30akdN
     * @var string|null
     */
    public $settlementId;

    /**
     * The locale used for this payment.
     *
     * @var string|null
     */
    public $locale;

    /**
     * During creation of the payment you can set custom metadata that is stored with
     * the payment, and given back whenever you retrieve that payment.
     *
     * @var \stdClass|mixed|null
     */
    public $metadata;

    /**
     * Details of a successfully paid payment are set here. For example, the iDEAL
     * payment method will set $details->consumerName and $details->consumerAccount.
     *
     * @var \stdClass|null
     */
    public $details;

    /**
     * Used to restrict the payment methods available to your customer to those from a single country.
     *
     * @var string|null;
     */
    public $restrictPaymentMethodsToCountry;

    /**
     * @var \stdClass
     */
    public $_links;

    /**
     * @var \stdClass[]
     */
    public $_embedded;

    /**
     * Whether or not this payment can be canceled.
     *
     * @var bool|null
     */
    public $isCancelable;

    /**
     * The total amount that is already captured for this payment. Only available
     * when this payment supports captures.
     *
     * @var \stdClass|null
     */
    public $amountCaptured;

    /**
     * Indicates whether the capture will be scheduled automatically or not. Set
     * to manual to capture the payment manually using the Create capture endpoint.
     *
     * Possible values: "automatic", "manual"
     *
     * @var string|null
     */
    public $captureMode;

    /**
     * Indicates the interval to wait before the payment is
     * captured, for example `8 hours` or `2 days. The capture delay
     * will be added to the date and time the payment became authorized.
     *
     * Possible values: ... hours ... days
     * @example 8 hours
     * @var string|null
     */
    public $captureDelay;

    /**
     * UTC datetime on which the merchant has to have captured the payment in
     * ISO-8601 format. This parameter is omitted if the payment is not authorized (yet).
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $captureBefore;

    /**
     * The application fee, if the payment was created with one. Contains amount
     * (the value and currency) and description.
     *
     * @var \stdClass|null
     */
    public $applicationFee;

    /**
     * An optional routing configuration which enables you to route a successful payment,
     * or part of the payment, to one or more connected accounts. Additionally, you can
     * schedule (parts of) the payment to become available on the connected account on a
     * future date.
     *
     * @var array|null
     */
    public $routing;

    /**
     * The date and time the payment became authorized, in ISO 8601 format. This
     * parameter is omitted if the payment is not authorized (yet).
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $authorizedAt;

    /**
     * The date and time the payment was expired, in ISO 8601 format. This
     * parameter is omitted if the payment did not expire (yet).
     *
     * @example "2013-12-25T10:30:54+00:00"
     * @var string|null
     */
    public $expiredAt;

    /**
     * If a customer was specified upon payment creation, the customer’s token will
     * be available here as well.
     *
     * @example cst_XPn78q9CfT
     * @var string|null
     */
    public $customerId;

    /**
     * This optional field contains your customer’s ISO 3166-1 alpha-2 country code,
     * detected by us during checkout. For example: BE. This field is omitted if the
     * country code was not detected.
     *
     * @var string|null
     */
    public $countryCode;

    /**
     * Is this payment canceled?
     *
     * @return bool
     */
    public function isCanceled()
    {
        return $this->status === PaymentStatus::STATUS_CANCELED;
    }

    /**
     * Is this payment expired?
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->status === PaymentStatus::STATUS_EXPIRED;
    }

    /**
     * Is this payment still open / ongoing?
     *
     * @return bool
     */
    public function isOpen()
    {
        return $this->status === PaymentStatus::STATUS_OPEN;
    }

    /**
     * Is this payment pending?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === PaymentStatus::STATUS_PENDING;
    }

    /**
     * Is this payment authorized?
     *
     * @return bool
     */
    public function isAuthorized()
    {
        return $this->status === PaymentStatus::STATUS_AUTHORIZED;
    }

    /**
     * Is this payment paid for?
     *
     * @return bool
     */
    public function isPaid()
    {
        return ! empty($this->paidAt);
    }

    /**
     * Does the payment have refunds
     *
     * @return bool
     */
    public function hasRefunds()
    {
        return ! empty($this->_links->refunds);
    }

    /**
     * Does this payment has chargebacks
     *
     * @return bool
     */
    public function hasChargebacks()
    {
        return ! empty($this->_links->chargebacks);
    }

    /**
     * Is this payment failing?
     *
     * @return bool
     */
    public function isFailed()
    {
        return $this->status === PaymentStatus::STATUS_FAILED;
    }

    /**
     * Check whether 'sequenceType' is set to 'first'. If a 'first' payment has been
     * completed successfully, the consumer's account may be charged automatically
     * using recurring payments.
     *
     * @return bool
     */
    public function hasSequenceTypeFirst()
    {
        return $this->sequenceType === SequenceType::SEQUENCETYPE_FIRST;
    }

    /**
     * Check whether 'sequenceType' is set to 'recurring'. This type of payment is
     * processed without involving
     * the consumer.
     *
     * @return bool
     */
    public function hasSequenceTypeRecurring()
    {
        return $this->sequenceType === SequenceType::SEQUENCETYPE_RECURRING;
    }

    /**
     * Get the checkout URL where the customer can complete the payment.
     *
     * @return string|null
     */
    public function getCheckoutUrl()
    {
        if (empty($this->_links->checkout)) {
            return null;
        }

        return $this->_links->checkout->href;
    }

    /**
     * Get the mobile checkout URL where the customer can complete the payment.
     *
     * @return string|null
     */
    public function getMobileAppCheckoutUrl()
    {
        if (empty($this->_links->mobileAppCheckout)) {
            return null;
        }

        return $this->_links->mobileAppCheckout->href;
    }

    /**
     * @return bool
     */
    public function canBeRefunded()
    {
        return $this->amountRemaining !== null;
    }

    /**
     * @return bool
     */
    public function canBePartiallyRefunded()
    {
        return $this->canBeRefunded();
    }

    /**
     * Get the amount that is already refunded
     *
     * @return float
     */
    public function getAmountRefunded()
    {
        if ($this->amountRefunded) {
            return (float)$this->amountRefunded->value;
        }

        return 0.0;
    }

    /**
     * Get the remaining amount that can be refunded. For some payment methods this
     * amount can be higher than the payment amount. This is possible to reimburse
     * the costs for a return shipment to your customer for example.
     *
     * @return float
     */
    public function getAmountRemaining()
    {
        if ($this->amountRemaining) {
            return (float)$this->amountRemaining->value;
        }

        return 0.0;
    }

    /**
     * Get the total amount that was charged back for this payment. Only available when the
     * total charged back amount is not zero.
     *
     * @return float
     */
    public function getAmountChargedBack()
    {
        if ($this->amountChargedBack) {
            return (float)$this->amountChargedBack->value;
        }

        return 0.0;
    }

    /**
     * Does the payment have split payments
     *
     * @return bool
     */
    public function hasSplitPayments()
    {
        return ! empty($this->routing);
    }

    /**
     * Retrieves all refunds associated with this payment
     *
     * @return RefundCollection
     * @throws ApiException
     */
    public function refunds()
    {
        if (! isset($this->_links->refunds->href)) {
            return new RefundCollection($this->client, 0, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            MollieApiClient::HTTP_GET,
            $this->_links->refunds->href
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->_embedded->refunds,
            Refund::class,
            $result->_links
        );
    }

    /**
     * @param string $refundId
     * @param array $parameters
     *
     * @return Refund
     * @throws ApiException
     */
    public function getRefund($refundId, array $parameters = [])
    {
        return $this->client->paymentRefunds->getFor($this, $refundId, $this->withPresetOptions($parameters));
    }

    /**
     * @param array $parameters
     *
     * @return Refund
     * @throws ApiException
     */
    public function listRefunds(array $parameters = [])
    {
        return $this->client->paymentRefunds->listFor($this, $this->withPresetOptions($parameters));
    }

    /**
     * Retrieves all captures associated with this payment
     *
     * @return CaptureCollection
     * @throws ApiException
     */
    public function captures()
    {
        if (! isset($this->_links->captures->href)) {
            return new CaptureCollection($this->client, 0, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            MollieApiClient::HTTP_GET,
            $this->_links->captures->href
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->_embedded->captures,
            Capture::class,
            $result->_links
        );
    }

    /**
     * @param string $captureId
     * @param array $parameters
     *
     * @return Capture
     * @throws ApiException
     */
    public function getCapture($captureId, array $parameters = [])
    {
        return $this->client->paymentCaptures->getFor(
            $this,
            $captureId,
            $this->withPresetOptions($parameters)
        );
    }

    /**
     * Retrieves all chargebacks associated with this payment
     *
     * @return ChargebackCollection
     * @throws ApiException
     */
    public function chargebacks()
    {
        if (! isset($this->_links->chargebacks->href)) {
            return new ChargebackCollection($this->client, 0, null);
        }

        $result = $this->client->performHttpCallToFullUrl(
            MollieApiClient::HTTP_GET,
            $this->_links->chargebacks->href
        );

        return ResourceFactory::createCursorResourceCollection(
            $this->client,
            $result->_embedded->chargebacks,
            Chargeback::class,
            $result->_links
        );
    }

    /**
     * Retrieves a specific chargeback for this payment.
     *
     * @param string $chargebackId
     * @param array $parameters
     *
     * @return Chargeback
     * @throws ApiException
     */
    public function getChargeback($chargebackId, array $parameters = [])
    {
        return $this->client->paymentChargebacks->getFor(
            $this,
            $chargebackId,
            $this->withPresetOptions($parameters)
        );
    }

    /**
     * Issue a refund for this payment.
     *
     * @param array $data
     *
     * @return \Mollie\Api\Resources\Refund
     * @throws ApiException
     */
    public function refund($data)
    {
        return $this->client->paymentRefunds->createFor($this, $data);
    }

    /**
     * @return \Mollie\Api\Resources\Payment
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function update()
    {
        $body = [
            "description" => $this->description,
            "cancelUrl" => $this->cancelUrl,
            "redirectUrl" => $this->redirectUrl,
            "webhookUrl" => $this->webhookUrl,
            "metadata" => $this->metadata,
            "restrictPaymentMethodsToCountry" => $this->restrictPaymentMethodsToCountry,
            "locale" => $this->locale,
            "dueDate" => $this->dueDate,
        ];

        $result = $this->client->payments->update(
            $this->id,
            $this->withPresetOptions($body)
        );

        return ResourceFactory::createFromApiResult($result, new Payment($this->client));
    }

    /**
     * The total amount that is already captured for this payment. Only available
     * when this payment supports captures.
     *
     * @return float
     */
    public function getAmountCaptured()
    {
        if ($this->amountCaptured) {
            return (float)$this->amountCaptured->value;
        }

        return 0.0;
    }

    /**
     * The amount that has been settled.
     *
     * @return float
     */
    public function getSettlementAmount()
    {
        if ($this->settlementAmount) {
            return (float)$this->settlementAmount->value;
        }

        return 0.0;
    }

    /**
     * The total amount that is already captured for this payment. Only available
     * when this payment supports captures.
     *
     * @return float
     */
    public function getApplicationFeeAmount()
    {
        if ($this->applicationFee) {
            return (float)$this->applicationFee->amount->value;
        }

        return 0.0;
    }
}
