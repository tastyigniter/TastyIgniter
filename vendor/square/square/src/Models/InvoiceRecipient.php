<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a snapshot of customer data. This object stores customer data that is displayed on the
 * invoice
 * and that Square uses to deliver the invoice.
 *
 * When you provide a customer ID for a draft invoice, Square retrieves the associated customer profile
 * and populates
 * the remaining `InvoiceRecipient` fields. You cannot update these fields after the invoice is
 * published.
 * Square updates the customer ID in response to a merge operation, but does not update other fields.
 */
class InvoiceRecipient implements \JsonSerializable
{
    /**
     * @var array
     */
    private $customerId = [];

    /**
     * @var string|null
     */
    private $givenName;

    /**
     * @var string|null
     */
    private $familyName;

    /**
     * @var string|null
     */
    private $emailAddress;

    /**
     * @var Address|null
     */
    private $address;

    /**
     * @var string|null
     */
    private $phoneNumber;

    /**
     * @var string|null
     */
    private $companyName;

    /**
     * @var InvoiceRecipientTaxIds|null
     */
    private $taxIds;

    /**
     * Returns Customer Id.
     * The ID of the customer. This is the customer profile ID that
     * you provide when creating a draft invoice.
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
     * The ID of the customer. This is the customer profile ID that
     * you provide when creating a draft invoice.
     *
     * @maps customer_id
     */
    public function setCustomerId(?string $customerId): void
    {
        $this->customerId['value'] = $customerId;
    }

    /**
     * Unsets Customer Id.
     * The ID of the customer. This is the customer profile ID that
     * you provide when creating a draft invoice.
     */
    public function unsetCustomerId(): void
    {
        $this->customerId = [];
    }

    /**
     * Returns Given Name.
     * The recipient's given (that is, first) name.
     */
    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    /**
     * Sets Given Name.
     * The recipient's given (that is, first) name.
     *
     * @maps given_name
     */
    public function setGivenName(?string $givenName): void
    {
        $this->givenName = $givenName;
    }

    /**
     * Returns Family Name.
     * The recipient's family (that is, last) name.
     */
    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    /**
     * Sets Family Name.
     * The recipient's family (that is, last) name.
     *
     * @maps family_name
     */
    public function setFamilyName(?string $familyName): void
    {
        $this->familyName = $familyName;
    }

    /**
     * Returns Email Address.
     * The recipient's email address.
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * Sets Email Address.
     * The recipient's email address.
     *
     * @maps email_address
     */
    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
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
     * Returns Phone Number.
     * The recipient's phone number.
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Sets Phone Number.
     * The recipient's phone number.
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Returns Company Name.
     * The name of the recipient's company.
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * Sets Company Name.
     * The name of the recipient's company.
     *
     * @maps company_name
     */
    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }

    /**
     * Returns Tax Ids.
     * Represents the tax IDs for an invoice recipient. The country of the seller account determines
     * whether the corresponding `tax_ids` field is available for the customer. For more information,
     * see [Invoice recipient tax IDs](https://developer.squareup.com/docs/invoices-api/overview#recipient-
     * tax-ids).
     */
    public function getTaxIds(): ?InvoiceRecipientTaxIds
    {
        return $this->taxIds;
    }

    /**
     * Sets Tax Ids.
     * Represents the tax IDs for an invoice recipient. The country of the seller account determines
     * whether the corresponding `tax_ids` field is available for the customer. For more information,
     * see [Invoice recipient tax IDs](https://developer.squareup.com/docs/invoices-api/overview#recipient-
     * tax-ids).
     *
     * @maps tax_ids
     */
    public function setTaxIds(?InvoiceRecipientTaxIds $taxIds): void
    {
        $this->taxIds = $taxIds;
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
        if (isset($this->givenName)) {
            $json['given_name']    = $this->givenName;
        }
        if (isset($this->familyName)) {
            $json['family_name']   = $this->familyName;
        }
        if (isset($this->emailAddress)) {
            $json['email_address'] = $this->emailAddress;
        }
        if (isset($this->address)) {
            $json['address']       = $this->address;
        }
        if (isset($this->phoneNumber)) {
            $json['phone_number']  = $this->phoneNumber;
        }
        if (isset($this->companyName)) {
            $json['company_name']  = $this->companyName;
        }
        if (isset($this->taxIds)) {
            $json['tax_ids']       = $this->taxIds;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
