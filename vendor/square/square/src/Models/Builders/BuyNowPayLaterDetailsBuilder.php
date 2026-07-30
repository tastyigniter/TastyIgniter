<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\AfterpayDetails;
use Square\Models\BuyNowPayLaterDetails;
use Square\Models\ClearpayDetails;

/**
 * Builder for model BuyNowPayLaterDetails
 *
 * @see BuyNowPayLaterDetails
 */
class BuyNowPayLaterDetailsBuilder
{
    /**
     * @var BuyNowPayLaterDetails
     */
    private $instance;

    private function __construct(BuyNowPayLaterDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new buy now pay later details Builder object.
     */
    public static function init(): self
    {
        return new self(new BuyNowPayLaterDetails());
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
     * Sets afterpay details field.
     */
    public function afterpayDetails(?AfterpayDetails $value): self
    {
        $this->instance->setAfterpayDetails($value);
        return $this;
    }

    /**
     * Sets clearpay details field.
     */
    public function clearpayDetails(?ClearpayDetails $value): self
    {
        $this->instance->setClearpayDetails($value);
        return $this;
    }

    /**
     * Initializes a new buy now pay later details object.
     */
    public function build(): BuyNowPayLaterDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
