<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the parameters that can be included in the body of
 * a request to the `CreateCheckout` endpoint.
 */
class CreateCheckoutRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $idempotencyKey;

    /**
     * @var CreateOrderRequest
     */
    private $order;

    /**
     * @var bool|null
     */
    private $askForShippingAddress;

    /**
     * @var string|null
     */
    private $merchantSupportEmail;

    /**
     * @var string|null
     */
    private $prePopulateBuyerEmail;

    /**
     * @var Address|null
     */
    private $prePopulateShippingAddress;

    /**
     * @var string|null
     */
    private $redirectUrl;

    /**
     * @var ChargeRequestAdditionalRecipient[]|null
     */
    private $additionalRecipients;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @param string $idempotencyKey
     * @param CreateOrderRequest $order
     */
    public function __construct(string $idempotencyKey, CreateOrderRequest $order)
    {
        $this->idempotencyKey = $idempotencyKey;
        $this->order = $order;
    }

    /**
     * Returns Idempotency Key.
     * A unique string that identifies this checkout among others you have created. It can be
     * any valid string but must be unique for every order sent to Square Checkout for a given location ID.
     *
     * The idempotency key is used to avoid processing the same order more than once. If you are
     * unsure whether a particular checkout was created successfully, you can attempt it again with
     * the same idempotency key and all the same other parameters without worrying about creating
     * duplicates.
     *
     * You should use a random number/string generator native to the language
     * you are working in to generate strings for your idempotency keys.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     */
    public function getIdempotencyKey(): string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * A unique string that identifies this checkout among others you have created. It can be
     * any valid string but must be unique for every order sent to Square Checkout for a given location ID.
     *
     * The idempotency key is used to avoid processing the same order more than once. If you are
     * unsure whether a particular checkout was created successfully, you can attempt it again with
     * the same idempotency key and all the same other parameters without worrying about creating
     * duplicates.
     *
     * You should use a random number/string generator native to the language
     * you are working in to generate strings for your idempotency keys.
     *
     * For more information, see [Idempotency](https://developer.squareup.com/docs/working-with-
     * apis/idempotency).
     *
     * @required
     * @maps idempotency_key
     */
    public function setIdempotencyKey(string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Order.
     */
    public function getOrder(): CreateOrderRequest
    {
        return $this->order;
    }

    /**
     * Sets Order.
     *
     * @required
     * @maps order
     */
    public function setOrder(CreateOrderRequest $order): void
    {
        $this->order = $order;
    }

    /**
     * Returns Ask for Shipping Address.
     * If `true`, Square Checkout collects shipping information on your behalf and stores
     * that information with the transaction information in the Square Seller Dashboard.
     *
     * Default: `false`.
     */
    public function getAskForShippingAddress(): ?bool
    {
        return $this->askForShippingAddress;
    }

    /**
     * Sets Ask for Shipping Address.
     * If `true`, Square Checkout collects shipping information on your behalf and stores
     * that information with the transaction information in the Square Seller Dashboard.
     *
     * Default: `false`.
     *
     * @maps ask_for_shipping_address
     */
    public function setAskForShippingAddress(?bool $askForShippingAddress): void
    {
        $this->askForShippingAddress = $askForShippingAddress;
    }

    /**
     * Returns Merchant Support Email.
     * The email address to display on the Square Checkout confirmation page
     * and confirmation email that the buyer can use to contact the seller.
     *
     * If this value is not set, the confirmation page and email display the
     * primary email address associated with the seller's Square account.
     *
     * Default: none; only exists if explicitly set.
     */
    public function getMerchantSupportEmail(): ?string
    {
        return $this->merchantSupportEmail;
    }

    /**
     * Sets Merchant Support Email.
     * The email address to display on the Square Checkout confirmation page
     * and confirmation email that the buyer can use to contact the seller.
     *
     * If this value is not set, the confirmation page and email display the
     * primary email address associated with the seller's Square account.
     *
     * Default: none; only exists if explicitly set.
     *
     * @maps merchant_support_email
     */
    public function setMerchantSupportEmail(?string $merchantSupportEmail): void
    {
        $this->merchantSupportEmail = $merchantSupportEmail;
    }

    /**
     * Returns Pre Populate Buyer Email.
     * If provided, the buyer's email is prepopulated on the checkout page
     * as an editable text field.
     *
     * Default: none; only exists if explicitly set.
     */
    public function getPrePopulateBuyerEmail(): ?string
    {
        return $this->prePopulateBuyerEmail;
    }

    /**
     * Sets Pre Populate Buyer Email.
     * If provided, the buyer's email is prepopulated on the checkout page
     * as an editable text field.
     *
     * Default: none; only exists if explicitly set.
     *
     * @maps pre_populate_buyer_email
     */
    public function setPrePopulateBuyerEmail(?string $prePopulateBuyerEmail): void
    {
        $this->prePopulateBuyerEmail = $prePopulateBuyerEmail;
    }

    /**
     * Returns Pre Populate Shipping Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     */
    public function getPrePopulateShippingAddress(): ?Address
    {
        return $this->prePopulateShippingAddress;
    }

    /**
     * Sets Pre Populate Shipping Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     *
     * @maps pre_populate_shipping_address
     */
    public function setPrePopulateShippingAddress(?Address $prePopulateShippingAddress): void
    {
        $this->prePopulateShippingAddress = $prePopulateShippingAddress;
    }

    /**
     * Returns Redirect Url.
     * The URL to redirect to after the checkout is completed with `checkoutId`,
     * `transactionId`, and `referenceId` appended as URL parameters. For example,
     * if the provided redirect URL is `http://www.example.com/order-complete`, a
     * successful transaction redirects the customer to:
     *
     * `http://www.example.com/order-complete?checkoutId=xxxxxx&amp;referenceId=xxxxxx&amp;
     * transactionId=xxxxxx`
     *
     * If you do not provide a redirect URL, Square Checkout displays an order
     * confirmation page on your behalf; however, it is strongly recommended that
     * you provide a redirect URL so you can verify the transaction results and
     * finalize the order through your existing/normal confirmation workflow.
     *
     * Default: none; only exists if explicitly set.
     */
    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    /**
     * Sets Redirect Url.
     * The URL to redirect to after the checkout is completed with `checkoutId`,
     * `transactionId`, and `referenceId` appended as URL parameters. For example,
     * if the provided redirect URL is `http://www.example.com/order-complete`, a
     * successful transaction redirects the customer to:
     *
     * `http://www.example.com/order-complete?checkoutId=xxxxxx&amp;referenceId=xxxxxx&amp;
     * transactionId=xxxxxx`
     *
     * If you do not provide a redirect URL, Square Checkout displays an order
     * confirmation page on your behalf; however, it is strongly recommended that
     * you provide a redirect URL so you can verify the transaction results and
     * finalize the order through your existing/normal confirmation workflow.
     *
     * Default: none; only exists if explicitly set.
     *
     * @maps redirect_url
     */
    public function setRedirectUrl(?string $redirectUrl): void
    {
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * Returns Additional Recipients.
     * The basic primitive of a multi-party transaction. The value is optional.
     * The transaction facilitated by you can be split from here.
     *
     * If you provide this value, the `amount_money` value in your `additional_recipients` field
     * cannot be more than 90% of the `total_money` calculated by Square for your order.
     * The `location_id` must be a valid seller location where the checkout is occurring.
     *
     * This field requires `PAYMENTS_WRITE_ADDITIONAL_RECIPIENTS` OAuth permission.
     *
     * This field is currently not supported in the Square Sandbox.
     *
     * @return ChargeRequestAdditionalRecipient[]|null
     */
    public function getAdditionalRecipients(): ?array
    {
        return $this->additionalRecipients;
    }

    /**
     * Sets Additional Recipients.
     * The basic primitive of a multi-party transaction. The value is optional.
     * The transaction facilitated by you can be split from here.
     *
     * If you provide this value, the `amount_money` value in your `additional_recipients` field
     * cannot be more than 90% of the `total_money` calculated by Square for your order.
     * The `location_id` must be a valid seller location where the checkout is occurring.
     *
     * This field requires `PAYMENTS_WRITE_ADDITIONAL_RECIPIENTS` OAuth permission.
     *
     * This field is currently not supported in the Square Sandbox.
     *
     * @maps additional_recipients
     *
     * @param ChargeRequestAdditionalRecipient[]|null $additionalRecipients
     */
    public function setAdditionalRecipients(?array $additionalRecipients): void
    {
        $this->additionalRecipients = $additionalRecipients;
    }

    /**
     * Returns Note.
     * An optional note to associate with the `checkout` object.
     *
     * This value cannot exceed 60 characters.
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * Sets Note.
     * An optional note to associate with the `checkout` object.
     *
     * This value cannot exceed 60 characters.
     *
     * @maps note
     */
    public function setNote(?string $note): void
    {
        $this->note = $note;
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
        $json['idempotency_key']                   = $this->idempotencyKey;
        $json['order']                             = $this->order;
        if (isset($this->askForShippingAddress)) {
            $json['ask_for_shipping_address']      = $this->askForShippingAddress;
        }
        if (isset($this->merchantSupportEmail)) {
            $json['merchant_support_email']        = $this->merchantSupportEmail;
        }
        if (isset($this->prePopulateBuyerEmail)) {
            $json['pre_populate_buyer_email']      = $this->prePopulateBuyerEmail;
        }
        if (isset($this->prePopulateShippingAddress)) {
            $json['pre_populate_shipping_address'] = $this->prePopulateShippingAddress;
        }
        if (isset($this->redirectUrl)) {
            $json['redirect_url']                  = $this->redirectUrl;
        }
        if (isset($this->additionalRecipients)) {
            $json['additional_recipients']         = $this->additionalRecipients;
        }
        if (isset($this->note)) {
            $json['note']                          = $this->note;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
