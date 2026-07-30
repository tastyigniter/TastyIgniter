<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

/**
 * Represents one of a business' [locations](https://developer.squareup.com/docs/locations-api).
 */
class Location implements \JsonSerializable
{
    /**
     * @var string|null
     */
    private $id;

    /**
     * @var array
     */
    private $name = [];

    /**
     * @var Address|null
     */
    private $address;

    /**
     * @var array
     */
    private $timezone = [];

    /**
     * @var string[]|null
     */
    private $capabilities;

    /**
     * @var string|null
     */
    private $status;

    /**
     * @var string|null
     */
    private $createdAt;

    /**
     * @var string|null
     */
    private $merchantId;

    /**
     * @var string|null
     */
    private $country;

    /**
     * @var array
     */
    private $languageCode = [];

    /**
     * @var string|null
     */
    private $currency;

    /**
     * @var array
     */
    private $phoneNumber = [];

    /**
     * @var array
     */
    private $businessName = [];

    /**
     * @var string|null
     */
    private $type;

    /**
     * @var array
     */
    private $websiteUrl = [];

    /**
     * @var BusinessHours|null
     */
    private $businessHours;

    /**
     * @var array
     */
    private $businessEmail = [];

    /**
     * @var array
     */
    private $description = [];

    /**
     * @var array
     */
    private $twitterUsername = [];

    /**
     * @var array
     */
    private $instagramUsername = [];

    /**
     * @var array
     */
    private $facebookUrl = [];

    /**
     * @var Coordinates|null
     */
    private $coordinates;

    /**
     * @var string|null
     */
    private $logoUrl;

    /**
     * @var string|null
     */
    private $posBackgroundUrl;

    /**
     * @var array
     */
    private $mcc = [];

    /**
     * @var string|null
     */
    private $fullFormatLogoUrl;

    /**
     * @var TaxIds|null
     */
    private $taxIds;

    /**
     * Returns Id.
     * A short generated string of letters and numbers that uniquely identifies this location instance.
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * Sets Id.
     * A short generated string of letters and numbers that uniquely identifies this location instance.
     *
     * @maps id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    /**
     * Returns Name.
     * The name of the location.
     * This information appears in the Seller Dashboard as the nickname.
     * A location name must be unique within a seller account.
     */
    public function getName(): ?string
    {
        if (count($this->name) == 0) {
            return null;
        }
        return $this->name['value'];
    }

    /**
     * Sets Name.
     * The name of the location.
     * This information appears in the Seller Dashboard as the nickname.
     * A location name must be unique within a seller account.
     *
     * @maps name
     */
    public function setName(?string $name): void
    {
        $this->name['value'] = $name;
    }

    /**
     * Unsets Name.
     * The name of the location.
     * This information appears in the Seller Dashboard as the nickname.
     * A location name must be unique within a seller account.
     */
    public function unsetName(): void
    {
        $this->name = [];
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
     * Returns Timezone.
     * The [IANA time zone](https://www.iana.org/time-zones) identifier for
     * the time zone of the location. For example, `America/Los_Angeles`.
     */
    public function getTimezone(): ?string
    {
        if (count($this->timezone) == 0) {
            return null;
        }
        return $this->timezone['value'];
    }

    /**
     * Sets Timezone.
     * The [IANA time zone](https://www.iana.org/time-zones) identifier for
     * the time zone of the location. For example, `America/Los_Angeles`.
     *
     * @maps timezone
     */
    public function setTimezone(?string $timezone): void
    {
        $this->timezone['value'] = $timezone;
    }

    /**
     * Unsets Timezone.
     * The [IANA time zone](https://www.iana.org/time-zones) identifier for
     * the time zone of the location. For example, `America/Los_Angeles`.
     */
    public function unsetTimezone(): void
    {
        $this->timezone = [];
    }

    /**
     * Returns Capabilities.
     * The Square features that are enabled for the location.
     * See [LocationCapability](entity:LocationCapability) for possible values.
     * See [LocationCapability](#type-locationcapability) for possible values
     *
     * @return string[]|null
     */
    public function getCapabilities(): ?array
    {
        return $this->capabilities;
    }

    /**
     * Sets Capabilities.
     * The Square features that are enabled for the location.
     * See [LocationCapability](entity:LocationCapability) for possible values.
     * See [LocationCapability](#type-locationcapability) for possible values
     *
     * @maps capabilities
     *
     * @param string[]|null $capabilities
     */
    public function setCapabilities(?array $capabilities): void
    {
        $this->capabilities = $capabilities;
    }

    /**
     * Returns Status.
     * A location's status.
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * Sets Status.
     * A location's status.
     *
     * @maps status
     */
    public function setStatus(?string $status): void
    {
        $this->status = $status;
    }

    /**
     * Returns Created At.
     * The time when the location was created, in RFC 3339 format.
     * For more information, see [Working with Dates](https://developer.squareup.com/docs/build-
     * basics/working-with-dates).
     */
    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    /**
     * Sets Created At.
     * The time when the location was created, in RFC 3339 format.
     * For more information, see [Working with Dates](https://developer.squareup.com/docs/build-
     * basics/working-with-dates).
     *
     * @maps created_at
     */
    public function setCreatedAt(?string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Returns Merchant Id.
     * The ID of the merchant that owns the location.
     */
    public function getMerchantId(): ?string
    {
        return $this->merchantId;
    }

    /**
     * Sets Merchant Id.
     * The ID of the merchant that owns the location.
     *
     * @maps merchant_id
     */
    public function setMerchantId(?string $merchantId): void
    {
        $this->merchantId = $merchantId;
    }

    /**
     * Returns Country.
     * Indicates the country associated with another entity, such as a business.
     * Values are in [ISO 3166-1-alpha-2 format](http://www.iso.org/iso/home/standards/country_codes.htm).
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * Sets Country.
     * Indicates the country associated with another entity, such as a business.
     * Values are in [ISO 3166-1-alpha-2 format](http://www.iso.org/iso/home/standards/country_codes.htm).
     *
     * @maps country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * Returns Language Code.
     * The language associated with the location, in
     * [BCP 47 format](https://tools.ietf.org/html/bcp47#appendix-A).
     * For more information, see [Language Preferences](https://developer.squareup.com/docs/build-
     * basics/general-considerations/language-preferences).
     */
    public function getLanguageCode(): ?string
    {
        if (count($this->languageCode) == 0) {
            return null;
        }
        return $this->languageCode['value'];
    }

    /**
     * Sets Language Code.
     * The language associated with the location, in
     * [BCP 47 format](https://tools.ietf.org/html/bcp47#appendix-A).
     * For more information, see [Language Preferences](https://developer.squareup.com/docs/build-
     * basics/general-considerations/language-preferences).
     *
     * @maps language_code
     */
    public function setLanguageCode(?string $languageCode): void
    {
        $this->languageCode['value'] = $languageCode;
    }

    /**
     * Unsets Language Code.
     * The language associated with the location, in
     * [BCP 47 format](https://tools.ietf.org/html/bcp47#appendix-A).
     * For more information, see [Language Preferences](https://developer.squareup.com/docs/build-
     * basics/general-considerations/language-preferences).
     */
    public function unsetLanguageCode(): void
    {
        $this->languageCode = [];
    }

    /**
     * Returns Currency.
     * Indicates the associated currency for an amount of money. Values correspond
     * to [ISO 4217](https://wikipedia.org/wiki/ISO_4217).
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * Sets Currency.
     * Indicates the associated currency for an amount of money. Values correspond
     * to [ISO 4217](https://wikipedia.org/wiki/ISO_4217).
     *
     * @maps currency
     */
    public function setCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Returns Phone Number.
     * The phone number of the location. For example, `+1 855-700-6000`.
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
     * The phone number of the location. For example, `+1 855-700-6000`.
     *
     * @maps phone_number
     */
    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber['value'] = $phoneNumber;
    }

    /**
     * Unsets Phone Number.
     * The phone number of the location. For example, `+1 855-700-6000`.
     */
    public function unsetPhoneNumber(): void
    {
        $this->phoneNumber = [];
    }

    /**
     * Returns Business Name.
     * The name of the location's overall business. This name is present on receipts and other customer-
     * facing branding.
     */
    public function getBusinessName(): ?string
    {
        if (count($this->businessName) == 0) {
            return null;
        }
        return $this->businessName['value'];
    }

    /**
     * Sets Business Name.
     * The name of the location's overall business. This name is present on receipts and other customer-
     * facing branding.
     *
     * @maps business_name
     */
    public function setBusinessName(?string $businessName): void
    {
        $this->businessName['value'] = $businessName;
    }

    /**
     * Unsets Business Name.
     * The name of the location's overall business. This name is present on receipts and other customer-
     * facing branding.
     */
    public function unsetBusinessName(): void
    {
        $this->businessName = [];
    }

    /**
     * Returns Type.
     * A location's type.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Sets Type.
     * A location's type.
     *
     * @maps type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * Returns Website Url.
     * The website URL of the location.  For example, `https://squareup.com`.
     */
    public function getWebsiteUrl(): ?string
    {
        if (count($this->websiteUrl) == 0) {
            return null;
        }
        return $this->websiteUrl['value'];
    }

    /**
     * Sets Website Url.
     * The website URL of the location.  For example, `https://squareup.com`.
     *
     * @maps website_url
     */
    public function setWebsiteUrl(?string $websiteUrl): void
    {
        $this->websiteUrl['value'] = $websiteUrl;
    }

    /**
     * Unsets Website Url.
     * The website URL of the location.  For example, `https://squareup.com`.
     */
    public function unsetWebsiteUrl(): void
    {
        $this->websiteUrl = [];
    }

    /**
     * Returns Business Hours.
     * The hours of operation for a location.
     */
    public function getBusinessHours(): ?BusinessHours
    {
        return $this->businessHours;
    }

    /**
     * Sets Business Hours.
     * The hours of operation for a location.
     *
     * @maps business_hours
     */
    public function setBusinessHours(?BusinessHours $businessHours): void
    {
        $this->businessHours = $businessHours;
    }

    /**
     * Returns Business Email.
     * The email address of the location. This can be unique to the location and is not always the email
     * address for the business owner or administrator.
     */
    public function getBusinessEmail(): ?string
    {
        if (count($this->businessEmail) == 0) {
            return null;
        }
        return $this->businessEmail['value'];
    }

    /**
     * Sets Business Email.
     * The email address of the location. This can be unique to the location and is not always the email
     * address for the business owner or administrator.
     *
     * @maps business_email
     */
    public function setBusinessEmail(?string $businessEmail): void
    {
        $this->businessEmail['value'] = $businessEmail;
    }

    /**
     * Unsets Business Email.
     * The email address of the location. This can be unique to the location and is not always the email
     * address for the business owner or administrator.
     */
    public function unsetBusinessEmail(): void
    {
        $this->businessEmail = [];
    }

    /**
     * Returns Description.
     * The description of the location. For example, `Main Street location`.
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
     * The description of the location. For example, `Main Street location`.
     *
     * @maps description
     */
    public function setDescription(?string $description): void
    {
        $this->description['value'] = $description;
    }

    /**
     * Unsets Description.
     * The description of the location. For example, `Main Street location`.
     */
    public function unsetDescription(): void
    {
        $this->description = [];
    }

    /**
     * Returns Twitter Username.
     * The Twitter username of the location without the '@' symbol. For example, `Square`.
     */
    public function getTwitterUsername(): ?string
    {
        if (count($this->twitterUsername) == 0) {
            return null;
        }
        return $this->twitterUsername['value'];
    }

    /**
     * Sets Twitter Username.
     * The Twitter username of the location without the '@' symbol. For example, `Square`.
     *
     * @maps twitter_username
     */
    public function setTwitterUsername(?string $twitterUsername): void
    {
        $this->twitterUsername['value'] = $twitterUsername;
    }

    /**
     * Unsets Twitter Username.
     * The Twitter username of the location without the '@' symbol. For example, `Square`.
     */
    public function unsetTwitterUsername(): void
    {
        $this->twitterUsername = [];
    }

    /**
     * Returns Instagram Username.
     * The Instagram username of the location without the '@' symbol. For example, `square`.
     */
    public function getInstagramUsername(): ?string
    {
        if (count($this->instagramUsername) == 0) {
            return null;
        }
        return $this->instagramUsername['value'];
    }

    /**
     * Sets Instagram Username.
     * The Instagram username of the location without the '@' symbol. For example, `square`.
     *
     * @maps instagram_username
     */
    public function setInstagramUsername(?string $instagramUsername): void
    {
        $this->instagramUsername['value'] = $instagramUsername;
    }

    /**
     * Unsets Instagram Username.
     * The Instagram username of the location without the '@' symbol. For example, `square`.
     */
    public function unsetInstagramUsername(): void
    {
        $this->instagramUsername = [];
    }

    /**
     * Returns Facebook Url.
     * The Facebook profile URL of the location. The URL should begin with 'facebook.com/'. For example,
     * `https://www.facebook.com/square`.
     */
    public function getFacebookUrl(): ?string
    {
        if (count($this->facebookUrl) == 0) {
            return null;
        }
        return $this->facebookUrl['value'];
    }

    /**
     * Sets Facebook Url.
     * The Facebook profile URL of the location. The URL should begin with 'facebook.com/'. For example,
     * `https://www.facebook.com/square`.
     *
     * @maps facebook_url
     */
    public function setFacebookUrl(?string $facebookUrl): void
    {
        $this->facebookUrl['value'] = $facebookUrl;
    }

    /**
     * Unsets Facebook Url.
     * The Facebook profile URL of the location. The URL should begin with 'facebook.com/'. For example,
     * `https://www.facebook.com/square`.
     */
    public function unsetFacebookUrl(): void
    {
        $this->facebookUrl = [];
    }

    /**
     * Returns Coordinates.
     * Latitude and longitude coordinates.
     */
    public function getCoordinates(): ?Coordinates
    {
        return $this->coordinates;
    }

    /**
     * Sets Coordinates.
     * Latitude and longitude coordinates.
     *
     * @maps coordinates
     */
    public function setCoordinates(?Coordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

    /**
     * Returns Logo Url.
     * The URL of the logo image for the location. When configured in the Seller
     * Dashboard (Receipts section), the logo appears on transactions (such as receipts and invoices) that
     * Square generates on behalf of the seller.
     * This image should have a roughly square (1:1) aspect ratio and should be at least 200x200 pixels.
     */
    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    /**
     * Sets Logo Url.
     * The URL of the logo image for the location. When configured in the Seller
     * Dashboard (Receipts section), the logo appears on transactions (such as receipts and invoices) that
     * Square generates on behalf of the seller.
     * This image should have a roughly square (1:1) aspect ratio and should be at least 200x200 pixels.
     *
     * @maps logo_url
     */
    public function setLogoUrl(?string $logoUrl): void
    {
        $this->logoUrl = $logoUrl;
    }

    /**
     * Returns Pos Background Url.
     * The URL of the Point of Sale background image for the location.
     */
    public function getPosBackgroundUrl(): ?string
    {
        return $this->posBackgroundUrl;
    }

    /**
     * Sets Pos Background Url.
     * The URL of the Point of Sale background image for the location.
     *
     * @maps pos_background_url
     */
    public function setPosBackgroundUrl(?string $posBackgroundUrl): void
    {
        $this->posBackgroundUrl = $posBackgroundUrl;
    }

    /**
     * Returns Mcc.
     * A four-digit number that describes the kind of goods or services sold at the location.
     * The [merchant category code (MCC)](https://developer.squareup.com/docs/locations-api#initialize-a-
     * merchant-category-code) of the location as standardized by ISO 18245.
     * For example, `5045`, for a location that sells computer goods and software.
     */
    public function getMcc(): ?string
    {
        if (count($this->mcc) == 0) {
            return null;
        }
        return $this->mcc['value'];
    }

    /**
     * Sets Mcc.
     * A four-digit number that describes the kind of goods or services sold at the location.
     * The [merchant category code (MCC)](https://developer.squareup.com/docs/locations-api#initialize-a-
     * merchant-category-code) of the location as standardized by ISO 18245.
     * For example, `5045`, for a location that sells computer goods and software.
     *
     * @maps mcc
     */
    public function setMcc(?string $mcc): void
    {
        $this->mcc['value'] = $mcc;
    }

    /**
     * Unsets Mcc.
     * A four-digit number that describes the kind of goods or services sold at the location.
     * The [merchant category code (MCC)](https://developer.squareup.com/docs/locations-api#initialize-a-
     * merchant-category-code) of the location as standardized by ISO 18245.
     * For example, `5045`, for a location that sells computer goods and software.
     */
    public function unsetMcc(): void
    {
        $this->mcc = [];
    }

    /**
     * Returns Full Format Logo Url.
     * The URL of a full-format logo image for the location. When configured in the Seller
     * Dashboard (Receipts section), the logo appears on transactions (such as receipts and invoices) that
     * Square generates on behalf of the seller.
     * This image can be wider than it is tall and should be at least 1280x648 pixels.
     */
    public function getFullFormatLogoUrl(): ?string
    {
        return $this->fullFormatLogoUrl;
    }

    /**
     * Sets Full Format Logo Url.
     * The URL of a full-format logo image for the location. When configured in the Seller
     * Dashboard (Receipts section), the logo appears on transactions (such as receipts and invoices) that
     * Square generates on behalf of the seller.
     * This image can be wider than it is tall and should be at least 1280x648 pixels.
     *
     * @maps full_format_logo_url
     */
    public function setFullFormatLogoUrl(?string $fullFormatLogoUrl): void
    {
        $this->fullFormatLogoUrl = $fullFormatLogoUrl;
    }

    /**
     * Returns Tax Ids.
     * Identifiers for the location used by various governments for tax purposes.
     */
    public function getTaxIds(): ?TaxIds
    {
        return $this->taxIds;
    }

    /**
     * Sets Tax Ids.
     * Identifiers for the location used by various governments for tax purposes.
     *
     * @maps tax_ids
     */
    public function setTaxIds(?TaxIds $taxIds): void
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
            $json['id']                   = $this->id;
        }
        if (!empty($this->name)) {
            $json['name']                 = $this->name['value'];
        }
        if (isset($this->address)) {
            $json['address']              = $this->address;
        }
        if (!empty($this->timezone)) {
            $json['timezone']             = $this->timezone['value'];
        }
        if (isset($this->capabilities)) {
            $json['capabilities']         = $this->capabilities;
        }
        if (isset($this->status)) {
            $json['status']               = $this->status;
        }
        if (isset($this->createdAt)) {
            $json['created_at']           = $this->createdAt;
        }
        if (isset($this->merchantId)) {
            $json['merchant_id']          = $this->merchantId;
        }
        if (isset($this->country)) {
            $json['country']              = $this->country;
        }
        if (!empty($this->languageCode)) {
            $json['language_code']        = $this->languageCode['value'];
        }
        if (isset($this->currency)) {
            $json['currency']             = $this->currency;
        }
        if (!empty($this->phoneNumber)) {
            $json['phone_number']         = $this->phoneNumber['value'];
        }
        if (!empty($this->businessName)) {
            $json['business_name']        = $this->businessName['value'];
        }
        if (isset($this->type)) {
            $json['type']                 = $this->type;
        }
        if (!empty($this->websiteUrl)) {
            $json['website_url']          = $this->websiteUrl['value'];
        }
        if (isset($this->businessHours)) {
            $json['business_hours']       = $this->businessHours;
        }
        if (!empty($this->businessEmail)) {
            $json['business_email']       = $this->businessEmail['value'];
        }
        if (!empty($this->description)) {
            $json['description']          = $this->description['value'];
        }
        if (!empty($this->twitterUsername)) {
            $json['twitter_username']     = $this->twitterUsername['value'];
        }
        if (!empty($this->instagramUsername)) {
            $json['instagram_username']   = $this->instagramUsername['value'];
        }
        if (!empty($this->facebookUrl)) {
            $json['facebook_url']         = $this->facebookUrl['value'];
        }
        if (isset($this->coordinates)) {
            $json['coordinates']          = $this->coordinates;
        }
        if (isset($this->logoUrl)) {
            $json['logo_url']             = $this->logoUrl;
        }
        if (isset($this->posBackgroundUrl)) {
            $json['pos_background_url']   = $this->posBackgroundUrl;
        }
        if (!empty($this->mcc)) {
            $json['mcc']                  = $this->mcc['value'];
        }
        if (isset($this->fullFormatLogoUrl)) {
            $json['full_format_logo_url'] = $this->fullFormatLogoUrl;
        }
        if (isset($this->taxIds)) {
            $json['tax_ids']              = $this->taxIds;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
