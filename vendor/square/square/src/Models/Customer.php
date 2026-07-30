<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents a Square customer profile in the Customer Directory of a Square seller.
 */
class Customer implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

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
    private $cards = [];

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
    private $nickname = [];

    /**
     * @var array
     */
    private $companyName = [];

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
    private $birthday = [];

    /**
     * @var array
     */
    private $referenceId = [];

    /**
     * @var array
     */
    private $note = [];

    /**
     * @var CustomerPreferences|null
     */
    private $preferences;

    /**
     * @var string|null
     */
    private $creationSource;

    /**
     * @var array
     */
    private $groupIds = [];

    /**
     * @var array
     */
    private $segmentIds = [];

    /**
     * @var int|null
     */
    private $version;

    /**
     * @var CustomerTaxIds|null
     */
    private $taxIds;

    /**
     * Returns Id.
     * A unique Square-assigned ID for the customer profile.
     *
     * If you need this ID for an API request, use the ID returned when you created the customer profile or
     * call the [SearchCustomers](api-endpoint:Customers-SearchCustomers)
     * or [ListCustomers](api-endpoint:Customers-ListCustomers) endpoint.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * A unique Square-assigned ID for the customer profile.
     *
     * If you need this ID for an API request, use the ID returned when you created the customer profile or
     * call the [SearchCustomers](api-endpoint:Customers-SearchCustomers)
     * or [ListCustomers](api-endpoint:Customers-ListCustomers) endpoint.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Created At.
     * The timestamp when the customer profile was created, in RFC 3339 format.
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The timestamp when the customer profile was created, in RFC 3339 format.
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Updated At.
     * The timestamp when the customer profile was last updated, in RFC 3339 format.
     */
    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    /**
     * Sets Updated At.
     * The timestamp when the customer profile was last updated, in RFC 3339 format.
     *
     * @maps updated_at
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Returns Cards.
     * Payment details of the credit, debit, and gift cards stored on file for the customer profile.
     *
     * DEPRECATED at version 2021-06-16. Replaced by calling [ListCards](api-endpoint:Cards-ListCards) (for
     * credit and debit cards on file)
     * or [ListGiftCards](api-endpoint:GiftCards-ListGiftCards) (for gift cards on file) and including the
     * `customer_id` query parameter.
     * For more information, see [Migration notes](https://developer.squareup.com/docs/customers-api/what-
     * it-does#migrate-customer-cards).
     *
     * @return Card[]|null
     */
    public function getCards(): ?array
    {
        if (count($this->cards) == 0) {
            return null;
        }
        return $this->cards['value'];
    }

    /**
     * Sets Cards.
     * Payment details of the credit, debit, and gift cards stored on file for the customer profile.
     *
     * DEPRECATED at version 2021-06-16. Replaced by calling [ListCards](api-endpoint:Cards-ListCards) (for
     * credit and debit cards on file)
     * or [ListGiftCards](api-endpoint:GiftCards-ListGiftCards) (for gift cards on file) and including the
     * `customer_id` query parameter.
     * For more information, see [Migration notes](https://developer.squareup.com/docs/customers-api/what-
     * it-does#migrate-customer-cards).
     *
     * @maps cards
     *
     * @param Card[]|null $cards
     */
    public function setCards(?array $cards): void
    {
        $this->cards['value'] = $cards;
    }

    /**
     * Unsets Cards.
     * Payment details of the credit, debit, and gift cards stored on file for the customer profile.
     *
     * DEPRECATED at version 2021-06-16. Replaced by calling [ListCards](api-endpoint:Cards-ListCards) (for
     * credit and debit cards on file)
     * or [ListGiftCards](api-endpoint:GiftCards-ListGiftCards) (for gift cards on file) and including the
     * `customer_id` query parameter.
     * For more information, see [Migration notes](https://developer.squareup.com/docs/customers-api/what-
     * it-does#migrate-customer-cards).
     */
    public function unsetCards(): void
    {
        $this->cards = [];
    }

    /**
     * Returns Given Name.
     * The given name (that is, the first name) associated with the customer profile.
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
     * @maps given_name
     */
    public function setGivenName(?string $givenName): void
    {
        $this->givenName['value'] = $givenName;
    }

    /**
     * Unsets Given Name.
     * The given name (that is, the first name) associated with the customer profile.
     */
    public function unsetGivenName(): void
    {
        $this->givenName = [];
    }

    /**
     * Returns Family Name.
     * The family name (that is, the last name) associated with the customer profile.
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
     * @maps family_name
     */
    public function setFamilyName(?string $familyName): void
    {
        $this->familyName['value'] = $familyName;
    }

    /**
     * Unsets Family Name.
     * The family name (that is, the last name) associated with the customer profile.
     */
    public function unsetFamilyName(): void
    {
        $this->familyName = [];
    }

    /**
     * Returns Nickname.
     * A nickname for the customer profile.
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
     * @maps nickname
     */
    public function setNickname(?string $nickname): void
    {
        $this->nickname['value'] = $nickname;
    }

    /**
     * Unsets Nickname.
     * A nickname for the customer profile.
     */
    public function unsetNickname(): void
    {
        $this->nickname = [];
    }

    /**
     * Returns Company Name.
     * A business name associated with the customer profile.
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
     * @maps company_name
     */
    public function setCompanyName(?string $companyName): void
    {
        $this->companyName['value'] = $companyName;
    }

    /**
     * Unsets Company Name.
     * A business name associated with the customer profile.
     */
    public function unsetCompanyName(): void
    {
        $this->companyName = [];
    }

    /**
     * Returns Email Address.
     * The email address associated with the customer profile.
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
     * @maps email_address
     */
    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress['value'] = $emailAddress;
    }

    /**
     * Unsets Email Address.
     * The email address associated with the customer profile.
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
     * The phone number associated with the customer profile.
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
     * The phone number associated with the customer profile.
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber['value'] = $phoneNumber;
    }

    /**
     * Unsets Phone Number.
     * The phone number associated with the customer profile.
     */
    public function unsetPhoneNumber(): void
    {
        $this->phoneNumber = [];
    }

    /**
     * Returns Birthday.
     * The birthday associated with the customer profile, in `YYYY-MM-DD` format. For example, `1998-09-
     * 21`
     * represents September 21, 1998, and `0000-09-21` represents September 21 (without a birth year).
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
     * The birthday associated with the customer profile, in `YYYY-MM-DD` format. For example, `1998-09-
     * 21`
     * represents September 21, 1998, and `0000-09-21` represents September 21 (without a birth year).
     *
     * @maps birthday
     */
    public function setBirthday(?string $birthday): void
    {
        $this->birthday['value'] = $birthday;
    }

    /**
     * Unsets Birthday.
     * The birthday associated with the customer profile, in `YYYY-MM-DD` format. For example, `1998-09-
     * 21`
     * represents September 21, 1998, and `0000-09-21` represents September 21 (without a birth year).
     */
    public function unsetBirthday(): void
    {
        $this->birthday = [];
    }

    /**
     * Returns Reference Id.
     * An optional second ID used to associate the customer profile with an
     * entity in another system.
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
     * Returns Preferences.
     * Represents communication preferences for the customer profile.
     */
    public function getPreferences(): ?CustomerPreferences
    {
        return $this->preferences;
    }

    /**
     * Sets Preferences.
     * Represents communication preferences for the customer profile.
     *
     * @maps preferences
     */
    public function setPreferences(?CustomerPreferences $preferences): void
    {
        $this->preferences = $preferences;
    }

    /**
     * Returns Creation Source.
     * Indicates the method used to create the customer profile.
     */
    public function getCreationSource(): ?string
    {
        return $this->creationSource;
    }

    /**
     * Sets Creation Source.
     * Indicates the method used to create the customer profile.
     *
     * @maps creation_source
     */
    public function setCreationSource(?string $creationSource): void
    {
        $this->creationSource = $creationSource;
    }

    /**
     * Returns Group Ids.
     * The IDs of [customer groups](entity:CustomerGroup) the customer belongs to.
     *
     * @return string[]|null
     */
    public function getGroupIds(): ?array
    {
        if (count($this->groupIds) == 0) {
            return null;
        }
        return $this->groupIds['value'];
    }

    /**
     * Sets Group Ids.
     * The IDs of [customer groups](entity:CustomerGroup) the customer belongs to.
     *
     * @maps group_ids
     *
     * @param string[]|null $groupIds
     */
    public function setGroupIds(?array $groupIds): void
    {
        $this->groupIds['value'] = $groupIds;
    }

    /**
     * Unsets Group Ids.
     * The IDs of [customer groups](entity:CustomerGroup) the customer belongs to.
     */
    public function unsetGroupIds(): void
    {
        $this->groupIds = [];
    }

    /**
     * Returns Segment Ids.
     * The IDs of [customer segments](entity:CustomerSegment) the customer belongs to.
     *
     * @return string[]|null
     */
    public function getSegmentIds(): ?array
    {
        if (count($this->segmentIds) == 0) {
            return null;
        }
        return $this->segmentIds['value'];
    }

    /**
     * Sets Segment Ids.
     * The IDs of [customer segments](entity:CustomerSegment) the customer belongs to.
     *
     * @maps segment_ids
     *
     * @param string[]|null $segmentIds
     */
    public function setSegmentIds(?array $segmentIds): void
    {
        $this->segmentIds['value'] = $segmentIds;
    }

    /**
     * Unsets Segment Ids.
     * The IDs of [customer segments](entity:CustomerSegment) the customer belongs to.
     */
    public function unsetSegmentIds(): void
    {
        $this->segmentIds = [];
    }

    /**
     * Returns Version.
     * The Square-assigned version number of the customer profile. The version number is incremented each
     * time an update is committed to the customer profile, except for changes to customer segment
     * membership and cards on file.
     */
    public function getVersion(): ?int
    {
        return $this->version;
    }

    /**
     * Sets Version.
     * The Square-assigned version number of the customer profile. The version number is incremented each
     * time an update is committed to the customer profile, except for changes to customer segment
     * membership and cards on file.
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
        if (isset($this->id)) {
            $json['id']              = $this->id;
        }
        if (isset($this->createdAt)) {
            $json['created_at']      = $this->createdAt;
        }
        if (isset($this->updatedAt)) {
            $json['updated_at']      = $this->updatedAt;
        }
        if (!empty($this->cards)) {
            $json['cards']           = $this->cards['value'];
        }
        if (!empty($this->givenName)) {
            $json['given_name']      = $this->givenName['value'];
        }
        if (!empty($this->familyName)) {
            $json['family_name']     = $this->familyName['value'];
        }
        if (!empty($this->nickname)) {
            $json['nickname']        = $this->nickname['value'];
        }
        if (!empty($this->companyName)) {
            $json['company_name']    = $this->companyName['value'];
        }
        if (!empty($this->emailAddress)) {
            $json['email_address']   = $this->emailAddress['value'];
        }
        if (isset($this->address)) {
            $json['address']         = $this->address;
        }
        if (!empty($this->phoneNumber)) {
            $json['phone_number']    = $this->phoneNumber['value'];
        }
        if (!empty($this->birthday)) {
            $json['birthday']        = $this->birthday['value'];
        }
        if (!empty($this->referenceId)) {
            $json['reference_id']    = $this->referenceId['value'];
        }
        if (!empty($this->note)) {
            $json['note']            = $this->note['value'];
        }
        if (isset($this->preferences)) {
            $json['preferences']     = $this->preferences;
        }
        if (isset($this->creationSource)) {
            $json['creation_source'] = $this->creationSource;
        }
        if (!empty($this->groupIds)) {
            $json['group_ids']       = $this->groupIds['value'];
        }
        if (!empty($this->segmentIds)) {
            $json['segment_ids']     = $this->segmentIds['value'];
        }
        if (isset($this->version)) {
            $json['version']         = $this->version;
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
