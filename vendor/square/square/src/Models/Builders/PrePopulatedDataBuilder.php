<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Address;
use Square\Models\PrePopulatedData;

/**
 * Builder for model PrePopulatedData
 *
 * @see PrePopulatedData
 */
class PrePopulatedDataBuilder
{
    /**
     * @var PrePopulatedData
     */
    private $instance;

    private function __construct(PrePopulatedData $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new pre populated data Builder object.
     */
    public static function init(): self
    {
        return new self(new PrePopulatedData());
    }

    /**
     * Sets buyer email field.
     */
    public function buyerEmail(?string $value): self
    {
        $this->instance->setBuyerEmail($value);
        return $this;
    }

    /**
     * Unsets buyer email field.
     */
    public function unsetBuyerEmail(): self
    {
        $this->instance->unsetBuyerEmail();
        return $this;
    }

    /**
     * Sets buyer phone number field.
     */
    public function buyerPhoneNumber(?string $value): self
    {
        $this->instance->setBuyerPhoneNumber($value);
        return $this;
    }

    /**
     * Unsets buyer phone number field.
     */
    public function unsetBuyerPhoneNumber(): self
    {
        $this->instance->unsetBuyerPhoneNumber();
        return $this;
    }

    /**
     * Sets buyer address field.
     */
    public function buyerAddress(?Address $value): self
    {
        $this->instance->setBuyerAddress($value);
        return $this;
    }

    /**
     * Initializes a new pre populated data object.
     */
    public function build(): PrePopulatedData
    {
        return CoreHelper::clone($this->instance);
    }
}
