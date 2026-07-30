<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Information about the fulfillment recipient.
 */
class FulfillmentRecipient implements \JsonSerializable
{
    /**
     * @var array
     */
    private $customerId = [];

    /**
     * @var array
     */
    private $displayName = [];

    /**
     * @var array
     */
    private $emailAddress = [];

    /**
     * @var array
     */
    private $phoneNumber = [];

    /**
     * @var Address|null
     */
    private $address;

    /**
     * Returns Customer Id.
     * The ID of the customer associated with the fulfillment.
     *
     * If `customer_id` is provided, the fulfillment recipient's `display_name`,
     * `email_address`, and `phone_number` are automatically populated from the
     * targeted customer profile. If these fields are set in the request, the request
     * values override the information from the customer profile. If the
     * targeted customer profile does not contain the necessary information and
     * these fields are left unset, the request results in an error.
     */
    public function getCustomerId(): ?string
    {
        if (count($this->customerId) == 0) {
            return null;
        }
        return $this->customerId['value'];
    }

    /**
     * Sets Customer Id.
     * The ID of the customer associated with the fulfillment.
     *
     * If `customer_id` is provided, the fulfillment recipient's `display_name`,
     * `email_address`, and `phone_number` are automatically populated from the
     * targeted customer profile. If these fields are set in the request, the request
     * values override the information from the customer profile. If the
     * targeted customer profile does not contain the necessary information and
     * these fields are left unset, the request results in an error.
     *
     * @maps customer_id
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId['value'] = $customerId;
    }

    /**
     * Unsets Customer Id.
     * The ID of the customer associated with the fulfillment.
     *
     * If `customer_id` is provided, the fulfillment recipient's `display_name`,
     * `email_address`, and `phone_number` are automatically populated from the
     * targeted customer profile. If these fields are set in the request, the request
     * values override the information from the customer profile. If the
     * targeted customer profile does not contain the necessary information and
     * these fields are left unset, the request results in an error.
     */
    public function unsetCustomerId(): void
    {
        $this->customerId = [];
    }

    /**
     * Returns Display Name.
     * The display name of the fulfillment recipient. This field is required.
     *
     * If provided, the display name overrides the corresponding customer profile value
     * indicated by `customer_id`.
     */
    public function getDisplayName(): ?string
    {
        if (count($this->displayName) == 0) {
            return null;
        }
        return $this->displayName['value'];
    }

    /**
     * Sets Display Name.
     * The display name of the fulfillment recipient. This field is required.
     *
     * If provided, the display name overrides the corresponding customer profile value
     * indicated by `customer_id`.
     *
     * @maps display_name
     */
    public function setDisplayName(?string $displayName): void
    {
        $this->displayName['value'] = $displayName;
    }

    /**
     * Unsets Display Name.
     * The display name of the fulfillment recipient. This field is required.
     *
     * If provided, the display name overrides the corresponding customer profile value
     * indicated by `customer_id`.
     */
    public function unsetDisplayName(): void
    {
        $this->displayName = [];
    }

    /**
     * Returns Email Address.
     * The email address of the fulfillment recipient.
     *
     * If provided, the email address overrides the corresponding customer profile value
     * indicated by `customer_id`.
     */
    public function getEmailAddress(): ?string
    {
        if (count($this->emailAddress) == 0) {
            return null;
        }
        return $this->emailAddress['value'];
    }

    /**
     * Sets Email Address.
     * The email address of the fulfillment recipient.
     *
     * If provided, the email address overrides the corresponding customer profile value
     * indicated by `customer_id`.
     *
     * @maps email_address
     */
    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress['value'] = $emailAddress;
    }

    /**
     * Unsets Email Address.
     * The email address of the fulfillment recipient.
     *
     * If provided, the email address overrides the corresponding customer profile value
     * indicated by `customer_id`.
     */
    public function unsetEmailAddress(): void
    {
        $this->emailAddress = [];
    }

    /**
     * Returns Phone Number.
     * The phone number of the fulfillment recipient. This field is required.
     *
     * If provided, the phone number overrides the corresponding customer profile value
     * indicated by `customer_id`.
     */
    public function getPhoneNumber(): ?string
    {
        if (count($this->phoneNumber) == 0) {
            return null;
        }
        return $this->phoneNumber['value'];
    }

    /**
     * Sets Phone Number.
     * The phone number of the fulfillment recipient. This field is required.
     *
     * If provided, the phone number overrides the corresponding customer profile value
     * indicated by `customer_id`.
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber['value'] = $phoneNumber;
    }

    /**
     * Unsets Phone Number.
     * The phone number of the fulfillment recipient. This field is required.
     *
     * If provided, the phone number overrides the corresponding customer profile value
     * indicated by `customer_id`.
     */
    public function unsetPhoneNumber(): void
    {
        $this->phoneNumber = [];
    }

    /**
     * Returns Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * Sets Address.
     * Represents a postal address in a country.
     * For more information, see [Working with Addresses](https://developer.squareup.com/docs/build-
     * basics/working-with-addresses).
     *
     * @maps address
     */
    public function setAddress(?Address $address): void
    {
        $this->address = $address;
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
        if (!empty($this->customerId)) {
            $json['customer_id']   = $this->customerId['value'];
        }
        if (!empty($this->displayName)) {
            $json['display_name']  = $this->displayName['value'];
        }
        if (!empty($this->emailAddress)) {
            $json['email_address'] = $this->emailAddress['value'];
        }
        if (!empty($this->phoneNumber)) {
            $json['phone_number']  = $this->phoneNumber['value'];
        }
        if (isset($this->address)) {
            $json['address']       = $this->address;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
