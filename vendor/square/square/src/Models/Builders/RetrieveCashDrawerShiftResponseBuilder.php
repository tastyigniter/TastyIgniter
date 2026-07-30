<?php

declare(strict_types=1);

namespace Square\Models\Builders;

use Core\Utils\CoreHelper;
use Square\Models\CashDrawerShift;
use Square\Models\RetrieveCashDrawerShiftResponse;

/**
 * Builder for model RetrieveCashDrawerShiftResponse
 *
 * @see RetrieveCashDrawerShiftResponse
 */
class RetrieveCashDrawerShiftResponseBuilder
{
    /**
     * @var RetrieveCashDrawerShiftResponse
     */
    private $instance;

    private function __construct(RetrieveCashDrawerShiftResponse $instance)
    {
        $this->instance = $instance;
    }

    /**
     * Initializes a new retrieve cash drawer shift response Builder object.
     */
    public static function init(): self
    {
        return new self(new RetrieveCashDrawerShiftResponse());
    }

    /**
     * Sets cash drawer shift field.
     */
    public function cashDrawerShift(?CashDrawerShift $value): self
    {
        $this->instance->setCashDrawerShift($value);
        return $this;
    }

    /**
     * Sets errors field.
     */
    public function errors(?array $value): self
    {
        $this->instance->setErrors($value);
        return $this;
    }

    /**
     * Initializes a new retrieve cash drawer shift response object.
     */
    public function build(): RetrieveCashDrawerShiftResponse
    {
        return CoreHelper::clone($this->instance);
    }
}
