<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\Money;
use Square\Models\TenderCashDetails;

/**
 * Builder for model TenderCashDetails
 *
 * @see TenderCashDetails
 */
class TenderCashDetailsBuilder
{
    /**
     * @var TenderCashDetails
     */
    private $instance;

    private function __construct(TenderCashDetails $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new tender cash details Builder object.
     */
    public static function init(): self
    {
        return new self(new TenderCashDetails());
    }

    /**
     * Sets buyer tendered money field.
     */
    public function buyerTenderedMoney(?Money $value): self
    {
        $this->instance->setBuyerTenderedMoney($value);
        return $this;
    }

    /**
     * Sets change back money field.
     */
    public function changeBackMoney(?Money $value): self
    {
        $this->instance->setChangeBackMoney($value);
        return $this;
    }

    /**
     * Initializes a new tender cash details object.
     */
    public function build(): TenderCashDetails
    {
        return CoreHelper::clone($this->instance);
    }
}
