<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\BusinessHours;
use Square\Models\Coordinates;
use Square\Models\Location;
use Square\Models\TaxIds;

/**
 * Builder for model Location
 *
 * @see Location
 */
class LocationBuilder
{
    /**
     * @var Location
     */
    private $instance;

    private function __construct(Location $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new location Builder object.
     */
    public static function init(): self
    {
        return new self(new Location());
    }

    /**
     * Sets id field.
     */
    public function id(?string $value): self
    {
        $this->instance->setId($value);
        return $this;
    }

    /**
     * Sets name field.
     */
    public function name(?string $value): self
    {
        $this->instance->setName($value);
        return $this;
    }

    /**
     * Unsets name field.
     */
    public function unsetName(): self
    {
        $this->instance->unsetName();
        return $this;
    }

    /**
     * Sets address field.
     */
    public function address(?Address $value): self
    {
        $this->instance->setAddress($value);
        return $this;
    }

    /**
     * Sets timezone field.
     */
    public function timezone(?string $value): self
    {
        $this->instance->setTimezone($value);
        return $this;
    }

    /**
     * Unsets timezone field.
     */
    public function unsetTimezone(): self
    {
        $this->instance->unsetTimezone();
        return $this;
    }

    /**
     * Sets capabilities field.
     */
    public function capabilities(?array $value): self
    {
        $this->instance->setCapabilities($value);
        return $this;
    }

    /**
     * Sets status field.
     */
    public function status(?string $value): self
    {
        $this->instance->setStatus($value);
        return $this;
    }

    /**
     * Sets created at field.
     */
    public function createdAt(?string $value): self
    {
        $this->instance->setCreatedAt($value);
        return $this;
    }

    /**
     * Sets merchant id field.
     */
    public function merchantId(?string $value): self
    {
        $this->instance->setMerchantId($value);
        return $this;
    }

    /**
     * Sets country field.
     */
    public function country(?string $value): self
    {
        $this->instance->setCountry($value);
        return $this;
    }

    /**
     * Sets language code field.
     */
    public function languageCode(?string $value): self
    {
        $this->instance->setLanguageCode($value);
        return $this;
    }

    /**
     * Unsets language code field.
     */
    public function unsetLanguageCode(): self
    {
        $this->instance->unsetLanguageCode();
        return $this;
    }

    /**
     * Sets currency field.
     */
    public function currency(?string $value): self
    {
        $this->instance->setCurrency($value);
        return $this;
    }

    /**
     * Sets phone number field.
     */
    public function phoneNumber(?string $value): self
    {
        $this->instance->setPhoneNumber($value);
        return $this;
    }

    /**
     * Unsets phone number field.
     */
    public function unsetPhoneNumber(): self
    {
        $this->instance->unsetPhoneNumber();
        return $this;
    }

    /**
     * Sets business name field.
     */
    public function businessName(?string $value): self
    {
        $this->instance->setBusinessName($value);
        return $this;
    }

    /**
     * Unsets business name field.
     */
    public function unsetBusinessName(): self
    {
        $this->instance->unsetBusinessName();
        return $this;
    }

    /**
     * Sets type field.
     */
    public function type(?string $value): self
    {
        $this->instance->setType($value);
        return $this;
    }

    /**
     * Sets website url field.
     */
    public function websiteUrl(?string $value): self
    {
        $this->instance->setWebsiteUrl($value);
        return $this;
    }

    /**
     * Unsets website url field.
     */
    public function unsetWebsiteUrl(): self
    {
        $this->instance->unsetWebsiteUrl();
        return $this;
    }

    /**
     * Sets business hours field.
     */
    public function businessHours(?BusinessHours $value): self
    {
        $this->instance->setBusinessHours($value);
        return $this;
    }

    /**
     * Sets business email field.
     */
    public function businessEmail(?string $value): self
    {
        $this->instance->setBusinessEmail($value);
        return $this;
    }

    /**
     * Unsets business email field.
     */
    public function unsetBusinessEmail(): self
    {
        $this->instance->unsetBusinessEmail();
        return $this;
    }

    /**
     * Sets description field.
     */
    public function description(?string $value): self
    {
        $this->instance->setDescription($value);
        return $this;
    }

    /**
     * Unsets description field.
     */
    public function unsetDescription(): self
    {
        $this->instance->unsetDescription();
        return $this;
    }

    /**
     * Sets twitter username field.
     */
    public function twitterUsername(?string $value): self
    {
        $this->instance->setTwitterUsername($value);
        return $this;
    }

    /**
     * Unsets twitter username field.
     */
    public function unsetTwitterUsername(): self
    {
        $this->instance->unsetTwitterUsername();
        return $this;
    }

    /**
     * Sets instagram username field.
     */
    public function instagramUsername(?string $value): self
    {
        $this->instance->setInstagramUsername($value);
        return $this;
    }

    /**
     * Unsets instagram username field.
     */
    public function unsetInstagramUsername(): self
    {
        $this->instance->unsetInstagramUsername();
        return $this;
    }

    /**
     * Sets facebook url field.
     */
    public function facebookUrl(?string $value): self
    {
        $this->instance->setFacebookUrl($value);
        return $this;
    }

    /**
     * Unsets facebook url field.
     */
    public function unsetFacebookUrl(): self
    {
        $this->instance->unsetFacebookUrl();
        return $this;
    }

    /**
     * Sets coordinates field.
     */
    public function coordinates(?Coordinates $value): self
    {
        $this->instance->setCoordinates($value);
        return $this;
    }

    /**
     * Sets logo url field.
     */
    public function logoUrl(?string $value): self
    {
        $this->instance->setLogoUrl($value);
        return $this;
    }

    /**
     * Sets pos background url field.
     */
    public function posBackgroundUrl(?string $value): self
    {
        $this->instance->setPosBackgroundUrl($value);
        return $this;
    }

    /**
     * Sets mcc field.
     */
    public function mcc(?string $value): self
    {
        $this->instance->setMcc($value);
        return $this;
    }

    /**
     * Unsets mcc field.
     */
    public function unsetMcc(): self
    {
        $this->instance->unsetMcc();
        return $this;
    }

    /**
     * Sets full format logo url field.
     */
    public function fullFormatLogoUrl(?string $value): self
    {
        $this->instance->setFullFormatLogoUrl($value);
        return $this;
    }

    /**
     * Sets tax ids field.
     */
    public function taxIds(?TaxIds $value): self
    {
        $this->instance->setTaxIds($value);
        return $this;
    }

    /**
     * Initializes a new location object.
     */
    public function build(): Location
    {
        return CoreHelper::clone($this->instance);
    }
}
