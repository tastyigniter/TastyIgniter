<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the body parameters that can be included in a request to the
 * `CreateCustomer` endpoint.
 */
class CreateCustomerRequest implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $idempotencyKey;

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
    private $companyName;

    /**
     * @var string|null
     */
    private $nickname;

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
    private $referenceId;

    /**
     * @var string|null
     */
    private $note;

    /**
     * @var string|null
     */
    private $birthday;

    /**
     * @var CustomerTaxIds|null
     */
    private $taxIds;

    /**
     * Returns Idempotency Key.
     * The idempotency key for the request. For more information, see
     * [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).
     */
    public function getIdempotencyKey(): ?string
    {
        return $this->idempotencyKey;
    }

    /**
     * Sets Idempotency Key.
     * The idempotency key for the request. For more information, see
     * [Idempotency](https://developer.squareup.com/docs/build-basics/common-api-patterns/idempotency).
     *
     * @maps idempotency_key
     */
    public function setIdempotencyKey(?string $idempotencyKey): void
    {
        $this->idempotencyKey = $idempotencyKey;
    }

    /**
     * Returns Given Name.
     * The given name (that is, the first name) associated with the customer profile.
     *
     * The maximum length for this value is 300 characters.
     */
    public function getGivenName(): ?string
    {
        return $this->givenName;
    }

    /**
     * Sets Given Name.
     * The given name (that is, the first name) associated with the customer profile.
     *
     * The maximum length for this value is 300 characters.
     *
     * @maps given_name
     */
    public function setGivenName(?string $givenName): void
    {
        $this->givenName = $givenName;
    }

    /**
     * Returns Family Name.
     * The family name (that is, the last name) associated with the customer profile.
     *
     * The maximum length for this value is 300 characters.
     */
    public function getFamilyName(): ?string
    {
        return $this->familyName;
    }

    /**
     * Sets Family Name.
     * The family name (that is, the last name) associated with the customer profile.
     *
     * The maximum length for this value is 300 characters.
     *
     * @maps family_name
     */
    public function setFamilyName(?string $familyName): void
    {
        $this->familyName = $familyName;
    }

    /**
     * Returns Company Name.
     * A business name associated with the customer profile.
     *
     * The maximum length for this value is 500 characters.
     */
    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    /**
     * Sets Company Name.
     * A business name associated with the customer profile.
     *
     * The maximum length for this value is 500 characters.
     *
     * @maps company_name
     */
    public function setCompanyName(?string $companyName): void
    {
        $this->companyName = $companyName;
    }

    /**
     * Returns Nickname.
     * A nickname for the customer profile.
     *
     * The maximum length for this value is 100 characters.
     */
    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    /**
     * Sets Nickname.
     * A nickname for the customer profile.
     *
     * The maximum length for this value is 100 characters.
     *
     * @maps nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname = $nickname;
    }

    /**
     * Returns Email Address.
     * The email address associated with the customer profile.
     *
     * The maximum length for this value is 254 characters.
     */
    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    /**
     * Sets Email Address.
     * The email address associated with the customer profile.
     *
     * The maximum length for this value is 254 characters.
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
     * The phone number associated with the customer profile. The phone number must be valid and can
     * contain
     * 9–16 digits, with an optional `+` prefix and country code. For more information, see
     * [Customer phone numbers](https://developer.squareup.com/docs/customers-api/use-the-api/keep-
     * records#phone-number).
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * Sets Phone Number.
     * The phone number associated with the customer profile. The phone number must be valid and can
     * contain
     * 9–16 digits, with an optional `+` prefix and country code. For more information, see
     * [Customer phone numbers](https://developer.squareup.com/docs/customers-api/use-the-api/keep-
     * records#phone-number).
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Returns Reference Id.
     * An optional second ID used to associate the customer profile with an
     * entity in another system.
     *
     * The maximum length for this value is 100 characters.
     */
    public function getReferenceId(): ?string
    {
        return $this->referenceId;
    }

    /**
     * Sets Reference Id.
     * An optional second ID used to associate the customer profile with an
     * entity in another system.
     *
     * The maximum length for this value is 100 characters.
     *
     * @maps reference_id
     */
    public function setReferenceId(?string $referenceId): void
    {
        $this->referenceId = $referenceId;
    }

    /**
     * Returns Note.
     * A custom note associated with the customer profile.
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * Sets Note.
     * A custom note associated with the customer profile.
     *
     * @maps note
     */
    public function setNote(?string $note): void
    {
        $this->note = $note;
    }

    /**
     * Returns Birthday.
     * The birthday associated with the customer profile, in `YYYY-MM-DD` or `MM-DD` format. For example,
     * specify `1998-09-21` for September 21, 1998, or `09-21` for September 21. Birthdays are returned in
     * `YYYY-MM-DD`
     * format, where `YYYY` is the specified birth year or `0000` if a birth year is not specified.
     */
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * Sets Birthday.
     * The birthday associated with the customer profile, in `YYYY-MM-DD` or `MM-DD` format. For example,
     * specify `1998-09-21` for September 21, 1998, or `09-21` for September 21. Birthdays are returned in
     * `YYYY-MM-DD`
     * format, where `YYYY` is the specified birth year or `0000` if a birth year is not specified.
     *
     * @maps birthday
     */
    public function setBirthday(?string $birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * Returns Tax Ids.
     * Represents the tax ID associated with a [customer profile]($m/Customer). The corresponding `tax_ids`
     * field is available only for customers of sellers in EU countries or the United Kingdom.
     * For more information, see [Customer tax IDs](https://developer.squareup.com/docs/customers-api/what-
     * it-does#customer-tax-ids).
     */
    public function getTaxIds(): ?CustomerTaxIds
    {
        return $this->taxIds;
    }

    /**
     * Sets Tax Ids.
     * Represents the tax ID associated with a [customer profile]($m/Customer). The corresponding `tax_ids`
     * field is available only for customers of sellers in EU countries or the United Kingdom.
     * For more information, see [Customer tax IDs](https://developer.squareup.com/docs/customers-api/what-
     * it-does#customer-tax-ids).
     *
     * @maps tax_ids
     */
    public function setTaxIds(?CustomerTaxIds $taxIds): void
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
        if (isset($this->idempotencyKey)) {
            $json['idempotency_key'] = $this->idempotencyKey;
        }
        if (isset($this->givenName)) {
            $json['given_name']      = $this->givenName;
        }
        if (isset($this->familyName)) {
            $json['family_name']     = $this->familyName;
        }
        if (isset($this->companyName)) {
            $json['company_name']    = $this->companyName;
        }
        if (isset($this->nickname)) {
            $json['nickname']        = $this->nickname;
        }
        if (isset($this->emailAddress)) {
            $json['email_address']   = $this->emailAddress;
        }
        if (isset($this->address)) {
            $json['address']         = $this->address;
        }
        if (isset($this->phoneNumber)) {
            $json['phone_number']    = $this->phoneNumber;
        }
        if (isset($this->referenceId)) {
            $json['reference_id']    = $this->referenceId;
        }
        if (isset($this->note)) {
            $json['note']            = $this->note;
        }
        if (isset($this->birthday)) {
            $json['birthday']        = $this->birthday;
        }
        if (isset($this->taxIds)) {
            $json['tax_ids']         = $this->taxIds;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
