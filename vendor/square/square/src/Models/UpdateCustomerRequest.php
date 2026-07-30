<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Defines the body parameters that can be included in a request to the
 * `UpdateCustomer` endpoint.
 */
class UpdateCustomerRequest implements \JsonSerializable
{
    /**
     * @var array
     */
    private $givenName = [];

    /**
     * @var array
     */
    private $familyName = [];

    /**
     * @var array
     */
    private $companyName = [];

    /**
     * @var array
     */
    private $nickname = [];

    /**
     * @var array
     */
    private $emailAddress = [];

    /**
     * @var Address|null
     */
    private $address;

    /**
     * @var array
     */
    private $phoneNumber = [];

    /**
     * @var array
     */
    private $referenceId = [];

    /**
     * @var array
     */
    private $note = [];

    /**
     * @var array
     */
    private $birthday = [];

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var CustomerTaxIds|null
     */
    private $taxIds;

    /**
     * Returns Given Name.
     * The given name (that is, the first name) associated with the customer profile.
     *
     * The maximum length for this value is 300 characters.
     */
    public function getGivenName(): ?string
    {
        if (count($this->givenName) == 0) {
            return null;
        }
        return $this->givenName['value'];
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
        $this->givenName['value'] = $givenName;
    }

    /**
     * Unsets Given Name.
     * The given name (that is, the first name) associated with the customer profile.
     *
     * The maximum length for this value is 300 characters.
     */
    public function unsetGivenName(): void
    {
        $this->givenName = [];
    }

    /**
     * Returns Family Name.
     * The family name (that is, the last name) associated with the customer profile.
     *
     * The maximum length for this value is 300 characters.
     */
    public function getFamilyName(): ?string
    {
        if (count($this->familyName) == 0) {
            return null;
        }
        return $this->familyName['value'];
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
        $this->familyName['value'] = $familyName;
    }

    /**
     * Unsets Family Name.
     * The family name (that is, the last name) associated with the customer profile.
     *
     * The maximum length for this value is 300 characters.
     */
    public function unsetFamilyName(): void
    {
        $this->familyName = [];
    }

    /**
     * Returns Company Name.
     * A business name associated with the customer profile.
     *
     * The maximum length for this value is 500 characters.
     */
    public function getCompanyName(): ?string
    {
        if (count($this->companyName) == 0) {
            return null;
        }
        return $this->companyName['value'];
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
        $this->companyName['value'] = $companyName;
    }

    /**
     * Unsets Company Name.
     * A business name associated with the customer profile.
     *
     * The maximum length for this value is 500 characters.
     */
    public function unsetCompanyName(): void
    {
        $this->companyName = [];
    }

    /**
     * Returns Nickname.
     * A nickname for the customer profile.
     *
     * The maximum length for this value is 100 characters.
     */
    public function getNickname(): ?string
    {
        if (count($this->nickname) == 0) {
            return null;
        }
        return $this->nickname['value'];
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
        $this->nickname['value'] = $nickname;
    }

    /**
     * Unsets Nickname.
     * A nickname for the customer profile.
     *
     * The maximum length for this value is 100 characters.
     */
    public function unsetNickname(): void
    {
        $this->nickname = [];
    }

    /**
     * Returns Email Address.
     * The email address associated with the customer profile.
     *
     * The maximum length for this value is 254 characters.
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
     * The email address associated with the customer profile.
     *
     * The maximum length for this value is 254 characters.
     *
     * @maps email_address
     */
    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress['value'] = $emailAddress;
    }

    /**
     * Unsets Email Address.
     * The email address associated with the customer profile.
     *
     * The maximum length for this value is 254 characters.
     */
    public function unsetEmailAddress(): void
    {
        $this->emailAddress = [];
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
        if (count($this->phoneNumber) == 0) {
            return null;
        }
        return $this->phoneNumber['value'];
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
        $this->phoneNumber['value'] = $phoneNumber;
    }

    /**
     * Unsets Phone Number.
     * The phone number associated with the customer profile. The phone number must be valid and can
     * contain
     * 9–16 digits, with an optional `+` prefix and country code. For more information, see
     * [Customer phone numbers](https://developer.squareup.com/docs/customers-api/use-the-api/keep-
     * records#phone-number).
     */
    public function unsetPhoneNumber(): void
    {
        $this->phoneNumber = [];
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
        if (count($this->referenceId) == 0) {
            return null;
        }
        return $this->referenceId['value'];
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
        $this->referenceId['value'] = $referenceId;
    }

    /**
     * Unsets Reference Id.
     * An optional second ID used to associate the customer profile with an
     * entity in another system.
     *
     * The maximum length for this value is 100 characters.
     */
    public function unsetReferenceId(): void
    {
        $this->referenceId = [];
    }

    /**
     * Returns Note.
     * A custom note associated with the customer profile.
     */
    public function getNote(): ?string
    {
        if (count($this->note) == 0) {
            return null;
        }
        return $this->note['value'];
    }

    /**
     * Sets Note.
     * A custom note associated with the customer profile.
     *
     * @maps note
     */
    public function setNote(?string $note): void
    {
        $this->note['value'] = $note;
    }

    /**
     * Unsets Note.
     * A custom note associated with the customer profile.
     */
    public function unsetNote(): void
    {
        $this->note = [];
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
        if (count($this->birthday) == 0) {
            return null;
        }
        return $this->birthday['value'];
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
        $this->birthday['value'] = $birthday;
    }

    /**
     * Unsets Birthday.
     * The birthday associated with the customer profile, in `YYYY-MM-DD` or `MM-DD` format. For example,
     * specify `1998-09-21` for September 21, 1998, or `09-21` for September 21. Birthdays are returned in
     * `YYYY-MM-DD`
     * format, where `YYYY` is the specified birth year or `0000` if a birth year is not specified.
     */
    public function unsetBirthday(): void
    {
        $this->birthday = [];
    }

    /**
     * Returns Version.
     * The current version of the customer profile.
     *
     * As a best practice, you should include this field to enable [optimistic concurrency](https:
     * //developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency) control. For
     * more information, see [Update a customer profile](https://developer.squareup.com/docs/customers-
     * api/use-the-api/keep-records#update-a-customer-profile).
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The current version of the customer profile.
     *
     * As a best practice, you should include this field to enable [optimistic concurrency](https:
     * //developer.squareup.com/docs/build-basics/common-api-patterns/optimistic-concurrency) control. For
     * more information, see [Update a customer profile](https://developer.squareup.com/docs/customers-
     * api/use-the-api/keep-records#update-a-customer-profile).
     *
     * @maps version
     */
    public function setVersion(?int $version): void
    {
        $this->version = $version;
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
        if (!empty($this->givenName)) {
            $json['given_name']    = $this->givenName['value'];
        }
        if (!empty($this->familyName)) {
            $json['family_name']   = $this->familyName['value'];
        }
        if (!empty($this->companyName)) {
            $json['company_name']  = $this->companyName['value'];
        }
        if (!empty($this->nickname)) {
            $json['nickname']      = $this->nickname['value'];
        }
        if (!empty($this->emailAddress)) {
            $json['email_address'] = $this->emailAddress['value'];
        }
        if (isset($this->address)) {
            $json['address']       = $this->address;
        }
        if (!empty($this->phoneNumber)) {
            $json['phone_number']  = $this->phoneNumber['value'];
        }
        if (!empty($this->referenceId)) {
            $json['reference_id']  = $this->referenceId['value'];
        }
        if (!empty($this->note)) {
            $json['note']          = $this->note['value'];
        }
        if (!empty($this->birthday)) {
            $json['birthday']      = $this->birthday['value'];
        }
        if (isset($this->version)) {
            $json['version']       = $this->version;
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
