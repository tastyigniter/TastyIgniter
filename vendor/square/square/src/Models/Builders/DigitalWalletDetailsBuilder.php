<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CashAppDetails;
use Square\Models\DigitalWalletDetails;

/**
 * Builder for model DigitalWalletDetails
 *
 * @see DigitalWalletDetails
 */
class DigitalWalletDetailsBuilder
{
    /**
     * @var DigitalWalletDetails
     */
    private $instance;

    private function __construct(DigitalWalletDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new digital wallet details Builder object.
     */
    public static function init(): self
    {
        return new self(new DigitalWalletDetails());
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
     * Unsets status field.
     */
    public function unsetStatus(): self
    {
        $this->instance->unsetStatus();
        return $this;
    }

    /**
     * Sets brand field.
     */
    public function brand(?string $value): self
    {
        $this->instance->setBrand($value);
        return $this;
    }

    /**
     * Unsets brand field.
     */
    public function unsetBrand(): self
    {
        $this->instance->unsetBrand();
        return $this;
    }

    /**
     * Sets cash app details field.
     */
    public function cashAppDetails(?CashAppDetails $value): self
    {
        $this->instance->setCashAppDetails($value);
        return $this;
    }

    /**
     * Initializes a new digital wallet details object.
     */
    public function build(): DigitalWalletDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
