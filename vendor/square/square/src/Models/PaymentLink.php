<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class PaymentLink implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var int
     */
    private $version;

    /**
     * @var array
     */
    private $description = [];

    /**
     * @var string|null
     */
    private $orderId;

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
    private $url;

    /**
     * @var string|null
     */
    private $longUrl;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $updatedAt;

    /**
     * @var array
     */
    private $paymentNote = [];

    /**
     * @param int $version
     */
    public function __construct(int $version)
    {
        $this->version = $version;
    }

    /**
     * Returns Id.
     * The Square-assigned ID of the payment link.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * The Square-assigned ID of the payment link.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Version.
     * The Square-assigned version number, which is incremented each time an update is committed to the
     * payment link.
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The Square-assigned version number, which is incremented each time an update is committed to the
     * payment link.
     *
     * @required
     * @maps version
     */
    public function setVersion(int $version): void
    {
        $this->version = $version;
    }

    /**
     * Returns Description.
     * The optional description of the `payment_link` object.
     * It is primarily for use by your application and is not used anywhere.
     */
    public function getDescription(): ?string
    {
        if (count($this->description) == 0) {
            return null;
        }
        return $this->description['value'];
    }

    /**
     * Sets Description.
     * The optional description of the `payment_link` object.
     * It is primarily for use by your application and is not used anywhere.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description['value'] = $description;
    }

    /**
     * Unsets Description.
     * The optional description of the `payment_link` object.
     * It is primarily for use by your application and is not used anywhere.
     */
    public function unsetDescription(): void
    {
        $this->description = [];
    }

    /**
     * Returns Order Id.
     * The ID of the order associated with the payment link.
     */
    public function getOrderId(): ?string
    {
        return $this->orderId;
    }

    /**
     * Sets Order Id.
     * The ID of the order associated with the payment link.
     *
     * @maps order_id
     */
    public function setOrderId(?string $orderId): void
    {
        $this->orderId = $orderId;
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
     * Returns Url.
     * The shortened URL of the payment link.
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Sets Url.
     * The shortened URL of the payment link.
     *
     * @maps url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * Returns Long Url.
     * The long URL of the payment link.
     */
    public function getLongUrl(): ?string
    {
        return $this->longUrl;
    }

    /**
     * Sets Long Url.
     * The long URL of the payment link.
     *
     * @maps long_url
     */
    public function setLongUrl(?string $longUrl): void
    {
        $this->longUrl = $longUrl;
    }

    /**
     * Returns Created At.
     * The timestamp when the payment link was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp when the payment link was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp when the payment link was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp when the payment link was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Payment Note.
     * An optional note. After Square processes the payment, this note is added to the
     * resulting `Payment`.
     */
    public function getPaymentNote(): ?string
    {
        if (count($this->paymentNote) == 0) {
            return null;
        }
        return $this->paymentNote['value'];
    }

    /**
     * Sets Payment Note.
     * An optional note. After Square processes the payment, this note is added to the
     * resulting `Payment`.
     *
     * @maps payment_note
     */
    public function setPaymentNote(?string $paymentNote): void
    {
        $this->paymentNote['value'] = $paymentNote;
    }

    /**
     * Unsets Payment Note.
     * An optional note. After Square processes the payment, this note is added to the
     * resulting `Payment`.
     */
    public function unsetPaymentNote(): void
    {
        $this->paymentNote = [];
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
        if (isset($this->id)) {
            $json['id']                 = $this->id;
        }
        $json['version']                = $this->version;
        if (!empty($this->description)) {
            $json['description']        = $this->description['value'];
        }
        if (isset($this->orderId)) {
            $json['order_id']           = $this->orderId;
        }
        if (isset($this->checkoutOptions)) {
            $json['checkout_options']   = $this->checkoutOptions;
        }
        if (isset($this->prePopulatedData)) {
            $json['pre_populated_data'] = $this->prePopulatedData;
        }
        if (isset($this->url)) {
            $json['url']                = $this->url;
        }
        if (isset($this->longUrl)) {
            $json['long_url']           = $this->longUrl;
        }
        if (isset($this->createdAt)) {
            $json['created_at']         = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']         = $this->updatedAt;
        }
        if (!empty($this->paymentNote)) {
            $json['payment_note']       = $this->paymentNote['value'];
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
