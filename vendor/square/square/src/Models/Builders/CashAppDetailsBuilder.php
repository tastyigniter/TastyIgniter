<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CashAppDetails;

/**
 * Builder for model CashAppDetails
 *
 * @see CashAppDetails
 */
class CashAppDetailsBuilder
{
    /**
     * @var CashAppDetails
     */
    private $instance;

    private function __construct(CashAppDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new cash app details Builder object.
     */
    public static function init(): self
    {
        return new self(new CashAppDetails());
    }

    /**
     * Sets buyer full name field.
     */
    public function buyerFullName(?string $value): self
    {
        $this->instance->setBuyerFullName($value);
        return $this;
    }

    /**
     * Unsets buyer full name field.
     */
    public function unsetBuyerFullName(): self
    {
        $this->instance->unsetBuyerFullName();
        return $this;
    }

    /**
     * Sets buyer country code field.
     */
    public function buyerCountryCode(?string $value): self
    {
        $this->instance->setBuyerCountryCode($value);
        return $this;
    }

    /**
     * Unsets buyer country code field.
     */
    public function unsetBuyerCountryCode(): self
    {
        $this->instance->unsetBuyerCountryCode();
        return $this;
    }

    /**
     * Sets buyer cashtag field.
     */
    public function buyerCashtag(?string $value): self
    {
        $this->instance->setBuyerCashtag($value);
        return $this;
    }

    /**
     * Initializes a new cash app details object.
     */
    public function build(): CashAppDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
