<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CreatePaymentLinkRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $idempotencyKey;

    /**
     * @var string|null
     */
    private $description;

    /**
     * @var QuickPay|null
     */
    private $quickPay;

    /**
     * @var Order|null
     */
    private $order;

    /**
     * @var CheckoutOptions|null
     */
    private $checkoutOptions;

    /**
     * @var PrePopulatedData|null
     */
    private $prePopulatedData;

    /**
     * @var string|null
     */
    private $paymentNote;

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this `CreatePaymentLinkRequest` request.
     * If you do not provide a unique string (or provide an empty string as the value),
     * the endpoint treats each request as independent.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this `CreatePaymentLinkRequest` request.
     * If you do not provide a unique string (or provide an empty string as the value),
     * the endpoint treats each request as independent.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Description.
     * A description of the payment link. You provide this optional description that is useful in your
     * application context. It is not used anywhere.
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Sets Description.
     * A description of the payment link. You provide this optional description that is useful in your
     * application context. It is not used anywhere.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * Returns Quick Pay.
     * Describes an ad hoc item and price to generate a quick pay checkout link.
     * For more information,
     * see [Quick Pay Checkout](https://developer.squareup.com/docs/checkout-api/quick-pay-checkout).
     */
    public function getQuickPay(): ?QuickPay
    {
        return $this->quickPay;
    }

    /**
     * Sets Quick Pay.
     * Describes an ad hoc item and price to generate a quick pay checkout link.
     * For more information,
     * see [Quick Pay Checkout](https://developer.squareup.com/docs/checkout-api/quick-pay-checkout).
     *
     * @maps quick_pay
     */
    public function setQuickPay(?QuickPay $quickPay): void
    {
        $this->quickPay = $quickPay;
    }

    /**
     * Returns Order.
     * Contains all information related to a single order to process with Square,
     * including line items that specify the products to purchase. `Order` objects also
     * include information about any associated tenders, refunds, and returns.
     *
     * All Connect V2 Transactions have all been converted to Orders including all associated
     * itemization data.
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * Sets Order.
     * Contains all information related to a single order to process with Square,
     * including line items that specify the products to purchase. `Order` objects also
     * include information about any associated tenders, refunds, and returns.
     *
     * All Connect V2 Transactions have all been converted to Orders including all associated
     * itemization data.
     *
     * @maps order
     */
    public function setOrder(?Order $order): void
    {
        $this->order = $order;
    }

    /**
     * Returns Checkout Options.
     */
    public function getCheckoutOptions(): ?CheckoutOptions
    {
        return $this->checkoutOptions;
    }

    /**
     * Sets Checkout Options.
     *
     * @maps checkout_options
     */
    public function setCheckoutOptions(?CheckoutOptions $checkoutOptions): void
    {
        $this->checkoutOptions = $checkoutOptions;
    }

    /**
     * Returns Pre Populated Data.
     * Describes buyer data to prepopulate in the payment form.
     * For more information,
     * see [Optional Checkout Configurations](https://developer.squareup.com/docs/checkout-api/optional-
     * checkout-configurations).
     */
    public function getPrePopulatedData(): ?PrePopulatedData
    {
        return $this->prePopulatedData;
    }

    /**
     * Sets Pre Populated Data.
     * Describes buyer data to prepopulate in the payment form.
     * For more information,
     * see [Optional Checkout Configurations](https://developer.squareup.com/docs/checkout-api/optional-
     * checkout-configurations).
     *
     * @maps pre_populated_data
     */
    public function setPrePopulatedData(?PrePopulatedData $prePopulatedData): void
    {
        $this->prePopulatedData = $prePopulatedData;
    }

    /**
     * Returns Payment Note.
     * A note for the payment. After processing the payment, Square adds this note to the resulting
     * `Payment`.
     */
    public function getPaymentNote(): ?string
    {
        return $this->paymentNote;
    }

    /**
     * Sets Payment Note.
     * A note for the payment. After processing the payment, Square adds this note to the resulting
     * `Payment`.
     *
     * @maps payment_note
     */
    public function setPaymentNote(?string $paymentNote): void
    {
        $this->paymentNote = $paymentNote;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        if (isset($this->idempotencyKey)) {
            $json['idempotency_key']    = $this->idempotencyKey;
        }
        if (isset($this->description)) {
            $json['description']        = $this->description;
        }
        if (isset($this->quickPay)) {
            $json['quick_pay']          = $this->quickPay;
        }
        if (isset($this->order)) {
            $json['order']              = $this->order;
        }
        if (isset($this->checkoutOptions)) {
            $json['checkout_options']   = $this->checkoutOptions;
        }
        if (isset($this->prePopulatedData)) {
            $json['pre_populated_data'] = $this->prePopulatedData;
        }
        if (isset($this->paymentNote)) {
            $json['payment_note']       = $this->paymentNote;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
