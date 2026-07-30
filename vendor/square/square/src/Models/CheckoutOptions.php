<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class CheckoutOptions implements \JsonSerializable
{
    /**
     * @var array
     */
    private $allowTipping = [];

    /**
     * @var array
     */
    private $customFields = [];

    /**
     * @var array
     */
    private $subscriptionPlanId = [];

    /**
     * @var array
     */
    private $redirectUrl = [];

    /**
     * @var array
     */
    private $merchantSupportEmail = [];

    /**
     * @var array
     */
    private $askForShippingAddress = [];

    /**
     * @var AcceptedPaymentMethods|null
     */
    private $acceptedPaymentMethods;

    /**
     * @var Money|null
     */
    private $appFeeMoney;

    /**
     * @var ShippingFee|null
     */
    private $shippingFee;

    /**
     * Returns Allow Tipping.
     * Indicates whether the payment allows tipping.
     */
    public function getAllowTipping(): ?bool
    {
        if (count($this->allowTipping) == 0) {
            return null;
        }
        return $this->allowTipping['value'];
    }

    /**
     * Sets Allow Tipping.
     * Indicates whether the payment allows tipping.
     *
     * @maps allow_tipping
     */
    public function setAllowTipping(?bool $allowTipping): void
    {
        $this->allowTipping['value'] = $allowTipping;
    }

    /**
     * Unsets Allow Tipping.
     * Indicates whether the payment allows tipping.
     */
    public function unsetAllowTipping(): void
    {
        $this->allowTipping = [];
    }

    /**
     * Returns Custom Fields.
     * The custom fields requesting information from the buyer.
     *
     * @return CustomField[]|null
     */
    public function getCustomFields(): ?array
    {
        if (count($this->customFields) == 0) {
            return null;
        }
        return $this->customFields['value'];
    }

    /**
     * Sets Custom Fields.
     * The custom fields requesting information from the buyer.
     *
     * @maps custom_fields
     *
     * @param CustomField[]|null $customFields
     */
    public function setCustomFields(?array $customFields): void
    {
        $this->customFields['value'] = $customFields;
    }

    /**
     * Unsets Custom Fields.
     * The custom fields requesting information from the buyer.
     */
    public function unsetCustomFields(): void
    {
        $this->customFields = [];
    }

    /**
     * Returns Subscription Plan Id.
     * The ID of the subscription plan for the buyer to pay and subscribe.
     * For more information, see [Subscription Plan Checkout](https://developer.squareup.com/docs/checkout-
     * api/subscription-plan-checkout).
     */
    public function getSubscriptionPlanId(): ?string
    {
        if (count($this->subscriptionPlanId) == 0) {
            return null;
        }
        return $this->subscriptionPlanId['value'];
    }

    /**
     * Sets Subscription Plan Id.
     * The ID of the subscription plan for the buyer to pay and subscribe.
     * For more information, see [Subscription Plan Checkout](https://developer.squareup.com/docs/checkout-
     * api/subscription-plan-checkout).
     *
     * @maps subscription_plan_id
     */
    public function setSubscriptionPlanId(?string $subscriptionPlanId): void
    {
        $this->subscriptionPlanId['value'] = $subscriptionPlanId;
    }

    /**
     * Unsets Subscription Plan Id.
     * The ID of the subscription plan for the buyer to pay and subscribe.
     * For more information, see [Subscription Plan Checkout](https://developer.squareup.com/docs/checkout-
     * api/subscription-plan-checkout).
     */
    public function unsetSubscriptionPlanId(): void
    {
        $this->subscriptionPlanId = [];
    }

    /**
     * Returns Redirect Url.
     * The confirmation page URL to redirect the buyer to after Square processes the payment.
     */
    public function getRedirectUrl(): ?string
    {
        if (count($this->redirectUrl) == 0) {
            return null;
        }
        return $this->redirectUrl['value'];
    }

    /**
     * Sets Redirect Url.
     * The confirmation page URL to redirect the buyer to after Square processes the payment.
     *
     * @maps redirect_url
     */
    public function setRedirectUrl(?string $redirectUrl): void
    {
        $this->redirectUrl['value'] = $redirectUrl;
    }

    /**
     * Unsets Redirect Url.
     * The confirmation page URL to redirect the buyer to after Square processes the payment.
     */
    public function unsetRedirectUrl(): void
    {
        $this->redirectUrl = [];
    }

    /**
     * Returns Merchant Support Email.
     * The email address that buyers can use to contact the seller.
     */
    public function getMerchantSupportEmail(): ?string
    {
        if (count($this->merchantSupportEmail) == 0) {
            return null;
        }
        return $this->merchantSupportEmail['value'];
    }

    /**
     * Sets Merchant Support Email.
     * The email address that buyers can use to contact the seller.
     *
     * @maps merchant_support_email
     */
    public function setMerchantSupportEmail(?string $merchantSupportEmail): void
    {
        $this->merchantSupportEmail['value'] = $merchantSupportEmail;
    }

    /**
     * Unsets Merchant Support Email.
     * The email address that buyers can use to contact the seller.
     */
    public function unsetMerchantSupportEmail(): void
    {
        $this->merchantSupportEmail = [];
    }

    /**
     * Returns Ask for Shipping Address.
     * Indicates whether to include the address fields in the payment form.
     */
    public function getAskForShippingAddress(): ?bool
    {
        if (count($this->askForShippingAddress) == 0) {
            return null;
        }
        return $this->askForShippingAddress['value'];
    }

    /**
     * Sets Ask for Shipping Address.
     * Indicates whether to include the address fields in the payment form.
     *
     * @maps ask_for_shipping_address
     */
    public function setAskForShippingAddress(?bool $askForShippingAddress): void
    {
        $this->askForShippingAddress['value'] = $askForShippingAddress;
    }

    /**
     * Unsets Ask for Shipping Address.
     * Indicates whether to include the address fields in the payment form.
     */
    public function unsetAskForShippingAddress(): void
    {
        $this->askForShippingAddress = [];
    }

    /**
     * Returns Accepted Payment Methods.
     */
    public function getAcceptedPaymentMethods(): ?AcceptedPaymentMethods
    {
        return $this->acceptedPaymentMethods;
    }

    /**
     * Sets Accepted Payment Methods.
     *
     * @maps accepted_payment_methods
     */
    public function setAcceptedPaymentMethods(?AcceptedPaymentMethods $acceptedPaymentMethods): void
    {
        $this->acceptedPaymentMethods = $acceptedPaymentMethods;
    }

    /**
     * Returns App Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     */
    public function getAppFeeMoney(): ?Money
    {
        return $this->appFeeMoney;
    }

    /**
     * Sets App Fee Money.
     * Represents an amount of money. `Money` fields can be signed or unsigned.
     * Fields that do not explicitly define whether they are signed or unsigned are
     * considered unsigned and can only hold positive amounts. For signed fields, the
     * sign of the value indicates the purpose of the money transfer. See
     * [Working with Monetary Amounts](https://developer.squareup.com/docs/build-basics/working-with-
     * monetary-amounts)
     * for more information.
     *
     * @maps app_fee_money
     */
    public function setAppFeeMoney(?Money $appFeeMoney): void
    {
        $this->appFeeMoney = $appFeeMoney;
    }

    /**
     * Returns Shipping Fee.
     */
    public function getShippingFee(): ?ShippingFee
    {
        return $this->shippingFee;
    }

    /**
     * Sets Shipping Fee.
     *
     * @maps shipping_fee
     */
    public function setShippingFee(?ShippingFee $shippingFee): void
    {
        $this->shippingFee = $shippingFee;
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
        if (!empty($this->allowTipping)) {
            $json['allow_tipping']            = $this->allowTipping['value'];
        }
        if (!empty($this->customFields)) {
            $json['custom_fields']            = $this->customFields['value'];
        }
        if (!empty($this->subscriptionPlanId)) {
            $json['subscription_plan_id']     = $this->subscriptionPlanId['value'];
        }
        if (!empty($this->redirectUrl)) {
            $json['redirect_url']             = $this->redirectUrl['value'];
        }
        if (!empty($this->merchantSupportEmail)) {
            $json['merchant_support_email']   = $this->merchantSupportEmail['value'];
        }
        if (!empty($this->askForShippingAddress)) {
            $json['ask_for_shipping_address'] = $this->askForShippingAddress['value'];
        }
        if (isset($this->acceptedPaymentMethods)) {
            $json['accepted_payment_methods'] = $this->acceptedPaymentMethods;
        }
        if (isset($this->appFeeMoney)) {
            $json['app_fee_money']            = $this->appFeeMoney;
        }
        if (isset($this->shippingFee)) {
            $json['shipping_fee']             = $this->shippingFee;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
